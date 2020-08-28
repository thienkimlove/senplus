<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Answer;
use App\Models\Question;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{

    public function login()
    {
        if (auth()->check()) {
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

        auth()->login($user);

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
        if (!auth()->check()) {
            return redirect(route('frontend.login'));
        }

        $survey = Helpers::getSurveyForLoginUser();

        return view('frontend.home', compact( 'page', 'survey'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect(route('frontend.index'));
    }

    /*
     * Survey
     *
     */


    public function question(Request $request)
    {
        $page = 'question';
        $round = $request->input('round', 1);
        $order = $request->input('order', 1);

        $question = Helpers::getQuestion($round, $order);

        if (!$question) {
            $request->session()->flash('general_message', 'Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }

        return view('frontend.question', compact( 'page', 'question'));
    }

    public function answer(Request $request)
    {
        $questionId = $request->input('question_id');

        if (!$questionId) {
            $request->session()->flash('general_message', 'Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $question = Question::find($questionId);

        if (!$question) {
            $request->session()->flash('general_message', 'Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $user = Helpers::getCurrentUser();

        if (!$user) {
            $request->session()->flash('general_message', 'Không xác định được người dùng!');
            return redirect(route('frontend.home'));
        }

        $countExistedAnswer = Answer::where('user_id', $user->id)
            ->where('question_id', $question->id)
            ->count();

        if ($countExistedAnswer > 0) {
            $request->session()->flash('general_message', 'Đã thực hiện trả lời!');
            return redirect(route('frontend.home'));
        }

        if ($request->input('random') == 1) {
            Helpers::generateAnswerForUser();
            return redirect(route('frontend.result'));
        }

        Answer::create([
            'user_id' => $user->id,
            'question_id' => $question->id,
            'option1' => $request->input('option1') ? $request->input('option1') : 0,
            'option2' => $request->input('option2') ? $request->input('option2') : 0,
            'option3' => $request->input('option3') ? $request->input('option3') : 0,
            'option4' => $request->input('option4') ? $request->input('option4') : 0,
        ]);

        if ($question->order == 6) {
            if ($question->round == 1) {
                return redirect(route('frontend.question').'?round=2');
            } else {
                return redirect(route('frontend.result'));
            }
        }

        return redirect(route('frontend.question').'?round='.($question->round).'&order='.($question->order + 1));

    }

    public function result(Request $request)
    {

        $user = Helpers::getCurrentUser();

        if (!$user) {
            $request->session()->flash('general_message', 'Không xác định được người dùng!');
            return redirect(route('frontend.home'));
        }

        $answerYet = Answer::where('user_id', $user->id)->count();

        if ($answerYet == 0) {
            $request->session()->flash('general_message', 'Chưa có câu trả lời!');
            return redirect(route('frontend.home'));
        }

        $result = Helpers::getResultForUser();

        return view('frontend.result', compact('result'));
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
