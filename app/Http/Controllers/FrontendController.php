<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{

    public function login()
    {
        if (Helpers::getCookieLogin()) {
            return redirect(route('frontend.home'));
        }
        return view('frontend.login');
    }

    public function postLogin(Request $request)
    {
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
            return redirect(route('frontend.login'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            $validator->getMessageBag()->add('email', 'Tài khoản không tồn tại!');
            return redirect(route('frontend.login'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        if (!Hash::check($data['password'], $user->getAuthPassword())) {
            $validator->getMessageBag()->add('password', 'Mật khẩu không đúng xin thử lại!');
            return redirect(route('frontend.login'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        Helpers::setCookieLogin($user->email);
        return redirect(route('frontend.home'));
    }

    public function index()
    {
        $page = 'index';
        return view('frontend.index', compact('page'));

    }

    public function home()
    {
        $page = 'home';
        if (!Helpers::getCookieLogin()) {
            return redirect(route('frontend.login'));
        }
        //$account = User::where('email', Helpers::getCookieLogin())->first();

        return view('frontend.home', compact( 'page'));
    }

    public function logout()
    {
        Helpers::deleteCookieLogin();
        return redirect(route('frontend.index'));
    }


    /*
     * For testing graph
     */
    public function indexTest()
    {

        $mappingCharacters = [
            'GIA_DINH' => 'Gia đình',
            'SANG_TAO' => 'Sáng tạo',
            'THI_TRUONG' => 'Thị trường',
            'KIEM_SOAT' => 'Kiểm soát',
            'COT_1' => 'Đánh giá 2018 - 2020',
            'COT_2' => 'Đánh giá 2020 - 2022',
        ];


        $data = [
            'clan' => [
               'current' => 32.50,
               'preferred' => 30
            ],
            'adhocracy' => [
                'current' => 25,
                'preferred' => 36.67
            ],
            'market' => [
                'current' => 17.78,
                'preferred' => 16.39
            ],
            'hierarchy' => [
                'current' => 24.72,
                'preferred' => 16.94
            ],
        ];

        return view('index');
    }
}
