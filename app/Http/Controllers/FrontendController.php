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

class FrontendController extends Controller
{

    public function survey(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
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
            Helpers::setFlashMessage('Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }


        return view('frontend.survey', compact( 'page', 'question','roundPercent', 'answer', 'survey'))
            ->with(['section' => 'home', 'title' => 'Thực hiện khảo sát', 'isStyleSurvey' => true]);
    }

    public function back(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
        $questionId = $request->input('question_id');

        if (!$questionId) {
            Helpers::setFlashMessage('Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }
        $question = Question::find($questionId);

        if (!$question) {
            Helpers::setFlashMessage('Câu hỏi không tồn tại!');
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
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
        $questionId = $request->input('question_id');

        if (!$questionId) {
            Helpers::setFlashMessage('Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $question = Question::find($questionId);

        if (!$question) {
            Helpers::setFlashMessage('Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $existedAnswer = Answer::where('customer_id', auth()->user()->id)
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
                'customer_id' => auth()->user()->id,
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
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        $surveyId = $request->input('id');

        if (!$surveyId) {
            Helpers::setFlashMessage('Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey || !$survey->status) {
            Helpers::setFlashMessage('Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        if (!Helpers::checkIfSurveyHaveResultForUser($survey)) {
            Helpers::setFlashMessage('Chưa có câu trả lời!');
            return redirect(route('frontend.home'));
        }

        $explain = Helpers::getResultExplainForSurveyAll($survey, [auth()->user()->id]);

        if (!$explain) {
            Helpers::setFlashMessage('Bạn chưa hoàn thành khảo sát!');
            return redirect(route('frontend.home'));
        }

        return view('frontend.result', compact('explain', 'survey'))
            ->with(['section' => 'home', 'title' => 'Kết quả khảo sát', 'isStyleSurvey' => true]);
    }

    public function general(Request $request)
    {

        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            Helpers::setFlashMessage('Bạn không có quyền xem kết quả doanh nghiệp!');
            return redirect(route('frontend.index'));
        }

        $surveyId = $request->input('id');

        if (!$surveyId) {
            Helpers::setFlashMessage('Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey || !$survey->status) {
            Helpers::setFlashMessage('Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        if (!Helpers::checkIfSurveyHaveAnyResult($survey)) {
            Helpers::setFlashMessage('Chưa có câu trả lời!');
            return redirect(route('frontend.home'));
        }

        $customerIds = Helpers::getCustomerListByManager($survey);

        $filters = Helpers::currentFrontendUserIsAdmin()? $survey->company->filters : $survey->company->filters->where('is_level', false);

        $explain = Helpers::getResultExplainForSurveyAll($survey, $customerIds);

        if (!$explain) {
            Helpers::setFlashMessage('Chiến dịch khảo sát chưa có dữ liệu!');
            return redirect(route('frontend.home'));
        }

        return view('frontend.general', compact( 'survey', 'explain', 'filters'))
            ->with(['section' => 'home', 'title' => 'Kết quả khảo sát toàn Doanh nghiệp', 'isStyleSurvey' => true]);
    }

    public function filter(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
        $surveyId = $request->input('survey_id');

        if (!$surveyId) {
            return response()->json(['error' => true, 'res' => []]);
        }

        $chooseType = $request->input('choose_type', 7);
        $survey = Survey::find($surveyId);
        $customerIds = Helpers::getCustomerListByManager($survey);

        if ($request->input('choose_customers')) {
            $chooseCustomers = $request->input('choose_customers');
            $customerIds = Helpers::getCustomerByChooseList($survey, $chooseCustomers);
        }
        $explain = Helpers::getResultExplainForSurveyAll($survey, $customerIds);

        //Helpers::log($explain);

        if (!$explain) {
            return response()->json(['error' => true]);
        }

        return response()->json([
            'error' => false,
            'result' => $explain['details'][$chooseType]['result'],
            'title' => Helpers::mapOrder()[$chooseType],
            'table' => view('frontend.partials.table')
                ->with(['result' => $explain['details'][$chooseType]['result']])
                ->render(),
            'detail' => view('frontend.partials.'.Helpers::ARRAY_TYPES[$chooseType].'_result_explain')
                ->with(['explain' => $explain])
                ->render(),
            'debug' => $customerIds? implode(',', Customer::whereIn('id', $customerIds)->pluck('name')->all()) : ''
        ]);
    }

    /*
     * For testing graph
     */

    public function removeManager(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }


        if (!Helpers::currentFrontendUserIsAdmin()) {
            $request->session()->flash('general_message', 'Tài khoản của bạn không đủ quyền!');
            return redirect(route('frontend.home'));
        }

        $managerId = $request->input('id');

        if (!$managerId) {
            $request->session()->flash('general_message', 'Không có thông tin tài khoản!');
            return redirect(route('frontend.home'));
        }

        $manager = Customer::find($managerId);

        if (!$manager) {
            $request->session()->flash('general_message', 'Không có thông tin tài khoản!');
            return redirect(route('frontend.home'));
        }

        if ($manager->level != Helpers::FRONTEND_MANAGER_LEVEL) {
            $request->session()->flash('general_message', 'Tài khoản không phải là Manager!');
            return redirect(route('frontend.home'));
        }

        if ($manager->company_id != auth()->user()->company_id) {
            $request->session()->flash('general_message', 'Không cùng doanh nghiệp!');
            return redirect(route('frontend.home'));
        }

        try {
            $manager->update([
                'level' => Helpers::FRONTEND_USER_LEVEL
            ]);

            $request->session()->flash('general_message', 'Remove Manager thành công!');
            return redirect(route('frontend.home'));

        } catch (\Exception $exception) {
            $request->session()->flash('general_message', 'Có lỗi xảy ra xin thử lại!');
            Helpers::log($exception->getMessage());
            return redirect(route('frontend.home'));
        }
    }
    public function addManager(Request $request) {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }


        if (!Helpers::currentFrontendUserIsAdmin()) {
            $request->session()->flash('general_message', 'Tài khoản của bạn không đủ quyền!');
            return redirect(route('frontend.home'));
        }

        $customerLogin = $request->input('login');

        if (!$customerLogin) {
            $request->session()->flash('general_message', 'Không có thông tin tài khoản!');
            return redirect(route('frontend.home'));
        }

        $manager = Customer::where('login', $customerLogin)->first();

        if (!$manager) {
            $request->session()->flash('general_message', 'Không có thông tin tài khoản!');
            return redirect(route('frontend.home'));
        }

        if (!$manager->status) {
            $request->session()->flash('general_message', 'Tài khoản chưa được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        if ($manager->level != Helpers::FRONTEND_USER_LEVEL) {
            $request->session()->flash('general_message', 'Tài khoản Không phải là thành viên thường!');
            return redirect(route('frontend.home'));
        }

        if ($manager->company_id != auth()->user()->company_id) {
            $request->session()->flash('general_message', 'Không cùng doanh nghiệp!');
            return redirect(route('frontend.home'));
        }

        try {
            $manager->update([
                'level' => Helpers::FRONTEND_MANAGER_LEVEL
            ]);

            $request->session()->flash('general_message', 'Add Manager thành công!');
            return redirect(route('frontend.home'));

        } catch (\Exception $exception) {
            $request->session()->flash('general_message', 'Có lỗi xảy ra xin thử lại!');
            Helpers::log($exception->getMessage());
            return redirect(route('frontend.home'));
        }
    }
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
