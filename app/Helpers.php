<?php
/**
 * Created by PhpStorm.
 * User: tieungao
 * Date: 2020-08-26
 * Time: 11:08
 */

namespace App;

use App\Models\Answer;
use App\Models\Customer;
use App\Models\Explain;
use App\Models\Filter;
use App\Models\Question;
use App\Models\Survey;
use Carbon\Carbon;

class Helpers
{

    public const FRONTEND_ADMIN_LEVEL = 2;
    public const FRONTEND_MANAGER_LEVEL = 1;
    public const FRONTEND_USER_LEVEL = 0;


    public static function log($msg)
    {
        if (is_array($msg)) {
            $message = json_encode($msg, true);
        } else {
            $message = $msg;
        }
        @file_put_contents(storage_path('logs/debug.log'), $message . "\n", FILE_APPEND);
    }

    public static function mapCustomer()
    {
        return [
            0 => [
                'name' => 'name',
                'value' => 'Họ và Tên'
            ],
            1 => [
                'name' => 'last_name',
                'value' => 'Họ'
            ],
            2 => [
                'name' => 'first_name',
                'value' => 'Tên'
            ],
            3 => [
                'name' => 'email',
                'value' => 'Email'
            ],
            4 => [
                'name' => 'username',
                'value' => 'Username'
            ],
            5 => [
                'name' => 'phone',
                'value' => 'Phone'
            ],
            6 => [
                'name' => 'address',
                'value' => 'Địa chỉ'
            ],

            7 => [
                'name' => 'login',
                'value' => 'Tài khoản'
            ],
            8 => [
                'name' => 'password',
                'value' => 'Mật khẩu'
            ]
        ];
    }

    public static function explainResult($result, $survey)
    {
        if (!$survey->company_id) {
            return [];
        }

        $maxRound1Option = 0;
        $maxRound1OptionKey = null;

        foreach (['option1', 'option2', 'option3', 'option4'] as $option) {
            if ($result[1][$option] > $maxRound1Option) {
                $maxRound1Option = $result[1][$option];
                $maxRound1OptionKey = $option;
            }
        }

        $secondRound1Option = 0;
        $secondRound1OptionKey = null;

        foreach (['option1', 'option2', 'option3', 'option4'] as $option) {
           if ($option != $maxRound1OptionKey) {
               if ($result[1][$option] > $secondRound1Option) {
                   $secondRound1Option = $result[1][$option];
                   $secondRound1OptionKey = $option;
               }
           }
        }

        $thirdColumnMoreThan10 = [];
        $thirdColumnLessThan10 = [];

        foreach (['option1', 'option2', 'option3', 'option4'] as $option) {
            $cValue = round($result[2][$option] - $result[1][$option]);

            if (abs($cValue) >=10) {
                $thirdColumnMoreThan10[] = $option;
            } else {
                $thirdColumnLessThan10[] = $option;
            }
        }

        return [
            'name' => $survey->company->name,
            'result' => $result,
            'maxValue' => $maxRound1Option,
            'maxOption' => $maxRound1OptionKey,
            'secondValue' => $secondRound1Option,
            'secondOption' => $secondRound1OptionKey,
            'moreThan' => $thirdColumnMoreThan10,
            'lessThan' => $thirdColumnLessThan10,
            'explainMax' => Explain::where('option', $maxRound1OptionKey)->first(),
            'explainSecond' => Explain::where('option', $secondRound1OptionKey)->first(),
            'explainAll' => Explain::get()
        ];

    }


    public static function mapLevel()
    {
        return [
            self::FRONTEND_ADMIN_LEVEL => 'Admin',
            self::FRONTEND_MANAGER_LEVEL => 'Manager',
            self::FRONTEND_USER_LEVEL => 'User'
        ];
    }


    public static function mapOption()
    {
        return [
            'option1' => 'Clan',
            'option2' => 'Adhocracy',
            'option3' => 'Market',
            'option4' => 'Hierarchy',
        ];
    }


    public static function mapRound()
    {
        return [
            1 => 'Đánh giá hiện tại',
            2 => 'Mong muốn',
        ];
    }

