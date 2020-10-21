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

        return view('frontend.campaign_edit', compact('company', 'survey'))
            ->with(['section' => 'campaign', 'title' => 'Chỉnh sửa khảo sát']);
    }

    public function postCampaignEdit(Request $request)
    {
        if (!Helpers::currentFrontendUserIsManager()) {
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

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();

        return view('frontend.campaign_create', compact('company'))
            ->with(['section' => 'campaign', 'title' => 'Tạo mới khảo sát']);
    }

    public function postCampaignCreate(Request $request)
    {
        if (!Helpers::currentFrontendUserIsManager()) {
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

        try {
            Survey::create($createData);
            Helpers::setFlashMessage('Tạo chiến dịch khảo sát thành công!');
            return redirect(route('frontend.home'));

        } catch (\Exception $exception) {
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

        if ($q) {
            $customers = Customer::where('company_id', $company->id)
                //->where('level', '!=', Helpers::FRONTEND_ADMIN_LEVEL)
                ->where('status', true)
                ->where(function($query) use($q) {
                     $query->where('email', 'like', '%'.$q.'%');
                     $query->orWhere('name', 'like', '%'.$q.'%');
                })
                ->paginate(10);
            $customers->setPath('?q='.$q);
        } else {
            $customers = Customer::where('company_id', $company->id)
                //->where('level', '!=', Helpers::FRONTEND_ADMIN_LEVEL)
                ->where('status', true)
                ->paginate(10);
        }

        return view('frontend.member', compact('company', 'customers', 'q'))
            ->with(['section' => 'member', 'title' => 'Dữ liệu người dùng', 'isStyleSurvey' => true]);
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

        return view('frontend.member_edit', compact('company','customer'))->with(['section' => 'member', 'title' => 'Chỉnh sửa người dùng']);
    }

    public function postMemberEdit(Request $request)
    {
        if (!Helpers::currentFrontendUserIsManager()) {
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


    public function memberCreate()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }


        $company = Helpers::getLoginCompany();

        return view('frontend.member_create', compact('company'))->with(['section' => 'member', 'title' => 'Tạo mới người dùng']);
    }


    public function postMemberCreate(Request $request)
    {
        if (!Helpers::currentFrontendUserIsManager()) {
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
            Helpers::sendMailNewRegister($customer);
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

        return redirect(route('frontend.profile'));
    }


}
