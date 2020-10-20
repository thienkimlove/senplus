<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Customer;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function redirectToGoogleProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleGoogleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        // $user->token;
        // All Providers
//        $user->getId();
//        $user->getNickname();
//        $user->getName();
//        $user->getEmail();
//        $user->getAvatar();

        $email = $user->getEmail();

        if (!$email) {
            Helpers::setFlashMessage('Không nhận được thông tin email từ Google. Xin thử lại!');
            return redirect(route('frontend.register'));
        }

        $customer = Customer::where('email', $email)->first();

        if ($customer) {
            if (!$customer->status) {
                Helpers::setFlashMessage('Email đã tồn tại trong hệ thống nhưng chưa được kích hoạt!');
                return redirect(route('frontend.register'));
            }

            auth()->login($customer);
            return redirect(route('frontend.home'));
        }

        //create customer.

        $name = $user->getName();
        $pass = Helpers::getRandomString();

        try {
            $customer = Customer::create([
                'email' => $email,
                'name' => $name,
                'password' => $pass,
                'company_id' => Helpers::getDefaultCompany()->id,
                'status' => true
            ]);
            Helpers::sendMailNewGoogleRegister($customer);
            auth()->login($customer);
            return redirect(route('frontend.home'));
        } catch (\Exception $exception) {
            Helpers::setFlashMessage('Có lỗi xảy ra xin thử lại sau!');
            return redirect(route('frontend.register'));
        }
    }

    public function handleFacebookProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $email = $user->getEmail();

        if (!$email) {
            Helpers::setFlashMessage('Không nhận được thông tin email từ Facebook. Xin thử lại!');
            return redirect(route('frontend.register'));
        }

        $customer = Customer::where('email', $email)->first();

        if ($customer) {
            if (!$customer->status) {
                Helpers::setFlashMessage('Email đã tồn tại trong hệ thống nhưng chưa được kích hoạt!');
                return redirect(route('frontend.register'));
            }

            auth()->login($customer);
            return redirect(route('frontend.home'));
        }

        //create customer.

        $name = $user->getName();
        $pass = Helpers::getRandomString();

        try {
            $customer = Customer::create([
                'email' => $email,
                'name' => $name,
                'password' => $pass,
                'company_id' => Helpers::getDefaultCompany()->id,
                'status' => true
            ]);
            Helpers::sendMailNewFacebookRegister($customer);
            auth()->login($customer);
            return redirect(route('frontend.home'));
        } catch (\Exception $exception) {
            Helpers::setFlashMessage('Có lỗi xảy ra xin thử lại sau!');
            return redirect(route('frontend.register'));
        }
    }
}
