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
use Illuminate\Support\Str;

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

        $data =  $request->only(['email', 'password', 'name']);

        $rules = [
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
        ];

        $validator = Validator::make($data , $rules, $messages);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect(route('frontend.register'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $customer = Customer::where('email', trim($data['email']))->first();

        if ($customer) {
            $validator->getMessageBag()->add('email', 'Tài khoản đã tồn tại!');
            return redirect(route('frontend.register'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        try {
            $data['status'] = false;
            $data['token'] = Str::uuid();
            $customer = Customer::create($data);
            //auth()->login($customer);
            Helpers::sendMailNewRegister($customer);
            $request->session()->flash('general_message', 'Đăng ký thành công xin kiểm tra email kích hoạt!');
            return redirect(route('frontend.index'));
        } catch (\Exception $exception) {
            $validator->getMessageBag()->add('email', $exception->getMessage());
            return redirect(route('frontend.register'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

    }

    public function active(Request $request)
    {

        $token = $request->input('token');

        if (!$token) {
            $request->session()->flash('general_message', 'Không có mã kích hoạt!');
            return redirect(route('frontend.index'));
        }

        $customer = Customer::where('token', $token)->first();

        if (!$customer) {
            $request->session()->flash('general_message', 'Mã kích hoạt không hợp lệ!');
            return redirect(route('frontend.index'));
        }

        if ($customer->status) {
            $request->session()->flash('general_message', 'Tài khoản đã được kích hoạt!');
            return redirect(route('frontend.index'));
        }

        try {
            $customer->update([
                'status' => true,
                'token' => null
            ]);
            $request->session()->flash('general_message', 'Tài khoản đã được kích hoạt thành công! Xin hãy đăng nhập!');
            return redirect(route('frontend.index'));
        } catch (\Exception $exception) {
            $request->session()->flash('general_message', 'Có lỗi xảy ra khi kích hoạt : '.$exception->getMessage().'. Xin thử lại!');
            return redirect(route('frontend.index'));
        }

    }

    public function postLogin(Request $request)
    {
        if (auth()->check()) {
            return redirect(route('frontend.home'));
        }

        $data =  $request->only(['email', 'password']);

        $rules = [
            'email' => 'required',
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

        $customer = Customer::where('email', trim($data['email']))->first();

        if (!$customer || !$customer->status) {
            $validator->getMessageBag()->add('email', 'Tài khoản không tồn tại hoặc chưa kích hoạt!');
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

        $data =  $request->only(['email']);

        $rules = [
            'email' => 'required'
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

        $customer = Customer::where('email', trim($data['email']))->first();

        if (!$customer || !$customer->status) {
            $validator->getMessageBag()->add('email', 'Tài khoản không tồn tại hoặc chưa kích hoạt!');
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

    public function intro()
    {
        $page = 'intro';
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
        return view('frontend.intro', compact( 'page'));
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
