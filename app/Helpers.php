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
use App\Models\Survey;

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
            7 => 'Trung bình'
        ];
    }

    public static function checkIfSurveyHaveResultForUser($survey)
    {
        $user = self::getCurrentFrontendUser();
        $questionIds = $survey->questions->pluck('id')->all();
        $answerCount = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $questionIds)
            ->count();

        return ($answerCount > 0);
    }

    public static function checkIfSurveyHaveAnyResult($surveyId)
    {
        $questionIds = Question::where('survey_id', $surveyId)
            ->pluck('id')
            ->all();
        $answerCount = Answer::whereIn('question_id', $questionIds)
            ->count();

        return ($answerCount > 0);
    }


    public static function currentFrontendUserIsAdmin()
    {
        $user = self::getCurrentFrontendUser();

        if (!$user) {
            return false;
        }

        return $user->hasRole('admin');
    }

    public static function getQuestion($survey, $round, $order)
    {
        $user = self::getCurrentFrontendUser();
        if (!$user) {
            return [null, 0, 0, null];
        }


        if (!$survey || !$survey->status) {
            return [null, 0, 0, null];
        }

        $roundAnswerPercent = 0;

        $question = $survey->questions->where('round', $round)
            ->where('order', $order)
            ->first();

        $questionIds = $survey->questions->pluck('id')->all();

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

        if ($user->company_id) {
            return Survey::where('company_id', $user->company_id)
                ->where('status', true)
                ->get();
        }

        return Survey::whereNull('company_id')
            ->where('status', true)
            ->get();
    }


    public static function getResultForSurvey($survey)
    {
        $user = self::getCurrentFrontendUser();

        if (!$user) {
            return [];
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

        foreach ($survey->questions as $question) {
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

    public static function generateAnswerForUser($survey)
    {
        $user = self::getCurrentFrontendUser();
        if ($user) {
            foreach ($survey->questions as $question) {
                $randOption1 = rand(1, 70);
                $randOption2 = rand(1, 100 - $randOption1);
                $randOption3 = rand(1, 100 - ($randOption1+$randOption2));

                try {
                    Answer::create([
                        'user_id' => $user->id,
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
    }

    public static function getUserRoleAdminWhichNotHaveCompany()
    {
        return User::whereNull('company_id')->whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->get();
    }
}