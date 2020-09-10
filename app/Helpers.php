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

class Helpers
{

    public static function log($msg)
    {
        if (is_array($msg)) {
            $message = json_encode($msg, true);
        } else {
            $message = $msg;
        }
        @file_put_contents(storage_path('logs/debug.log'), $message . "\n", FILE_APPEND);
    }

    public static function getCurrentFrontendUser()
    {

        return auth()->user();
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
            7 => 'Trung bình'
        ];
    }

    public static function haveResult()
    {
        $user = self::getCurrentFrontendUser();

        if (!$user) {
            return false;
        }

        return (Answer::where('user_id', $user->id)->count() > 0);
    }

    public static function getQuestionListForUser($user)
    {
        if ($user->company_id) {
            return Question::where('company_id', $user->company_id)->get();
        }
        return Question::whereNull('company_id')->get();
    }

    public static function currentFrontendUserIsAdmin()
    {
        $user = self::getCurrentFrontendUser();

        if (!$user) {
            return false;
        }

        return $user->hasRole('admin');
    }





    public static function haveAnswer($userId)
    {
        return (Answer::where('user_id', $userId)->count() > 0);
    }


    public static function getResultForUser()
    {
        $user = self::getCurrentFrontendUser();

        if (!$user) {
            return [];
        }

        $questions = self::getQuestionListForUser($user);


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

            $arAverage[$round]['option1'] = round($avRoundOption1/6, 2);
            $arAverage[$round]['option2'] = round($avRoundOption2/6, 2);
            $arAverage[$round]['option3'] = round($avRoundOption3/6, 2);
            $arAverage[$round]['option4'] = round($avRoundOption4/6, 2);
        }



        return $arAverage;
    }

    public static function generateAnswerForUser()
    {
        $user = self::getCurrentFrontendUser();

        if ($user) {

            $questions = self::getQuestionListForUser($user);


            foreach ($questions as $question) {
                try {
                    Answer::create([
                        'user_id' => $user->id,
                        'question_id' => $question->id,
                        'option1' => rand(1, 40),
                        'option2' => rand(1, 40),
                        'option3' => rand(1, 40),
                        'option4' => rand(1, 40),
                    ]);
                } catch (\Exception $exception) {
                    //pass
                }

            }
        }
    }

    public static function getQuestion($round, $order)
    {
        $user = self::getCurrentFrontendUser();
        if (!$user) {
            return [null, 0, 0, null];
        }

        $roundAnswerPercent = 0;

        if (!$user->company_id) {
            $question = Question::whereNull('company_id')
                ->where('round', $round)
                ->where('order', $order)
                ->first();

            $questionIds = Question::whereNull('company_id')->pluck('id')->all();
        } else {
            $question = Question::where('company_id', $user->company_id)
                ->where('round', $round)
                ->where('order', $order)
                ->first();

            $questionIds = Question::where('company_id', $user->company_id)->pluck('id')->all();

        }

        $answerRound = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $questionIds)
            ->count();

        if ($answerRound > 0) {
            $roundAnswerPercent = round($answerRound/12, 2)*100;
        }

        $answer = null;

        if ($question) {
            $answer = Answer::where('user_id', $user->id)
                ->where('question_id', $question->id)
                ->first();
        }

        return [$question, $roundAnswerPercent, $answer];
    }

    public static function getSurveyForLoginUser()
    {

        $user = self::getCurrentFrontendUser();

        if (!$user) {
            return [];
        }

        if (!$user->company_id) {
            // ca nhan
            $generalQuestionIds = Question::whereNull('company_id')->pluck('id')->all();

            if (!$generalQuestionIds) {
                return [];
            }

            return ['type' => 'general', 'name' => 'Bộ câu hỏi chung'];
        }

        $companyQuestionIds = Question::where('company_id', $user->company_id)
            ->pluck('id')
            ->all();

        if (!$companyQuestionIds) {
            return [];
        }

        return [
            'type' => 'company',
            'name' => 'Bộ câu hỏi cho doanh nghiệp '.$user->company->name
        ];
    }

}