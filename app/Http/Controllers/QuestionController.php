<?php

namespace Gamify\Http\Controllers;

use Gamify\Events\QuestionAnswered;
use Gamify\Events\QuestionCorrectlyAnswered;
use Gamify\Events\QuestionIncorrectlyAnswered;
use Gamify\Http\Requests\QuestionAnswerRequest;
use Gamify\Libs\Game\Game;
use Gamify\Question;
use Gamify\User;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $questions = $user->pendingQuestions();

        // If the user is in the highest level, some hacks needs to be done.
        try {
            $next_level = $user->getNextLevel();
            $next_level_name = $next_level->name;
            $diff_between_levels = $next_level->required_points - $user->experience;
            $points_to_next_level = ($diff_between_levels > 0) ? $diff_between_levels : 0;
            $percentage_to_next_level = ($points_to_next_level > 0)
                ? round(($diff_between_levels / $next_level->required_points) * 100)
                : 100;
        } catch (\Exception $exception) {
            $next_level_name = $user->level;
            $points_to_next_level = 0;
            $percentage_to_next_level = 100;
        }

        // Questions
        $number_of_questions = Question::published()->count();
        $answered_questions = $user->answeredQuestions()->count();
        $percentage_of_answered_questions = ($number_of_questions > 0)
            ? round(($answered_questions / $number_of_questions) * 100)
            : 0;

        return view('question.index', [
            'questions' => $questions,
            'next_level_name' => $next_level_name,
            'points_to_next_level' => $points_to_next_level,
            'percentage_to_next_level' => $percentage_to_next_level,
            'answered_questions' => $answered_questions,
            'percentage_of_answered_questions' => $percentage_of_answered_questions,
        ]);
    }

    /**
     * @param QuestionAnswerRequest $request
     * @param Question              $question
     *
     * @return \Illuminate\View\View
     */
    public function answer(QuestionAnswerRequest $request, Question $question)
    {
        // TODO: If question has been answered can't answer again

        // TODO: AI. Global Badges

        // Obtain how many points has its answer obtained
        $points = 0;
        $answerCorrectness = false;

        foreach ($request->choices as $answer) {
            $choice = $question->choices()->find($answer);
            $points += $choice->score;
            $answerCorrectness = $answerCorrectness || $choice->isCorrect();
        }
        // minimum points for answer is '1'
        if ($points < 1) {
            $points = 1;
        }

        // Create relation between User and Question
        $user = User::findOrFail(Auth::id());
        $user->answeredQuestions()->attach($question, [
            'points' => $points,
            'answers' => implode(',', $request->choices),
        ]);

        // Trigger an event that will update XP, badges...
        event(new QuestionAnswered($user, $question, $points, $answerCorrectness));

        // Deal with Question specific Badges
        if ($answerCorrectness) {
            $answerStatus = 'correct';
        } else {
            $answerStatus = 'incorrect';
        }
        $badges = $question->actions()
            ->whereIn('when', ['always', $answerStatus]);

        // AI. Increment actions
        foreach ($badges as $badge) {
            Game::incrementBadge($user, $badge);
        }

        // AI. Add notifications and return view
        return view('question.show-answered', [
            'answer' => $user->answeredQuestions()->find($question->id),
            'question' => $question,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     *
     * @return \Illuminate\View\View
     */
    public function show(Question $question)
    {
        // TODO: If question has been answered, not show form
        $user = User::findOrFail(Auth::id());
        if ($answer = $user->answeredQuestions()->find($question->id)) {
            // User has answered this question
            return view('question.show-answered', [
                'answer' => $answer,
                'question' => $question,
            ]);
        }

        return view('question.show', compact('question'));
    }
}
