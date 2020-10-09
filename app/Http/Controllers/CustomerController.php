<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect(route('frontend.home'));
        }
        //return view('frontend.login');
        // now login and index in same page.
        return redirect(route('frontend.index'));
    }

    public function postReg(Request $request)
    {
        if (auth()->check()) {
            return redirect(route('frontend.home'));
        }

        $data =  $request->only(['login', 'password', 'name']);

        $rules = [
            'login' => 'required',
            'password' => 'required',
            'name' => 'required',
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
        ];

        $validator = Validator::make($data , $rules, $messages);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect(route('frontend.index').'?showReg=1')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $customer = Customer::where('login', trim($data['login']))->first();

        if ($customer) {
            $validator->getMessageBag()->add('login', 'Tài khoản đã tồn tại!');
            return redirect(route('frontend.register'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        try {
            $customer = Customer::create($data);
            auth()->login($customer);
            return redirect(route('frontend.home'));
        } catch (\Exception $exception) {
            $validator->getMessageBag()->add('login', $exception->getMessage());
            return redirect(route('frontend.register'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

    }

    public function postLogin(Request $request)
    {
        if (auth()->check()) {
            return redirect(route('frontend.home'));
        }

        $data =  $request->only(['login', 'password']);

        $rules = [
            'login' => 'required',
            'password' => 'required'
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
        ];

        $validator = Validator::make($data , $rules, $messages);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect(route('frontend.index'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $customer = Customer::where('login', trim($data['login']))->first();

        if (!$customer || !$customer->status) {
            $validator->getMessageBag()->add('login', 'Tài khoản không tồn tại hoặc chưa kích hoạt!');
            return redirect(route('frontend.index'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        if ($data['password'] != $customer->password) {
            $validator->getMessageBag()->add('password', 'Mật khẩu không đúng xin thử lại!');
            return redirect(route('frontend.index'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        auth()->login($customer);

        return redirect(route('frontend.home'));
    }

    public function postForgot(Request $request)
    {
        if (auth()->check()) {
            return redirect(route('frontend.home'));
        }

        $data =  $request->only(['login']);

        $rules = [
            'login' => 'required'
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
        ];

        $validator = Validator::make($data , $rules, $messages);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect(route('frontend.forgot_pass'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $customer = Customer::where('login', trim($data['login']))->first();

        if (!$customer || !$customer->status) {
            $validator->getMessageBag()->add('login', 'Tài khoản không tồn tại hoặc chưa kích hoạt!');
            return redirect(route('frontend.forgot_pass'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        if (!$customer->email) {
            $validator->getMessageBag()->add('login', 'Tài khoản chưa có thông tin email!');
            return redirect(route('frontend.forgot_pass'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        //TODO improve forgot password by send email to user, but user must have email

        return redirect(route('frontend.home'));
    }

    public function register()
    {
        if (auth()->check()) {
            return redirect(route('frontend.home'));
        }
        $page = 'register';
        return view('frontend.register', compact('page'));
    }

    public function forgotPass()
    {
        if (auth()->check()) {
            return redirect(route('frontend.home'));
        }
        $page = 'forgot';
        return view('frontend.forgot', compact('page'));
    }

    public function index()
    {
        if (auth()->check()) {
            return redirect(route('frontend.home'));
        }
        $page = 'index';
        return view('frontend.index', compact('page'));

    }

    public function home()
    {
        $page = 'home';
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
        $surveys = Helpers::getSurveyForLoginUser();
        $latestCanDoSurvey = Helpers::getLatestSurveyCanDoForUser();
        return view('frontend.home', compact( 'page', 'surveys', 'latestCanDoSurvey'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect(route('frontend.index'));
    }

    public function individual()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        $customer = Customer::find(auth()->user()->id);
        $surveys = Helpers::getSurveyForLoginUser();

        return view('frontend.individual', compact('customer', 'surveys'));
    }

    public function personal(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        $customerId = auth()->user()->id;

        if ($request->input('id')) {

            $customerId = $request->input('id');

            if (!Helpers::currentFrontendUserIsManager()) {
                return redirect(route('frontend.home'));
            }
        }

        $customer = Customer::find($customerId);

        return view('frontend.personal', compact('customer'));
    }

    public function postPersonal(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        Helpers::log($request->all());

        $update_fields = [
            'name',
            'email',
            'phone',
            //'avatar',
            'gender',
        ];

        $customerId = auth()->user()->id;

        if ($request->input('customer_id')) {
            $customerId = $request->input('customer_id');
            if (!Helpers::currentFrontendUserIsManager()) {
                return redirect(route('frontend.home'));
            }
        }

        $customer = Customer::find($customerId);

        foreach ($update_fields as $field) {

            $value = $request->input($field);

            if ($value) {
                try  {
                    $customer->update([
                        $field => $value
                    ]);
                } catch (\Exception $exception) {
                    //pass
                }
            }
        }



        if ($file = $request->file('avatar')) {
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, $filename);

            try  {
                $customer->update([
                    'avatar' => 'uploads/'.$filename
                ]);
            } catch (\Exception $exception) {
                //pass
            }
        }

        return redirect(route('frontend.personal').'?id='.$customerId);
    }
}
