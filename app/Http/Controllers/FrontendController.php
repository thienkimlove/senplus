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


    /*
     * Survey
     *
     */


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
            $request->session()->flash('general_message', 'Câu hỏi không tồn tại!');
            return redirect(route('frontend.home'));
        }


        return view('frontend.survey', compact( 'page', 'question','roundPercent', 'answer', 'survey'));
    }

    public function back(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
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
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
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
            $request->session()->flash('general_message', 'Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey || !$survey->status) {
            $request->session()->flash('general_message', 'Chiến dịch khảo sát không tồn tại hoặc không được kích hoạt!');
            return redirect(route('frontend.home'));
        }

        if (!Helpers::checkIfSurveyHaveResultForUser($survey)) {
            $request->session()->flash('general_message', 'Chưa có câu trả lời!');
            return redirect(route('frontend.home'));
        }

        $result = Helpers::getResultForSurveyAll($survey, [auth()->user()->id]);

        $explain = Helpers::explainResult($result, $survey);

        return view('frontend.result', compact('result', 'explain'));
    }


    public function general(Request $request)
    {

        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsAdmin()) {
            $request->session()->flash('general_message', 'Bạn không có quyền xem kết quả doanh nghiệp!');
            return redirect(route('frontend.index'));
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

        if (!Helpers::checkIfSurveyHaveAnyResult($survey)) {
            $request->session()->flash('general_message', 'Chưa có câu trả lời!');
            return redirect(route('frontend.home'));
        }

        $customerIds = Helpers::getCustomerListByManager($survey);
        $result = Helpers::getResultForSurveyAll($survey, $customerIds);
        $explain = Helpers::explainResult($result, $survey);

        return view('frontend.general', compact('result', 'survey', 'explain'));
    }

    public function filter(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }
        $surveyId = $request->input('survey_id');

        if (!$surveyId) {
            return response()->json(['error' => true, 'result' => []]);
        }

        $chooseType = $request->input('choose_type');
        $survey = Survey::find($surveyId);
        $customerIds = Helpers::getCustomerListByManager($survey);

        Helpers::log($customerIds);

        if (!$chooseType) {
            $result = Helpers::getResultForSurveyAll($survey, $customerIds);
            return response()->json([
                'error' => false,
                'result' => $result,
                'title' => 'Loại hình Văn hóa DN',
                'body' => view('frontend.partials.table', compact('result'))->render(),

            ]);
        } else {

            if (auth()->user()->level == Helpers::FRONTEND_MANAGER_LEVEL) {
                $result = Helpers::getResultForSurveyAll($survey, $customerIds, $chooseType);
                return response()->json([
                    'error' => false,
                    'result' => $result,
                    'title' => Helpers::mapOrder()[$chooseType],
                    'body' => view('frontend.partials.table', compact('result'))->render(),

                ]);
            } else {
                $chooseCustomers = $request->input('choose_customers');
                $customerIds = Helpers::getCustomerByChooseList($survey, $chooseCustomers);
                Helpers::log($customerIds);
                $result = Helpers::getResultForSurveyAll($survey, $customerIds, $chooseType);
                return response()->json([
                    'error' => false,
                    'result' => $result,
                    'title' => Helpers::mapOrder()[$chooseType],
                    'body' => view('frontend.partials.table', compact('result'))->render(),

                ]);
            }
        }
    }

    /*
     * v2
     */

    public function campaign()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $company = Company::find(auth()->user()->company_id);

        $surveys = Helpers::getSurveyForLoginUser();

        return view('frontend.campaign', compact('company', 'surveys'));
    }

    public function profile()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $company = Company::find(auth()->user()->company_id);

        return view('frontend.profile', compact('company'));
    }

    public function postProfile(Request $request)
    {
        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }
        $companyId = $request->input('company_id');

        if (!$companyId) {
            $request->session()->flash('general_message', 'Không có ID doanh nghiệp!');
            return redirect(route('frontend.home'));
        }

        $company = Company::find($companyId);

        if (!$company) {
            $request->session()->flash('general_message', 'Doanh nghiệp không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $update_fields = [
            'name',
            'brand_name',
            'main_address',
            'contact_phone',
            //'logo',
            'business_field_id',
            'employee_number_id',
            'average_income_id',
            'total_fund_id',
        ];

        foreach ($update_fields as $field) {

            $value = $request->input($field);

            if ($value) {
                try  {
                    $company->update([
                        $field => $value
                    ]);
                } catch (\Exception $exception) {
                    //pass
                }
            }
        }



        if ($file = $request->file('logo')) {
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, $filename);

            try  {
                $company->update([
                    'logo' => 'uploads/'.$filename
                ]);
            } catch (\Exception $exception) {
                //pass
            }

        }

        return redirect(route('frontend.home'));
    }

    public function handleDelSurvey(Request $request)
    {
        $surveyId = $request->input('survey_id');

        if (!$surveyId) {
            return response()->json(['error' => 'Không có thông tin chiến dịch khảo sát']);
        }

        $survey = Survey::find($surveyId);

        if (!$survey) {
            return response()->json(['error' => 'Không có thông tin chiến dịch khảo sát']);
        }

        // check if user is admin

        if (!Helpers::currentFrontendUserIsAdmin()) {
            return response()->json(['error' => 'Không có quyền xóa chiến dịch khảo sát']);
        }

        $survey->update([
            'status' => false
        ]);

        return response()->json(['success' => true]);
    }


    public function personal()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        $company = Company::find(auth()->user()->company_id);

        return view('frontend.personal', compact('company'));
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
