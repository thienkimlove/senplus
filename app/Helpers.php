<?php
/**
 * Created by PhpStorm.
 * User: tieungao
 * Date: 2020-08-26
 * Time: 11:08
 */

namespace App;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Cookie;

class Helpers
{
    public const COOKIE_MINUTES = 100;
    public const COOKIE_NAME = "send_plus";
    public const DOMAIN_SYSTEM = "bosana.vn";


    public static function setCookieLogin($email)
    {
        Cookie::queue(Cookie::make(self::COOKIE_NAME, $email, self::COOKIE_MINUTES, '/', '.' . self::DOMAIN_SYSTEM));
    }


    public static function deleteCookieLogin()
    {
        Cookie::queue(Cookie::make(self::COOKIE_NAME, '', self::COOKIE_MINUTES, '/', '.' . self::DOMAIN_SYSTEM));
    }

    public static function getCookieLogin()
    {
        return Cookie::get(self::COOKIE_NAME);
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

    public static function getCurrentUser()
    {
        $currentUserEmail = self::getCookieLogin();

        if (!$currentUserEmail) {
            return null;
        }

        $user = User::where('email', $currentUserEmail)->first();

        if (!$user) {
            return null;
        }

        return $user;
    }


    public static function mapOption()
    {
        return [
            'option1' => 'Gia Đình',
            'option2' => 'Sáng Tạo',
            'option3' => 'Thị Trường',
            'option4' => 'Kiểm Soát',
        ];
    }

    public static function mapRound()
    {
        return [
            1 => 'Đánh giá 2018 - 2020',
            2 => 'Cần thiết 2020 - 2022',
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
        ];
    }



    public static function getResultForUser()
    {
        $user = self::getCurrentUser();

        if (!$user) {
            return [];
        }
        if ($user->company_id) {
            $questions = Question::where('company_id', $user->company_id)->get();
        } else {
            $questions = Question::whereNull('company_id')->get();
        }

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

        foreach ($questions as $question) {
            $answerForQuest = Answer::where('user_id', $user->id)
                ->where('question_id', $question->id)
                ->first();

            if (!isset($arDetails[$question->round])) {
                $arDetails[$question->round] = [];
            }

            if (!isset($arDetails[$question->round][$question->order])) {
                $arDetails[$question->round][$question->order] = [];
            }

            foreach (['option1', 'option2', 'option3', 'option4'] as $opt) {
                $arDetails[$question->round][$question->order][$opt] = $answerForQuest ? $answerForQuest->{$opt} : 0;
            }
        }



        foreach ($arDetails as $round => $roundResult) {
            $avRoundOption1 = 0;
            $avRoundOption2 = 0;
            $avRoundOption3 = 0;
            $avRoundOption4 = 0;
            foreach ($roundResult as $order => $orderResult) {
                $avRoundOption1 += $orderResult['option1'];
                $avRoundOption2 += $orderResult['option2'];
                $avRoundOption3 += $orderResult['option3'];
                $avRoundOption4 += $orderResult['option4'];
            }

            $arAverage[$round]['option1'] = round($avRoundOption1/4, 2);
            $arAverage[$round]['option2'] = round($avRoundOption2/4, 2);
            $arAverage[$round]['option3'] = round($avRoundOption3/4, 2);
            $arAverage[$round]['option4'] = round($avRoundOption4/4, 2);
        }



        return $arAverage;
    }

    public static function generateAnswerForUser()
    {
        $user = self::getCurrentUser();

        if ($user) {
            if ($user->company_id) {
                $questions = Question::where('company_id', $user->company_id)->get();
            } else {
                $questions = Question::whereNull('company_id')->get();
            }

            foreach ($questions as $question) {
                Answer::create([
                    'user_id' => $user->id,
                    'question_id' => $question->id,
                    'option1' => rand(1, 40),
                    'option2' => rand(1, 40),
                    'option3' => rand(1, 40),
                    'option4' => rand(1, 40),
                ]);
            }
        }
    }

    public static function getQuestion($round, $order)
    {
        $user = self::getCurrentUser();

        if (!$user) {
            return null;
        }

        if (!$user->company_id) {
            return Question::whereNull('company_id')
                ->where('round', $round)
                ->where('order', $order)
                ->first();
        }

        return Question::where('company_id', $user->company_id)
            ->where('round', $round)
            ->where('order', $order)
            ->first();
    }

    public static function getSurveyForLoginUser()
    {

        $user = self::getCurrentUser();

        if (!$user) {
            return [];
        }

        if (!$user->company_id) {
            // ca nhan
            $generalQuestionIds = Question::whereNull('company_id')->pluck('id')->all();

            if (!$generalQuestionIds) {
                return [];
            }

            $countAnswerForGeneral = Answer::where('user_id', $user->id)
                ->whereIn('question_id', $generalQuestionIds)
                ->count();

            if ($countAnswerForGeneral > 0) {
                return [];
            } else {
                return ['type' => 'general', 'name' => 'Bộ câu hỏi chung'];
            }
        }

        $companyQuestionIds = Question::where('company_id', $user->company_id)
            ->pluck('id')
            ->all();

        if (!$companyQuestionIds) {
            return [];
        }

        $countAnswerForCompany = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $companyQuestionIds)
            ->count();

        if ($countAnswerForCompany > 0) {
            return [];
        } else {
            return ['type' => 'company', 'name' => 'Bộ câu hỏi cho doanh nghiệp '.$user->company->name];
        }
    }


    public static function currentUserIsAdmin()
    {
        $user = self::getCurrentUser();

        if (!$user) {
            return false;
        }

        return $user->hasRole('admin');
    }

    public static function haveAnswer($userId)
    {
        return (Answer::where('user_id', $userId)->count() > 0);
    }
}