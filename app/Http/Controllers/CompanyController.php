<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyController extends Controller
{

    /*
     * Campaign Stuff
     */

    public function campaign()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();

        $surveys = Helpers::getSurveyForLoginUser();

        return view('frontend.campaign', compact('company', 'surveys'))
            ->with(['section' => 'campaign', 'title' => 'Danh sách khảo sát']);
    }

    public function campaignDetail(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $surveyId = $request->input('id');

        if (!$surveyId) {
            Helpers::setFlashMessage('Id không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey) {
            Helpers::setFlashMessage('Chiến dịch không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();


        return view('frontend.campaign_detail', compact('company', 'survey'))
            ->with(['section' => 'campaign', 'title' => 'Chi tiết khảo sát']);
    }

    public function campaignEdit(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsAdmin()) {
            return redirect(route('frontend.home'));
        }

        $surveyId = $request->input('id');

        if (!$surveyId) {
            Helpers::setFlashMessage('Id không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey) {
            Helpers::setFlashMessage('Chiến dịch không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();

        return view('frontend.campaign_edit', compact('company', 'survey'))
            ->with(['section' => 'campaign', 'title' => 'Chỉnh sửa khảo sát']);
    }

    public function postCampaignEdit(Request $request)
    {
        if (!Helpers::currentFrontendUserIsAdmin()) {
            return redirect(route('frontend.home'));
        }

        if (Helpers::isDemoCustomer()) {
            Helpers::setFlashMessage('Tài khoản Demo không có quyền thực hiện tác vụ này!');
            return redirect(route('frontend.home'));
        }

        $surveyId = $request->input('survey_id');

        if (!$surveyId) {
            Helpers::setFlashMessage('Không có ID Chiến dịch!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey) {
            Helpers::setFlashMessage('Chiến dịch không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $data =  $request->only(['name', 'link', 'start_time', 'end_time', 'desc']);

        $rules = [
            'name' => 'required',
            'link' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
        ];

        $validator = Validator::make($data , $rules, $messages);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect(route('frontend.campaign_edit').'?id='.$surveyId)
                ->withErrors($validator);
        }

        // validate link

        $link = str_replace( url('/'), "", $request->input('link'));
        $link = str_replace('/', "", $link);


        $findInSurveyList = Survey::where('link', $link)->where('id', '!=', $surveyId)->count();

        if ($findInSurveyList > 0) {
            $validator->getMessageBag()->add('link', 'Mã đường dẫn chiến dịch đã tồn tại!');
            return redirect(route('frontend.campaign_edit').'?id='.$surveyId)
                ->withErrors($validator);
        }

        $update_fields = [
            'name',
            'link',
            'desc',
            'start_time',
            'end_time',
        ];

        foreach ($update_fields as $field) {



            $value = $request->input($field);

            if ($value) {
                if (in_array($field, ['start_time' ,'end_time'])) {
                    $value = Carbon::createFromFormat('d/m/Y H:i:s',$value)->toDateTimeString();
                }

                try  {
                    $survey->update([
                        $field => $value
                    ]);
                } catch (\Exception $exception) {
                    //pass
                }
            }
        }

        return redirect(route('frontend.campaign_detail').'?id='.$surveyId);
    }

    public function campaignCreate()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsAdmin()) {
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();

        return view('frontend.campaign_create', compact('company'))
            ->with(['section' => 'campaign', 'title' => 'Tạo mới khảo sát']);
    }

    public function postCampaignCreate(Request $request)
    {
        if (!Helpers::currentFrontendUserIsAdmin()) {
            return redirect(route('frontend.home'));
        }

        if (Helpers::isDemoCustomer()) {
            Helpers::setFlashMessage('Tài khoản Demo không có quyền thực hiện tác vụ này!');
            return redirect(route('frontend.home'));
        }

        $data =  $request->only(['name', 'link', 'start_time', 'end_time', 'desc', 'template_type']);

        $rules = [
            'name' => 'required',
            'link' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'template_type' => 'required',
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
        ];

        $attributes = [
            'name' => 'Tên chiến dịch',
            'link' => 'Link khảo sát',
            'start_time' => 'Thời gian bắt đầu',
            'end_time' => 'Thời gian kết thúc',
            'template_type' => 'Loại khảo sát',
        ];

        $validator = Validator::make($data , $rules, $messages, $attributes);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect(route('frontend.campaign_create'))
                ->withErrors($validator)
                ->withInput();
        }

        // validate link

        $link = str_replace( url('/'), "", $request->input('link'));
        $link = str_replace('/', "", $link);


        $findInSurveyList = Survey::where('link', $link)->count();

        if ($findInSurveyList > 0) {
            $validator->getMessageBag()->add('link', 'Mã đường dẫn chiến dịch đã tồn tại!');
            return redirect(route('frontend.campaign_create'))
                ->withErrors($validator);
        }

        // check if company have template or not.

        $template = Helpers::getTemplateForCurrentLogin($data);

        if (!$template)  {
            $validator->getMessageBag()->add('template_type', 'Doanh nghiệp chưa cấu hình bộ câu hỏi mẫu thuộc loại khảo sát đã chọn!');
            return redirect(route('frontend.campaign_create'))
                ->withErrors($validator);

        }


        $update_fields = [
            'name',
            'link',
            'desc',
            'start_time',
            'end_time',
        ];

        $createData = [
            'company_id' => auth()->user()->company_id
        ];

        foreach ($update_fields as $field) {
            $value = $request->input($field);
            if ($value) {
                if (in_array($field, ['start_time' ,'end_time'])) {
                    $value = Carbon::createFromFormat('d/m/Y H:i:s',$value)->toDateTimeString();
                }
                $createData[$field] = $value;
            }
        }


        DB::beginTransaction();

        try {

            $createData['round_1_desc'] = $template->round_1_desc;
            $createData['round_2_desc'] = $template->round_2_desc;

            $survey = Survey::create($createData);


            $questions = is_array($template->questions)? $template->questions : json_decode($template->questions, true);


            foreach ($questions as $question) {


                Question::create([
                    'survey_id' => $survey->id,
                    'name' => $question['name'],
                    'option1' => $question['option1'],
                    'option2' => $question['option2'],
                    'option3' => $question['option3'],
                    'option4' => $question['option4'],
                    'order' => $question['order'],
                    'round' => $question['round'],
                ]);
            }

            DB::commit();

            Helpers::setFlashMessage('Tạo chiến dịch khảo sát thành công!');
            return redirect(route('frontend.home'));

        } catch (\Exception $exception) {
            Helpers::log($exception->getMessage());
            DB::rollBack();
            $validator->getMessageBag()->add('name', 'Có lỗi xảy ra xin thử lại sau!');
            return redirect(route('frontend.campaign_create'))
                ->withErrors($validator);
        }

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

        if (Helpers::isDemoCustomer()) {
            return response()->json(['error' => 'Tài khoản Demo không có quyền thực hiện tác vụ này']);
        }

        $survey->update([
            'status' => false
        ]);

        return response()->json(['success' => true]);
    }


    /*
     * Member
     */

    public function member(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();

        $q = $request->input('q', '');
        $isNotCompleteSurveyId = $request->input('is_not_complete');

        $customers = Customer::where('company_id', $company->id)
            ->where('status', true);


        if ($isNotCompleteSurveyId) {
            $survey = Survey::find($isNotCompleteSurveyId);
            $notCompletedIds = Helpers::getNotCompletedCustomers($survey);
            $customers = $customers->whereIn('id', $notCompletedIds);
        }


        if ($q) {
            $customers = $customers->where(function($query) use($q) {
                     $query->where('email', 'like', '%'.$q.'%');
                     $query->orWhere('name', 'like', '%'.$q.'%');
                });
        }

        $customers = $customers->paginate(10);

        if ($q) {
            $customers->setPath('?q='.$q);
        }

        if ($isNotCompleteSurveyId) {
            $customers->setPath('?is_not_complete='.$isNotCompleteSurveyId);
        }

        return view('frontend.member', compact('company', 'customers', 'q', 'isNotCompleteSurveyId'))
            ->with(['section' => 'member', 'title' => 'Dữ liệu người dùng', 'isStyleSurvey' => true]);
    }

    public function ajax(Request $request)
    {
        $q = mb_strtolower($request->input('q'));



        $company = Helpers::getLoginCompany();

        $customerEmails = Customer::where('company_id', $company->id)
            ->where('status', true)
            ->where(DB::raw("LOWER(email)"), 'LIKE BINARY', '%'.$q.'%')
            ->pluck('email')
            ->all();


        $customerNames = Customer::where('company_id', $company->id)
            ->where('status', true)
            ->where(DB::raw('LOWER(name)'), 'LIKE BINARY', '%'.$q.'%')
            ->pluck('name')
            ->all();

        if ($customerNames) {
            foreach ($customerNames as $customerName) {
                $customerEmails[] = $customerName;
            }
        }

        return response()->json(['customers' => $customerEmails, 'q' => $q]);

    }

    public function memberDetail(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $customerId = $request->input('id');

        if (!$customerId) {
            Helpers::setFlashMessage('Thành viên không tồn tại!');
            return redirect(route('frontend.member'));
        }

        $customer = Customer::find($customerId);

        if (!$customer) {
            Helpers::setFlashMessage('Thành viên không tồn tại!');
            return redirect(route('frontend.member'));
        }

        $company = Helpers::getLoginCompany();
        $surveys = Helpers::getSurveyForLoginUser($customer);
        $countTotal = $surveys->count();

        $countCompleted = 0;
        $countNotCompleted = 0;

        foreach ($surveys as $survey) {
            if (Helpers::checkIfSurveyHaveResultForUser($survey, $customerId)) {
                $countCompleted ++;
            } else {
                $countNotCompleted ++;
            }
        }

        return view('frontend.member_detail', compact(
            'company',
            'customer',
            'surveys',
            'countTotal',
            'countCompleted',
            'countNotCompleted'
        ))->with(['section' => 'member', 'title' => 'Chi tiết người dùng']);
    }

    public function memberEdit(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsAdmin()) {
            return redirect(route('frontend.home'));
        }

        $customerId = $request->input('id');

        if (!$customerId) {
            Helpers::setFlashMessage('Thành viên không tồn tại!');
            return redirect(route('frontend.member'));
        }

        $customer = Customer::find($customerId);

        if (!$customer) {
            Helpers::setFlashMessage('Thành viên không tồn tại!');
            return redirect(route('frontend.member'));
        }

        $company = Helpers::getLoginCompany();

        return view('frontend.member_edit', compact('company','customer'))->with(['section' => 'member', 'title' => 'Chỉnh sửa người dùng']);
    }

    public function postMemberEdit(Request $request)
    {
        if (!Helpers::currentFrontendUserIsAdmin()) {
            return redirect(route('frontend.home'));
        }

        if (Helpers::isDemoCustomer()) {
            Helpers::setFlashMessage('Tài khoản Demo không có quyền thực hiện tác vụ này!');
            return redirect(route('frontend.home'));
        }

        $customerId = $request->input('customer_id');

        if (!$customerId) {
            Helpers::setFlashMessage('Không có ID Nhân viên!');
            return redirect(route('frontend.home'));
        }

        $customer = Customer::find($customerId);

        if (!$customer) {
            Helpers::setFlashMessage('Nhân viên không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $update_fields = [
            'name',
            'gender',
            'level',
        ];

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

        //update filter.

        $options = [];

        if ($customer->company->filters) {
            foreach ($customer->company->filters as $filter) {
                if ($filterValue =  $request->input('filter_'.$filter->id)) {
                    $options[] = [
                        'att_id' => $filter->id,
                        'att_value' => $filterValue
                    ];
                }
            }
        }

        if ($options) {
            $customer->update(['options' => $options]);
        }

        return redirect(route('frontend.member_detail').'?id='.$customerId);
    }


    public function postMemberRemind(Request $request)
    {
        if (!Helpers::currentFrontendUserIsAdmin()) {
            return redirect(route('frontend.home'));
        }

        if (Helpers::isDemoCustomer()) {
            Helpers::setFlashMessage('Tài khoản Demo không có quyền thực hiện tác vụ này!');
            return redirect(route('frontend.home'));
        }

        $surveyId = $request->input('survey_id');

        if (!$surveyId) {
            Helpers::setFlashMessage('Không có ID Chiến dịch!');
            return redirect(route('frontend.home'));
        }

        $survey = Survey::find($surveyId);

        if (!$survey) {
            Helpers::setFlashMessage('Chiến dịch không tồn tại!');
            return redirect(route('frontend.home'));
        }

        // remind emails
        $notCompletedIds = Helpers::getNotCompletedCustomers($survey);

        if ($notCompletedIds) {
            $customers = Customer::whereIn('id', $notCompletedIds)->get();
            foreach ($customers as $customer) {
                Helpers::sendMailRemindSurvey($customer, $survey);
            }
        }
        Helpers::setFlashMessage('Đã gửi email nhắc nhở!');

        return redirect(route('frontend.member').'?is_not_complete='.$surveyId);
    }


    public function memberCreate()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsAdmin()) {
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();

        return view('frontend.member_create', compact('company'))->with(['section' => 'member', 'title' => 'Tạo mới người dùng']);
    }


    public function postMemberCreate(Request $request)
    {
        if (!Helpers::currentFrontendUserIsAdmin()) {
            return redirect(route('frontend.home'));
        }

        if (Helpers::isDemoCustomer()) {
            Helpers::setFlashMessage('Tài khoản Demo không có quyền thực hiện tác vụ này!');
            return redirect(route('frontend.home'));
        }

        $data =  $request->all();

        $rules = [
            'email' => 'required|email',
            'name' => 'required',
            'gender' => 'required',
            'level' => 'required',
        ];

        $messages = [
            'required' => ':attribute bắt buộc nhập.',
        ];

        $validator = Validator::make($data , $rules, $messages);
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect(route('frontend.member_create'))
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Customer::where('email', trim($data['email']))->first();

        if ($customer) {
            $validator->getMessageBag()->add('email', 'Tài khoản đã tồn tại!');
            return redirect(route('frontend.member_create'))
                ->withErrors($validator)
                ->withInput();
        }

        $company = Helpers::getLoginCompany();

        $createArray = [
            'email' => $data['email'],
            'name' => $data['name'],
            'level' => $data['level'],
            'gender' => $data['gender'],
            'status' => false,
            'token' => Str::uuid(),
            'company_id' => $company->id,
            'password' => Helpers::getRandomString()
        ];

        $options = [];

        if ($company->filters) {
            foreach ($company->filters as $filter) {
                if ($filterValue = $request->input('filter_'.$filter->id)) {
                    $options[] = [
                        'att_id' => $filter->id,
                        'att_value' => $filterValue
                    ];
                }
            }
        }

        if ($options) {
            $createArray['options'] = $options;
        }

        try {
            $customer = Customer::create($createArray);
            Helpers::sendMailNewRegister($customer, true);
            Helpers::setFlashMessage('Đăng ký thành công xin kiểm tra email kích hoạt!');
            return redirect(route('frontend.member'));
        } catch (\Exception $exception) {
            $validator->getMessageBag()->add('email', $exception->getMessage());
            return redirect(route('frontend.member_create'))
                ->withErrors($validator)
                ->withInput();
        }
    }


    public function profile()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();

        return view('frontend.profile', compact('company'))->with(['section' => 'profile', 'title' => 'Hồ sơ doanh nghiệp']);
    }
    public function postProfile(Request $request)
    {
        if (!Helpers::currentFrontendUserIsAdmin()) {
            Helpers::setFlashMessage('Bạn không có quyền thực hiện tác vụ này!');
            return redirect(route('frontend.home'));
        }

        if (Helpers::isDemoCustomer()) {
            Helpers::setFlashMessage('Tài khoản Demo không có quyền thực hiện tác vụ này!');
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
            //'average_income_id',
            //'total_fund_id',
        ];


        foreach ($update_fields as $field) {

            $value = $request->input($field);

            if ($value) {
                try  {
                    $company->update([
                        $field => $value
                    ]);
                } catch (\Exception $exception) {

                }
            }
        }

        if ($file = $request->file('logo')) {

            $data = $request->only('logo');

            $rules = [
                'logo' => 'max:1024|mimes:jpg,png,bmp,jpeg,gif'
            ];

            $messages = [
                'mimes' => 'File :attribute là file ảnh',
                'max' => 'File :attribute phải nhỏ hơn hoặc bằng 1MB',
            ];

            $attributes = [
                'logo' => 'Logo',
            ];

            $validator = Validator::make($data , $rules, $messages, $attributes);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }


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

        return redirect(route('frontend.profile'));
    }



}
