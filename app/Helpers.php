<?php
/**
 * Created by PhpStorm.
 * User: tieungao
 * Date: 2020-08-26
 * Time: 11:08
 */

namespace App;

use App\Mail\ForgotPassword;
use App\Mail\RegisterConfirm;
use App\Mail\RegisterFacebook;
use App\Mail\RegisterGoogle;
use App\Mail\RemindSurvey;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Explain;
use App\Models\Filter;
use App\Models\Post;
use App\Models\Question;
use App\Models\Survey;
use App\Models\Topic;
use Backpack\Settings\app\Models\Setting;
use Carbon\Carbon;
use Illuminate\Mail\Transport\SesTransport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Helpers
{

    public const FRONTEND_ADMIN_LEVEL = 2;
    public const FRONTEND_MANAGER_LEVEL = 1;
    public const FRONTEND_USER_LEVEL = 0;

    public const SETTINGS = [
        [
            'key'         => 'meta_index_title',
            'name'        => 'Meta Index Title',
            'description' => 'For SEO',
            'value'       => 'casonline.vn',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'meta_index_desc',
            'name'        => 'Meta Index Description',
            'description' => 'For SEO',
            'value'       => 'casonline.vn',
            'field'       => '{"name":"value","label":"Value","type":"textarea"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'meta_index_keywords',
            'name'        => 'Meta Index Keywords',
            'description' => 'For SEO',
            'value'       => 'casonline.vn',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],



        [
            'key'         => 'facebook_app_id',
            'name'        => 'Facebook App ID',
            'description' => 'For SEO',
            'value'       => '',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'website_name',
            'name'        => 'Website Name',
            'description' => 'For SEO',
            'value'       => 'Hệ thống đánh giá văn hóa doanh nghiệp',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],

        [
            'key'         => 'youtube_link',
            'name'        => 'Youtube Link',
            'description' => 'For SEO',
            'value'       => '#',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'google_link',
            'name'        => 'Google Link',
            'description' => 'For SEO',
            'value'       => '#',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],

        [
            'key'         => 'facebook_link',
            'name'        => 'Facebook Link',
            'description' => 'For SEO',
            'value'       => '#',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'analytics',
            'name'        => 'Analytics Code',
            'description' => 'For SEO',
            'value'       => '',
            'field'       => '{"name":"value","label":"Value","type":"textarea"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'webmaster',
            'name'        => 'Webmaster Code',
            'description' => 'For SEO',
            'value'       => '',
            'field'       => '{"name":"value","label":"Value","type":"textarea"}', //text, textarea
            'active'      => 1,
        ],

        [
            'key'         => 'endpage',
            'name'        => 'End Page HTML',
            'description' => 'For SEO',
            'value'       => '',
            'field'       => '{"name":"value","label":"Value","type":"textarea"}', //text, textarea
            'active'      => 1,
        ],


    ];

    public const DEFAULT_COMPANY_NAME = "Khảo sát miễn phí";

    public const ARRAY_OPTIONS = ['option1', 'option2', 'option3', 'option4'];

    public const YES_NO = [
        1 => 'Kích hoạt',
        0 => 'Không kích hoạt'
    ];

    public const ARRAY_TYPES = [
        1 => 'ddnt',
        2 => 'pcld',
        3 => 'qlnv',
        4 => 'sgk',
        5 => 'cl',
        6 => 'tctc',
        7 => 'general'
    ];

    public const TEMPLATE_QUESTION_TYPES = [
        0 => 'Khảo sát năng lực cạnh tranh',
//        1 => 'Khảo sát tuyên bố giá trị',
//        2 => 'Khảo sát nhận diện thương hiệu',
//        3 => 'Đo lường hiệu quả',
    ];

    public static function getImgType($image_path){

        $extension  = array(IMAGETYPE_GIF => "gif",
            IMAGETYPE_JPEG => "jpeg",
            IMAGETYPE_PNG => "png",
            IMAGETYPE_SWF => "swf",
            IMAGETYPE_PSD => "psd",
            IMAGETYPE_BMP => "bmp",
            IMAGETYPE_TIFF_II => "tiff",
            IMAGETYPE_TIFF_MM => "tiff",
            IMAGETYPE_JPC => "jpc",
            IMAGETYPE_JP2 => "jp2",
            IMAGETYPE_JPX => "jpx",
            IMAGETYPE_JB2 => "jb2",
            IMAGETYPE_SWC => "swc",
            IMAGETYPE_IFF => "iff",
            IMAGETYPE_WBMP => "wbmp",
            IMAGETYPE_XBM => "xbm",
            IMAGETYPE_ICO => "ico");

        return $extension[exif_imagetype($image_path)];
    }

    public static function configGet($key)
    {
        return Setting::get($key);
    }

    public static function getLatestPost()
    {
        return Post::where('status', true)->orderBy('created_at', 'DESC')->first();
    }

    public static function getPopularTopics($limit = 10)
    {
        return Topic::limit($limit)->get();
    }

    public static function getSameAuthorPosts($post, $limit=2)
    {
        return Post::where('author_id', $post->author->id)
            ->where('status', true)
            ->where('id', '!=', $post->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getPopularPosts($limit=8)
    {
        return Post::where('status', true)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getRelatedPosts($post, $limit=6)
    {
        $postMainTopicIds = $post->mainTopics->pluck('id')->all();

        return Post::where('status', true)
            ->whereHas('mainTopics', function($q) use ($postMainTopicIds){
                $q->whereIn('id', $postMainTopicIds);
            })
            ->where('id', '!=', $post->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }


    public static function transformImageContent($post)
    {
        $content = $post->content;


        $dom = new \DOMDocument();
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        $dom->preserveWhiteSpace = false;
        $images = $dom->getElementsByTagName('img');

        Helpers::log($images);

        foreach ($images as $image)
        {
            $imageUrl = $image->getAttribute('src');

            if (strpos($imageUrl, 'http://') === true || strpos($imageUrl, 'https://') === true) {
                // download image
                $extension = self::getImgType($imageUrl);

                $fileName = $post->id.'-'.uniqid().'.'.$extension;
                $path =  public_path('uploads/'.$fileName);

                $ok = @file_put_contents($path, file_get_contents($imageUrl));
                if ($ok) {
                    $image->setAttribute('src', '/uploads/'.$fileName);
                }
            }
        }

        return $dom->saveHTML();




    }


    public static function log($msg)
    {
        if (is_array($msg)) {
            $message = json_encode($msg, true);
        } else {
            $message = $msg;
        }
        @file_put_contents(storage_path('logs/debug.log'), $message . "\n", FILE_APPEND);
    }

    public static function getTemplateForCurrentLogin($data, $company = null)
    {
        if (!$company) {
            $company = Helpers::getLoginCompany();
        }


        $template = null;

        foreach ($company->templates as $item) {
            if ($item->type == $data['template_type']) {
                $template = $item;
                break;
            }
        }

        if (!$template) {
            return null;
        }

        if (!$template->questions) {
            return null;
        }

        return $template;
    }

    public static function adminAddTemplateQuestionWhenSurvey($content)
    {
        if ($content->questions->count() == 0) {

            $template = self::getTemplateForCurrentLogin(['template_type' => $content->template_type], $content->company);


            if ($template) {
                try  {
                    $questions = json_decode($template->questions, true);
                } catch (\Exception $exception) {
                    $questions = $template->questions;
                }



                foreach ($questions as $question) {

                    Question::create([
                        'survey_id' => $content->id,
                        'name' => $question['name'],
                        'option1' => $question['option1'],
                        'option2' => $question['option2'],
                        'option3' => $question['option3'],
                        'option4' => $question['option4'],
                        'order' => $question['order'],
                        'round' => $question['round'],
                    ]);
                }

            }
        }
    }

    public static function mapTemplateQuestion()
    {
        return [
            0 => [
                'name' => 'name',
                'value' => 'Câu Hỏi'
            ],
            1 => [
                'name' => 'round',
                'value' => 'Vòng (1 hoặc 2)'
            ],
            2 => [
                'name' => 'order',
                'value' => 'Thứ tự (1 đến 6)'
            ],
            3 => [
                'name' => 'option1',
                'value' => 'Lựa chọn 1'
            ],
            4 => [
                'name' => 'option2',
                'value' => 'Lựa chọn 2'
            ],
            5 => [
                'name' => 'option3',
                'value' => 'Lựa chọn 3'
            ],
            6 => [
                'name' => 'option4',
                'value' => 'Lựa chọn 4'
            ]
        ];
    }

    public static function mapCustomer()
    {
        return [
            0 => [
                'name' => 'name',
                'value' => 'Họ và Tên'
            ],
            1 => [
                'name' => 'email',
                'value' => 'Email'
            ],
            2 => [
                'name' => 'phone',
                'value' => 'Phone'
            ],
            3 => [
                'name' => 'address',
                'value' => 'Địa chỉ'
            ],
            4 => [
                'name' => 'password',
                'value' => 'Mật khẩu'
            ],
            5 => [
                'name' => 'gender',
                'value' => 'Giới tính'
            ]
        ];
    }

    public static function explainResult($result)
    {
        $maxRound1Option = 0;
        $maxRound1OptionKey = null;

        foreach (self::ARRAY_OPTIONS as $option) {
            if ($result[1][$option] > $maxRound1Option) {
                $maxRound1Option = $result[1][$option];
                $maxRound1OptionKey = $option;
            }
        }

        $secondRound1Option = 0;
        $secondRound1OptionKey = null;

        foreach (self::ARRAY_OPTIONS as $option) {
           if ($option != $maxRound1OptionKey) {
               if ($result[1][$option] > $secondRound1Option) {
                   $secondRound1Option = $result[1][$option];
                   $secondRound1OptionKey = $option;
               }
           }
        }

        $thirdColumnMoreThan10 = [];
        $thirdColumnLessThan10 = [];


        foreach (self::ARRAY_OPTIONS as $option) {
            $cValue = round(($result[2][$option] - $result[1][$option]), 2);

            $absValue = abs($cValue);

            if ($absValue >=10) {
                $thirdColumnMoreThan10[] = $option;
            } else if ($absValue < 10 && $absValue >= 5) {
                $thirdColumnLessThan10[] = $option;
            }
        }

        return [
            'result' => $result,
            'maxValue' => $maxRound1Option,
            'maxOption' => $maxRound1OptionKey,
            'secondValue' => $secondRound1Option,
            'secondOption' => $secondRound1OptionKey,
            'moreThan' => $thirdColumnMoreThan10,
            'lessThan' => $thirdColumnLessThan10,
            'explainMax' => Explain::where('option', $maxRound1OptionKey)->first(),
            'explainSecond' => Explain::where('option', $secondRound1OptionKey)->first()
        ];

    }
    /*
     * Main function to get list of customer Ids which completed answer the survey
     */

    public static function getOnlyCompletedCustomers($survey, $customerIds = [])
    {

        if (!$customerIds) {
            $customerIds = Customer::where('company_id', $survey->company_id)->pluck('id')->all();
        }

        $questionIds = $survey->questions->pluck('id')->all();
        $completedUserIds = [];

        foreach ($customerIds as $customerId) {
            $countAnswers = Answer::whereIn('question_id', $questionIds)
                ->where('customer_id', $customerId)
                ->count();

            if ($countAnswers == 12) {
                $completedUserIds[] = $customerId;
            }
        }

        return $completedUserIds;
    }

    public static function getNotCompletedCustomers($survey, $customerIds = [])
    {
        if (!$customerIds) {
            $customerIds = Customer::where('company_id', $survey->company_id)->pluck('id')->all();
        }

        $completedIds = self::getOnlyCompletedCustomers($survey, $customerIds);

        $notCompletedIds = [];

        foreach ($customerIds as $customerId) {
            if (!in_array($customerId, $completedIds)) {
                $notCompletedIds[] = $customerId;
            }
        }
        return $notCompletedIds;
    }

    public static function getResultForSurvey($survey, $customerIds, $type)
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

            foreach ($options as $index => $value) {

                $avgValue = Answer::whereIn('question_id', $questionIds)
                    ->whereIn('customer_id', $customerIds)
                    ->avg($index);

                $arDetails[$round][$index] = round($avgValue, 2);
            }
        }

        return $arDetails;
    }

    public static function getXValue($explains, $i, $option)
    {
        return round($explains['details'][$i]['result'][2][$option] - $explains['details'][$i]['result'][1][$option], 2) - round($explains['details'][7]['result'][2][$option] - $explains['details'][7]['result'][1][$option], 2);
    }

    public static function getResultExplainForSurveyAll($survey, $customerIds)
    {
        // only customer completed the survey can count.
        $customerIds = self::getOnlyCompletedCustomers($survey, $customerIds);

        // check if have result for survey with $customerIds
        if (!$customerIds) {
            return [];
        }

        $explains = [
            'company_name' => $survey->company->name,
            'details' => [],
            'all' => Explain::all(),
            'avgPercentMatch' => 0,
            'extends' => []
        ];

        for ($i = 1; $i < 8; $i++) {
            $result = self::getResultForSurvey($survey, $customerIds, $i);
            $explains['details'][$i] = self::explainResult($result);
        }

        // get additional general explain.

        $avgPercentMatch = 0;

        for ($i = 1; $i < 7; $i++) {
            $percentMatch = 0;
            $bigThan = [];
            foreach (self::ARRAY_OPTIONS as $option) {
                $xValue = self::getXValue($explains, $i, $option);

                if (abs($xValue) < 5) {
                    $percentMatch += 25;
                } else {
                    $bigThan[] = $option;
                }
            }

            $explains['extends'][$i] = [
                'bigThan' => $bigThan,
                'percentMatch' => $percentMatch,
            ];
            $avgPercentMatch += $percentMatch;
        }
        $explains['avgPercentMatch'] = ($avgPercentMatch > 0) ? round($avgPercentMatch/6, 2) : 0;

        return $explains;

    }

    public static function getFilterManagerNames()
    {
        $filterNames = [];
        if (!Helpers::currentFrontendUserIsAdmin()) {
            foreach (auth()->user()->options as $option) {
                $filter = Filter::find($option['att_id']);
                if ($filter && $filter->is_level) {
                    $filterNames[] = $option['att_value'];
                }
            }
        }
        return ($filterNames) ? implode(' + ', $filterNames) : "";
    }

    public static function getTotalFilterNames($chooseCustomers, $objectCustomerNames)
    {
        // 1|| Nhân Sự##HanhfChinh, 2||Nhân Sự##HanhfChinh
        $listCustomerFilters = explode(',', $chooseCustomers);
        if ($listCustomerFilters) {
            foreach ($listCustomerFilters as $listCustomerFilter) {
                $exList = explode('||', $listCustomerFilter);
                if (isset($exList[0]) && isset($exList[1]) && $filterId = $exList[0]) {
                    if ($filterDB = Filter::find($filterId)) {
                        $objectCustomerNames .= ' + '.str_replace('##', ', ', $exList[1]);
                    }
                }
            }
        }

        return $objectCustomerNames;
    }

    public static function getMatchName($value)
    {
        if ($value >= 95) {
            return 'Hoàn toàn phù hợp';
        }

        if ($value >= 75) {
            return 'Tương đối phù hợp';
        }

        if ($value >= 50) {
            return 'Chưa phù hợp';
        }


        return 'Không phù hợp';

    }

    public static function mapLevel()
    {
        return [
            self::FRONTEND_ADMIN_LEVEL => 'Admin',
            self::FRONTEND_MANAGER_LEVEL => 'Quản lý',
            self::FRONTEND_USER_LEVEL => 'Nhân viên'
        ];
    }

    public static function mapOption()
    {
        return [
            'option1' => 'Đội nhóm',
            'option2' => 'Tiên phong',
            'option3' => 'Thị trường',
            'option4' => 'Kiểm soát',
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
            7 => 'Tổng quan',
            1 => 'Đặc điểm nổi trội',
            2 => 'Phong cách lãnh đạo',
            3 => 'Quản lý nhân viên',
            4 => 'Sự gắn kết',
            5 => 'Chiến lược',
            6 => 'Tiêu chí thành công',
        ];
    }


    public static function checkIfSurveyHaveResultForUser($survey, $customerId = null)
    {

        if (!$customerId) {
            $customerId = auth()->user()->id;
        }

        return (count(self::getOnlyCompletedCustomers($survey, [$customerId])) > 0);
    }

    public static function checkIfSurveyHaveAnyResult($survey)
    {
        return (count(self::getOnlyCompletedCustomers($survey)) > 0);
    }


    public static function currentFrontendUserIsManager()
    {
        return in_array(auth()->user()->level, [self::FRONTEND_ADMIN_LEVEL, self::FRONTEND_MANAGER_LEVEL]);
    }

    public static function currentFrontendUserIsAdmin()
    {
        return auth()->user()->level == self::FRONTEND_ADMIN_LEVEL;
    }

    public static function currentFrontendUserIsDemo()
    {
        return auth()->user()->id == 1;
    }

    public static function getListManagerForCurrentUser()
    {

        return Customer::where('company_id', auth()->user()->company_id)
            ->where('level', self::FRONTEND_MANAGER_LEVEL)
            ->where('status', true)
            ->get();

    }


    public static function getQuestion($survey, $round, $order, $isJump = false)
    {

        if (!$survey || !$survey->status) {
            return [null, 0, 0, null];
        }

        $roundAnswerPercent = 0;

        $questionIds = $survey->questions->pluck('id')->all();
        $questionLoop = null;

        if ($isJump) {
            for ($i = 1; $i< 13; $i++) {
                if ($i < 7) {
                    $roundLoop = 1;
                    $orderLoop = $i;
                } else {
                    $roundLoop = 2;
                    $orderLoop = $i - 6;
                }

                $questionLoop = Question::whereIn('id', $questionIds)
                    ->where('round', $roundLoop)
                    ->where('order', $orderLoop)
                    ->first();

                $answerYet = Answer::where('customer_id', auth()->user()->id)
                    ->where('question_id', $questionLoop->id)
                    ->count();

                if ($answerYet == 0) {
                    break;
                }
            }
        }

        if ($questionLoop) {
            $question = $questionLoop;
        } else {
            $question = $survey->questions->where('round', $round)
                ->where('order', $order)
                ->first();
        }

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

    public static function getSurveyForLoginUser($customer = null)
    {
        if (!$customer) {
            $customer = auth()->user();
        }

        return Survey::where('company_id', $customer->company_id)
            ->where('status', true)
            ->has('questions')
            ->orderBy('created_at', 'DESC')
            ->get();
    }


    public static function getCustomerFilterValue($customer, $filter)
    {
        if (!$customer->options) {
            return null;
        }

        $customerOptions = is_array($customer->options)? $customer->options : json_decode($customer->options, true);

        foreach ($customerOptions as $option) {
            if ($option['att_id'] == $filter->id) {
                return $option['att_value'];
            }
        }

        return null;


    }

    public static function getCustomerListByManager($survey)
    {
        if (Helpers::currentFrontendUserIsAdmin()) {
            return Customer::where('company_id', $survey->company_id)
                ->where('status', true)
                ->pluck('id')
                ->all();
        }
        //manager
        $customers = Customer::where('company_id', $survey->company_id)
            ->where('status', true)
            ->get();

        $storeUserIds = [];
        foreach (auth()->user()->options as $option) {
            $filter = Filter::find($option['att_id']);
            if ($filter && $filter->is_level) {
                foreach ($customers as $customer) {
                    if ($option['att_value'] == self::getCustomerFilterValue($customer, $filter)) {
                        $storeUserIds[] = $customer->id;
                    }
                }
            }
        }
        return array_unique($storeUserIds);
    }

    public static function getCustomerByChooseList($survey, $chooseCustomers, $customerIds)
    {

        $customers = Customer::where('company_id', $survey->company_id)
            ->where('status', true)
            ->whereIn('id', $customerIds)
            ->get();
        $storeUserIds = [];

        if ($chooseCustomers) {
            // 1|| Nhân Sự##HanhfChinh, 2||Nhân Sự##HanhfChinh
            $listCustomerFilters = explode(',', $chooseCustomers);
            if ($listCustomerFilters) {
                foreach ($listCustomerFilters as $listCustomerFilter) {
                    $exList = explode('||', $listCustomerFilter);
                    if (isset($exList[0]) && isset($exList[1]) && $filterId = $exList[0]) {
                        if ($filterDB = Filter::find($filterId)) {
                            $storeUserIds[$filterId] = [];
                            foreach ($customers as $customer) {
                                $cusFilterValue = self::getCustomerFilterValue($customer, $filterDB);

                                if ($cusFilterValue && strpos($exList[1], $cusFilterValue) !== false) {
                                    $storeUserIds[$filterId][] = $customer->id;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (!$storeUserIds) {
            return [];
        }

        $result = reset($storeUserIds);

        foreach ($storeUserIds as $index => $storeUserId) {
            $result = array_intersect($result, $storeUserId);
        }

        return array_unique($result);
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
        return count(self::getOnlyCompletedCustomers($survey));
    }

    public static function getTotalUserJoin($survey)
    {
        return Customer::where('company_id', $survey->company_id)->count();
    }

    public static function getTotalUserNotAnswer($survey)
    {
        $totalCompanyUser = Customer::where('company_id', $survey->company_id)->count();

        return $totalCompanyUser - self::getTotalAnswerForSurvey($survey);
    }

    public static function getGenders()
    {
        return [
            'male' => 'Nam',
            'female' => 'Nữ'
        ];
    }

    public static function getDefaultCompany()
    {
        $default = Company::where('name', self::DEFAULT_COMPANY_NAME)->first();

        if (!$default) {

            $default = Company::create([
                'name' => self::DEFAULT_COMPANY_NAME
            ]);
        }

        return $default;
    }

    public static function sendMailNewRegister($customer)
    {
        try {
            Mail::to($customer->email)
                //->cc(['thienkimlove@gmail.com'])
                ->send(new RegisterConfirm($customer));
        } catch (\Exception $exception) {
            self::log($exception->getMessage());
        }

    }

    public static function sendMailNewGoogleRegister($customer)
    {
        try {
            Mail::to($customer->email)
                //->cc(['thienkimlove@gmail.com'])
                ->send(new RegisterGoogle($customer));
        } catch (\Exception $exception) {
            self::log($exception->getMessage());
        }

    }

    public static function sendMailNewFacebookRegister($customer)
    {
        try {
            Mail::to($customer->email)
                //->cc(['thienkimlove@gmail.com'])
                ->send(new RegisterFacebook($customer));
        } catch (\Exception $exception) {
            self::log($exception->getMessage());
        }

    }


    public static function sendMailForgotPassword($customer)
    {
        try {
            Mail::to($customer->email)
                //->cc(['thienkimlove@gmail.com'])
                ->send(new ForgotPassword($customer));
        } catch (\Exception $exception) {
            self::log($exception->getMessage());
        }

    }

    public static function sendMailRemindSurvey($customer, $survey)
    {
        try {
            Mail::to($customer->email)
                ->send(new RemindSurvey($customer, $survey));
        } catch (\Exception $exception) {
            self::log($exception->getMessage());
        }

    }

    public static function getLoginCustomerAvatar()
    {
        return auth()->user()->avatar ? url(auth()->user()->avatar) : '';
    }

    public static function getCustomerAvatar($customer)
    {
        return $customer->avatar ? url($customer->avatar) : '';
    }

    public static function getLoginCompany()
    {
        $customerId = auth()->user()->id;

        return Customer::find($customerId)->company;
    }

    public static function getLoginCompanyLogo()
    {
        $customerId = auth()->user()->id;

        $company = Customer::find($customerId)->company;

        return ($company->logo) ? url($company->logo) : '';
    }

    public static function setFlashMessage($msg)
    {
        request()->session()->flash('general_message', $msg);
    }

    public static function getRandomLinkSurvey()
    {
        return substr(str_replace('-', '', Str::uuid()), 0, 6);
    }

    public static function getRandomString($length = 6)
    {
        return substr(md5(Str::uuid()), 0, $length);
    }

    public static function truncateWords($string, $width, $etc = ' ..')
    {
        $wrapped = explode('$trun$', wordwrap($string, $width, '$trun$', false), 2);
        return $wrapped[0] . (isset($wrapped[1]) ? $etc : '');
    }

    public static function limitText($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}