    public static function mapOrder()
    {
        return [
            1 => 'Đặc điểm nổi trội',
            2 => 'Phong cách lãnh đạo',
            3 => 'Quản lý nhân viên',
            4 => 'Sự gắn kết',
            5 => 'Chiến lược',
            6 => 'Tiêu chí thành công',
            7 => 'Loại hình Văn Hóa DN'
        ];
    }

    public static function checkIfSurveyHaveResultForUser($survey)
    {
        $questionIds = $survey->questions->pluck('id')->all();
        $answerCount = Answer::where('customer_id', auth()->user()->id)
            ->whereIn('question_id', $questionIds)
            ->count();

        return ($answerCount > 0);
    }

    public static function checkIfSurveyHaveAnyResult($survey)
    {
        $questionIds = Question::where('survey_id', $survey->id)
            ->pluck('id')
            ->all();
        $answerCount = Answer::whereIn('question_id', $questionIds)
            ->count();

        return ($answerCount > 0);
    }


    public static function currentFrontendUserIsManager()
    {
        return auth()->user()->level != self::FRONTEND_USER_LEVEL;
    }

    public static function currentFrontendUserIsAdmin()
    {
        return auth()->user()->level == self::FRONTEND_ADMIN_LEVEL;
    }


    public static function getListManagerForCurrentUser()
    {

        if (auth()->user()->company_id) {
            return Customer::where('company_id', auth()->user()->company_id)
                ->where('level', self::FRONTEND_MANAGER_LEVEL)
                ->where('status', true)
                ->get();
        }

        return null;

    }


    public static function getQuestion($survey, $round, $order)
    {

        if (!$survey || !$survey->status) {
            return [null, 0, 0, null];
        }

        $roundAnswerPercent = 0;

        $question = $survey->questions->where('round', $round)
            ->where('order', $order)
            ->first();

        $questionIds = $survey->questions->pluck('id')->all();

        $answerRound = Answer::where('customer_id', auth()->user()->id)
            ->whereIn('question_id', $questionIds)
            ->count();

        if ($answerRound > 0) {
            $roundAnswerPercent = round($answerRound/12, 2)*100;
        }

        $answer = null;

        if ($question) {
            $answer = Answer::where('customer_id', auth()->user()->id)
                ->where('question_id', $question->id)
                ->first();
        }

        return [$question, $roundAnswerPercent, $answer];
    }

