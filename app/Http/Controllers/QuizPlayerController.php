<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\AttemptAnswer;
use App\Models\Subject;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QuizPlayerController extends Controller
{
    public function start(Quiz $quiz)
    {
        $attempt = Attempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => auth()->id(),
            'started_at' => Carbon::now(),
        ]);

        return redirect()->route('quiz.play', $attempt);
    }

    public function play(Attempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        if ($attempt->isCompleted()) {
            return redirect()->route('quiz.summary', $attempt);
        }

        $quiz = $attempt->quiz()->with('questions.options')->first();
        return view('quiz.play', compact('attempt', 'quiz'));
    }

    public function submit(Request $request, Attempt $attempt)
    {
        if ($attempt->user_id !== auth()->id() || $attempt->isCompleted()) {
            abort(403);
        }

        $quiz = $attempt->quiz()->with('questions.options')->first();
        $score = 0;
        $maxScore = 0;

        foreach ($quiz->questions as $question) {
            $maxScore += $question->points;
            $selectedOptionId = $request->input('question_' . $question->id);

            if ($selectedOptionId) {
                $selectedOption = $question->options()->find($selectedOptionId);
                $isCorrect = $selectedOption && $selectedOption->is_correct;

                AttemptAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'question_option_id' => $selectedOptionId,
                    'is_correct' => $isCorrect,
                ]);

                if ($isCorrect) {
                    $score += $question->points;
                }
            }
        }

        $attempt->update([
            'score' => $score,
            'max_score' => $maxScore,
            'completed_at' => Carbon::now(),
        ]);

        return redirect()->route('quiz.summary', $attempt);
    }

    public function summary(Attempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        $attempt->load(['quiz', 'answers.question.options', 'answers.questionOption']);
        return view('quiz.summary', compact('attempt'));
    }

    public function random(Subject $subject)
    {
        $quiz = $subject->quizzes()->inRandomOrder()->first();

        if (!$quiz) {
            return redirect()->back()->with('error', 'No quizzes available for this subject.');
        }

        return redirect()->route('quiz.start', $quiz);
    }
}
