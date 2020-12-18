<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Question;
use App\Models\Survey;
use Carbon\Carbon;
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
            'password' => 'required|min:6',
            'name' => 'required',
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
            'min' => 'Độ dài :attribute phải ít nhất 6 ký tự.',
        ];

        $attributes = [
            'email' => 'Email đăng nhập',
            'password' => 'Mật khẩu',
            'name' => 'Họ Tên',
        ];

        $validator = Validator::make($data , $rules, $messages, $attributes);
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

            $defaultCompany = Helpers::getDefaultCompany();

            $data['status'] = false;
            $data['token'] = Str::uuid();
            $data['company_id'] = $defaultCompany->id;
            $customer = Customer::create($data);
            //auth()->login($customer);
            Helpers::sendMailNewRegister($customer);
            Helpers::setFlashMessage('Đăng ký thành công xin kiểm tra email kích hoạt!');
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

    public function forget(Request $request)
    {

        $token = $request->input('token');

        if (!$token) {
            $request->session()->flash('general_message', 'Không có mã lấy lại mật khẩu!');
            return redirect(route('frontend.index'));
        }

        $customer = Customer::where('token', $token)->first();

        if (!$customer || !$customer->status) {
            $request->session()->flash('general_message', 'Mã lấy lại mật khẩu không hợp lệ hoặc tài khoản chưa được kích hoạt!');
            return redirect(route('frontend.index'));
        }

        $page = 'forget';
        return view('frontend.forget', compact('page', 'token'));

    }

    public function postForget(Request $request)
    {
        if (auth()->check()) {
            return redirect(route('frontend.home'));
        }

        $data =  $request->only(['password', 'password_confirm', 'forget_token']);

        $rules = [
            'password' => 'required',
            'password_confirm' => 'required',
            'forget_token' => 'required',
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
        ];

        $validator = Validator::make($data , $rules, $messages);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            $validator->getMessageBag()->add('password', 'Thiếu thông tin nhập vào!');
            return redirect(route('frontend.forget'))
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirm']));
        }

        $token = $request->input('forget_token');

        if (!$token) {
            $request->session()->flash('general_message', 'Không có mã lấy lại mật khẩu!');
            return redirect(route('frontend.forget'))
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirm']));
        }

        $password = $request->input('password');
        $passwordConfirm = $request->input('password_confirm');

        if ($password != $passwordConfirm) {
            $request->session()->flash('general_message', 'Mật khẩu xác nhận không trùng với mật khẩu mới!');
            return redirect(route('frontend.forget'))
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirm']));
        }

        $customer = Customer::where('token', $token)->first();

        if (!$customer || !$customer->status) {
            $request->session()->flash('general_message', 'Mã lấy lại mật khẩu không hợp lệ hoặc tài khoản chưa được kích hoạt!');
            return redirect(route('frontend.index'));
        }


        // Add token and send email

        try {
            $customer->update([
                'token' => null,
                'password' => $password
            ]);

            $request->session()->flash('general_message', 'Đổi mật khẩu mới thành công!');
            return redirect(route('frontend.index'));

        } catch (\Exception $exception) {
            $validator->getMessageBag()->add('password', 'Có lỗi xảy ra xin thử lại!');
            return redirect(route('frontend.forget'))
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirm']));
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
                ->withInput();
        }

        $customer = Customer::where('email', trim($data['email']))->first();

        if (!$customer || !$customer->status) {
            $validator->getMessageBag()->add('email', 'Tài khoản không tồn tại hoặc chưa kích hoạt!');
            return redirect(route('frontend.forgot_pass'))
                ->withErrors($validator)
                ->withInput();
        }

        // Add token and send email

        try {
            $customer->token = Str::uuid();
            $customer->save();
            Helpers::sendMailForgotPassword($customer);
            $request->session()->flash('general_message', 'Xin kiểm tra email để nhận mã lấy lại mật khẩu!');
            return redirect(route('frontend.index'));
        } catch (\Exception $exception) {
            $validator->getMessageBag()->add('email', 'Có lỗi xảy ra xin thử lại!');
            return redirect(route('frontend.forgot_pass'))
                ->withErrors($validator)
                ->withInput();
        }
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
        // check if first login

        $firstLogin = false;

        if (!auth()->user()->first_login_time) {
            try {
                Customer::find(auth()->user()->id)->update([
                    'first_login_time' => Carbon::now()->toDateTimeString()
                ]);
            } catch (\Exception $exception) {

            }
            $firstLogin = true;

            auth()->user()->first_login_time = Carbon::now()->toDateTimeString();
        }


        // hien thi khao sat da ket thuc
        $surveys = Helpers::getSurveyForLoginUser();
        $latestCanDoSurvey = Helpers::getLatestSurveyCanDoForUser();
        return view('frontend.home', compact( 'page', 'surveys', 'latestCanDoSurvey', 'firstLogin'))
            ->with(['section' => 'home', 'title' => 'Home']);
    }

    public function intro()
    {
        $page = 'intro';
        $section = 'home';
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
        return view('frontend.intro', compact( 'page', 'section'));
    }

    public function logout()
    {

        //clear demo survey

        if (Helpers::isDemoCustomer()) {
            Answer::where('customer_id', auth()->user()->id)->delete();
        }

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

        return view('frontend.individual', compact('customer', 'surveys'))
            ->with(['section' => 'home', 'title' => 'Danh sách khảo sát của bạn']);
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

        return view('frontend.personal', compact('customer'))
            ->with(['section' => 'home', 'title' => 'Thông tin cá nhân']);
    }

    public function postPersonal(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (Helpers::isDemoCustomer()) {
            Helpers::setFlashMessage('Tài khoản Demo không có quyền thực hiện tác vụ này!');
            return redirect(route('frontend.home'));
        }

        //Helpers::log($request->all());

        $update_fields = [
            'name',
            'phone',
            //'avatar',
            'gender',
            'password'
        ];

        $customerId = auth()->user()->id;
        if ($request->input('customer_id') != $customerId) {
            return redirect(route('frontend.home'));
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

        if ($data = $request->only('avatar')) {

            $rules = [
                'avatar' => 'max:1024|mimes:jpg,png,bmp,jpeg,gif'
            ];

            $messages = [
                'mimes' => 'File :attribute là file ảnh',
                'max' => 'File :attribute phải nhỏ hơn hoặc bằng 1MB',
            ];

            $attributes = [
                'avatar' => 'Ảnh đại diện',
            ];

            $validator = Validator::make($data , $rules, $messages, $attributes);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }


            $filename = $request->file('avatar')->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $request->file('avatar')->move($destinationPath, $filename);
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