    public static function getSurveyForLoginUser()
    {
        if (auth()->user()->company_id) {
            return Survey::where('company_id', auth()->user()->company_id)
                ->where('status', true)
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        return Survey::whereNull('company_id')
            ->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function getCustomerListByManager($survey)
    {
        if (auth()->user()->level == Helpers::FRONTEND_ADMIN_LEVEL) {
            return Customer::where('company_id', $survey->company_id)
                ->where('status', true)
                ->pluck('id')
                ->all();
        } else {
            //manager
            $customers = Customer::where('company_id', $survey->company_id)
                ->where('status', true)
                ->get();

            $storeUserIdByFilter = [];

            foreach (auth()->user()->options as $option) {
                $filter = Filter::find($option['att_id']);
                if ($filter && !$filter->is_level) {
                    $storeUserIdByFilter[$option['att_id']] = [];
                    foreach ($customers as $customer) {
                       if ($customer->options) {
                           foreach ($customer->options as $cusOption) {
                               if ($cusOption['att_value'] == $option['att_value']) {
                                   $storeUserIdByFilter[$option['att_id']][] = $customer->id;
                               }
                           }
                       }
                    }
                }
            }

            if (!$storeUserIdByFilter) {
                return [];
            }

            $finalCustomerQuery = Customer::where('company_id', $survey->company_id)
                ->where('status', true);

            foreach ($storeUserIdByFilter as $filterValue) {
                $finalCustomerQuery = $finalCustomerQuery->whereIn('id', $filterValue);
            }

            return $finalCustomerQuery->pluck('id')->all();

        }
    }

    public static function getCustomerByChooseList($survey, $chooseCustomers)
    {

        $customers = Customer::where('company_id', $survey->company_id)
            ->where('status', true)
            ->get();
        $storeUserIdByFilter = [];

        if ($chooseCustomers) {
            $listCustomerFilters = explode(',', $chooseCustomers);
            if ($listCustomerFilters) {
                foreach ($listCustomerFilters as $listCustomerFilter) {
                    $exList = explode('||', $listCustomerFilter);
                    if ($filterId = $exList[0] && $filterValue = $exList[1]) {
                        foreach ($customers as $customer) {
                            if ($customer->options) {
                                foreach ($customer->options as $cusOption) {
                                    if ($cusOption['att_value'] == $filterValue && $cusOption['att_id'] == $filterId) {
                                        $storeUserIdByFilter[$filterId][] = $customer->id;
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }

        if (!$storeUserIdByFilter) {
            return Customer::where('company_id', $survey->company_id)
                ->where('status', true)
                ->pluck('id')
                ->all();
        }

        //Helpers::log("storeUserIdByFilter");
        //Helpers::log($storeUserIdByFilter);

        $finalCustomerQuery = Customer::where('company_id', $survey->company_id)
            ->where('status', true);

        foreach ($storeUserIdByFilter as $filterValue) {
            $finalCustomerQuery = $finalCustomerQuery->whereIn('id', $filterValue);
        }

        return $finalCustomerQuery->pluck('id')->all();
    }

    public static function getResultForSurveyAll($survey, $customerIds, $type = 7)
    {

        $arDetails = [];
        $arAverage = [
            1 => [
                'option1' => 0,
                'option2' => 0,
                'option3' => 0,
                'option4' => 0,
            ],
            2 => [
                'option1' => 0,
                'option2' => 0,
                'option3' => 0,
                'option4' => 0,
            ]
        ];

        foreach ($arAverage as $round => $options) {
            if (!isset($arDetails[$round])) {
                $arDetails[$round] = [];
            }
            foreach ($options as $index => $value) {
                if ($type == 7) {
                    $questionIds = $survey->questions
                        ->where('round', $round)
                        ->pluck('id')
                        ->all();
                } else {
                    $questionIds = $survey->questions
                        ->where('round', $round)
                        ->where('order', $type)
                        ->pluck('id')
                        ->all();
                }

                $avgValue = Answer::whereIn('question_id', $questionIds)
                    ->whereIn('customer_id', $customerIds)
                    ->avg($index);

                $arDetails[$round][$index] = round($avgValue, 2);
            }
        }


        return $arDetails;
    }


    public static function generateAnswerForUser($survey)
    {
        foreach ($survey->questions as $question) {
            $randOption1 = rand(1, 70);
            $randOption2 = rand(1, 100 - $randOption1);
            $randOption3 = rand(1, 100 - ($randOption1+$randOption2));

            try {
                Answer::create([
                    'customer_id' => auth()->user()->id,
                    'question_id' => $question->id,
                    'option1' => $randOption1,
                    'option2' => $randOption2,
                    'option3' => $randOption3,
                    'option4' => 100 - ($randOption1 + $randOption2 + $randOption3),
                ]);
            } catch (\Exception $exception) {
                //pass
            }
        }
    }

    public static function userCanDoSurvey($survey)
    {
        if (!$survey->status) {
            return false;
        }

        $now = Carbon::now()->toDateTimeString();

        if ($survey->start_time  && $survey->start_time > $now) {
            return false;
        }

        if ($survey->end_time  && $survey->end_time < $now) {
            return false;
        }
        if (self::checkIfSurveyHaveResultForUser($survey)) {
            return false;
        }

        return true;
    }

    public static function getLatestSurveyCanDoForUser()
    {
        $surveys = self::getSurveyForLoginUser();
        if (!$surveys) {
            return null;
        }

        foreach ($surveys as $survey) {
            if (self::userCanDoSurvey($survey)) {
                return $survey;
            }
        }
        return null;
    }

    public static function getTotalAnswerForSurvey($survey)
    {
        $questionIds = Question::where('survey_id', $survey->id)
            ->pluck('id')
            ->all();
        $userIds = Answer::whereIn('question_id', $questionIds)->pluck('customer_id')->all();
        return count(array_unique($userIds));
    }

    public static function getTotalUserNotAnswer($survey)
    {
        $totalCompanyUser = Customer::where('company_id', $survey->company_id)->count();

        return $totalCompanyUser - self::getTotalAnswerForSurvey($survey);
    }
}