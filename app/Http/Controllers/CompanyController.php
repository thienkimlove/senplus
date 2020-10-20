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

class CompanyController extends Controller
{

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

        return view('frontend.campaign', compact('company', 'surveys'));
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

        return view('frontend.campaign_detail', compact('company', 'survey'));
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

        return view('frontend.campaign_edit', compact('company', 'survey'));
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

        return view('frontend.campaign_create', compact('company'));
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

    public function profile()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();

        return view('frontend.profile', compact('company'));
    }

    public function member()
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $company = Helpers::getLoginCompany();

        $customers = Customer::where('company_id', $company->id)
            ->where('level', '!=', Helpers::FRONTEND_ADMIN_LEVEL)
            ->paginate(10);

        return view('frontend.member', compact('company', 'customers'));
    }

    public function detail(Request $request)
    {
        if (!auth()->check()) {
            return redirect(route('frontend.index'));
        }

        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }

        $customerId = $request->input('id');

        if (!$customerId) {
            $request->session()->flash('general_message', 'Thành viên không tồn tại!');
            return redirect(route('frontend.member'));
        }

        $customer = Customer::find($customerId);

        if (!$customer) {
            $request->session()->flash('general_message', 'Thành viên không tồn tại!');

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

        return view('frontend.detail', compact(
            'company',
            'customer',
            'surveys',
            'countTotal',
            'countCompleted',
            'countNotCompleted'
        ));
    }

    public function postDetail(Request $request)
    {
        if (!Helpers::currentFrontendUserIsManager()) {
            return redirect(route('frontend.home'));
        }
        $customerId = $request->input('customer_id');

        if (!$customerId) {
            $request->session()->flash('general_message', 'Không có ID Nhân viên!');
            return redirect(route('frontend.home'));
        }

        $customer = Customer::find($customerId);

        if (!$customer) {
            $request->session()->flash('general_message', 'Nhân viên không tồn tại!');
            return redirect(route('frontend.home'));
        }

        $update_fields = [
            'name',
            'gender',
            'level',
            'email',
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

        return redirect(route('frontend.detail').'?id='.$customerId);
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
}
