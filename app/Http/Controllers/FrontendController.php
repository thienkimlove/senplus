<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
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
            return redirect(route('frontend.index'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            $validator->getMessageBag()->add('email', 'Tài khoản không tồn tại!');
            return redirect(route('frontend.index'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        if (!Hash::check($data['password'], $user->getAuthPassword())) {
            $validator->getMessageBag()->add('password', 'Mật khẩu không đúng xin thử lại!');
            return redirect(route('frontend.index'))
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        auth()->login($user);
        return redirect(route('frontend.home'));
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
        return view('frontend.home', compact( 'page', 'surveys'));
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


    public function survey(Request $request)
    {
        $page = 'survey';
        $surveyId = $request->input('id');

        if (!$surveyId) {
            $request->session()->flash('general_message', 'Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey || !$survey->status) {
            $request->session()->flash('general_message', 'Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $round = $request->input('round', 1);
        $order = $request->input('order', 1);

        list($question, $roundPercent, $answer) = Helpers::getQuestion($survey, $round, $order);

        if (!$question) {
            $request->session()->flash('general_message', 'Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }


        return view('frontend.survey', compact( 'page', 'question','roundPercent', 'answer', 'survey'));
    }

    public function back(Request $request)
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

        if ($question->round == 1 && $question->order == 1) {
            return redirect(route('frontend.survey').'?id='.$question->survey->id);
        }
        if ($question->round == 2 && $question->order == 1) {
            return redirect(route('frontend.survey').'?id='.$question->survey->id.'&order=6');
        }

        return redirect(route('frontend.survey').'?id='.$question->survey->id.'&round='.$question->round.'&order='.($question->order - 1));
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

        $user = Helpers::getCurrentFrontendUser();

        if (!$user) {
            $request->session()->flash('general_message', 'Không xác định được người dùng!');
            return redirect(route('frontend.home'));
        }

        $existedAnswer = Answer::where('user_id', $user->id)
            ->where('question_id', $question->id)
            ->first();


        if ($request->input('random') == 1) {
            Helpers::generateAnswerForUser($question->survey);
            return redirect(route('frontend.result').'?id='.$question->survey->id);
        }

        if ($existedAnswer) {
            $existedAnswer->update([
                'option1' => $request->input('option1') ? $request->input('option1') : 0,
                'option2' => $request->input('option2') ? $request->input('option2') : 0,
                'option3' => $request->input('option3') ? $request->input('option3') : 0,
                'option4' => $request->input('option4') ? $request->input('option4') : 0,
            ]);
        } else {
            Answer::create([
                'user_id' => $user->id,
                'question_id' => $question->id,
                'option1' => $request->input('option1') ? $request->input('option1') : 0,
                'option2' => $request->input('option2') ? $request->input('option2') : 0,
                'option3' => $request->input('option3') ? $request->input('option3') : 0,
                'option4' => $request->input('option4') ? $request->input('option4') : 0,
            ]);
        }
        if ($question->order == 6) {
            if ($question->round == 1) {
                return redirect(route('frontend.survey').'?id='.$question->survey->id.'&round=2');
            } else {
                return redirect(route('frontend.result').'?id='.$question->survey->id);
            }
        }

        return redirect(route('frontend.survey').'?id='.$question->survey->id.'&round='.($question->round).'&order='.($question->order + 1));

    }

    public function result(Request $request)
    {

        $user = Helpers::getCurrentFrontendUser();

        if (!$user) {
            $request->session()->flash('general_message', 'Không xác định được người dùng!');
            return redirect(route('frontend.home'));
        }

        $surveyId = $request->input('id');

        if (!$surveyId) {
            $request->session()->flash('general_message', 'Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey || !$survey->status) {
            $request->session()->flash('general_message', 'Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $questionIds = $survey->questions->pluck('id')->all();

        $answerYet = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $questionIds)
            ->count();

        if ($answerYet == 0) {
            $request->session()->flash('general_message', 'Chưa có câu trả lời!');
            return redirect(route('frontend.home'));
        }

        $result = Helpers::getResultForSurvey($survey);

        return view('frontend.result', compact('result'));
    }


    public function general(Request $request)
    {

        $user = Helpers::getCurrentFrontendUser();

        if (!$user) {
            $request->session()->flash('general_message', 'Không xác định được người dùng!');
            return redirect(route('frontend.home'));
        }

        $surveyId = $request->input('id');

        if (!$surveyId) {
            $request->session()->flash('general_message', 'Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey || !$survey->status) {
            $request->session()->flash('general_message', 'Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $questionIds = $survey->questions->pluck('id')->all();

        $answerYet = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $questionIds)
            ->count();

        if ($answerYet == 0) {
            $request->session()->flash('general_message', 'Chưa có câu trả lời!');
            return redirect(route('frontend.home'));
        }

        $result = Helpers::getResultForSurvey($survey);

        return view('frontend.general', compact('result'));
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
