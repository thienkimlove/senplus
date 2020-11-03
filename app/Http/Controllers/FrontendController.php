<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Filter;
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
            Helpers::setFlashMessage('Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey || !$survey->status) {
            Helpers::setFlashMessage('Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }


        if (!Helpers::userCanDoSurvey($survey)) {
            Helpers::setFlashMessage('Bạn không thể thực hiện khảo sát này!');
            return redirect(route('frontend.home'));
        }

        $round = $request->input('round', 1);
        $order = $request->input('order', 1);

        $isJump = false;

        if ($round ==  1 && $order == 1 && !$request->filled('back')) {
            // khong phai from back button
            // go to question not answer order by order and round
            $isJump = true;
        }

        list($question, $roundPercent, $answer) = Helpers::getQuestion($survey, $round, $order, $isJump);

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

        return redirect(route('frontend.survey').'?id='.$question->survey->id.'&round='.$question->round.'&order='.($question->order - 1).'&back=1');
    }

    public function answer(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        $data =  $request->only(['question_id', 'option1', 'option2', 'option3', 'option4', 'random']);

        $question = Question::find($data['question_id']);

        if (!$question) {
            Helpers::setFlashMessage('Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }

        if ($request->input('random') == 1) {
            Helpers::generateAnswerForUser($question->survey);
            return redirect(route('frontend.result').'?id='.$question->survey->id);
        }

        $rules = [
            'option1' => 'required|numeric|min:0|max:100',
            'option2' => 'required|numeric|min:0|max:100',
            'option3' => 'required|numeric|min:0|max:100',
            'option4' => 'required|numeric|min:0|max:100',
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
            'numeric' => 'Giá trị :attribute phải là số',
            'min' => 'Giá trị :attribute phải lớn hơn hoặc bằng 0',
            'max' => 'Giá trị :attribute phải nhỏ hơn hoặc bằng 100',
        ];

        $attributes = [
            'option1' => 'Lựa chọn 1',
            'option2' => 'Lựa chọn 2',
            'option3' => 'Lựa chọn 3',
            'option4' => 'Lựa chọn 4',
        ];

        $validator = Validator::make($data , $rules, $messages, $attributes);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (($data['option1'] + $data['option2'] + $data['option3'] + $data['option4']) != 100) {
            $validator->getMessageBag()->add('option1', 'Tổng số điểm phải bằng 100');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $existedAnswer = Answer::where('customer_id', auth()->user()->id)
            ->where('question_id', $question->id)
            ->first();


        if ($existedAnswer) {
            $existedAnswer->update([
                'option1' => $data['option1'],
                'option2' => $data['option2'],
                'option3' => $data['option3'],
                'option4' => $data['option4'],
            ]);
        } else {
            Answer::create([
                'customer_id' => auth()->user()->id,
                'question_id' => $question->id,
                'option1' => $data['option1'],
                'option2' => $data['option2'],
                'option3' => $data['option3'],
                'option4' => $data['option4'],
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

        return view('frontend.general', compact( 'survey', 'explain', 'filters', 'customerIds'))
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

        //Helpers::log($customerIds);

        $objectCustomerNames = Helpers::getFilterManagerNames();

        if ($request->input('choose_customers')) {
            $chooseCustomers = $request->input('choose_customers');
            //Helpers::log($chooseCustomers);
            $customerIds = Helpers::getCustomerByChooseList($survey, $chooseCustomers, $customerIds);

            $objectCustomerNames = Helpers::getTotalFilterNames($chooseCustomers, $objectCustomerNames);
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
            'debug' => $customerIds? implode(',', Customer::whereIn('id', $customerIds)->pluck('name')->all()) : '',
            'total' => 'Số lượng : '. count($customerIds),
            'object' => $objectCustomerNames? 'Đối tượng : '.$objectCustomerNames : ""
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
