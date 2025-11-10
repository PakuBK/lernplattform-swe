<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isTeacher()) {
            return $this->teacherDashboard();
        } elseif ($user->isStudent()) {
            return $this->studentDashboard();
        } elseif ($user->isParent()) {
            return $this->parentDashboard();
        }

        return view('dashboard');
    }

    private function adminDashboard()
    {
        $stats = [
            'total_subjects' => Subject::count(),
            'total_quizzes' => Quiz::count(),
            'total_students' => Student::count(),
            'total_attempts' => Attempt::count(),
        ];

        return view('dashboards.admin', compact('stats'));
    }

    private function teacherDashboard()
    {
        $subjects = Subject::where('teacher_id', auth()->id())
            ->withCount(['quizzes', 'themes'])
            ->get();

        return view('dashboards.teacher', compact('subjects'));
    }

    private function studentDashboard()
    {
        $subjects = Subject::with('teacher')->get();
        $recentAttempts = Attempt::where('user_id', auth()->id())
            ->with('quiz.subject')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.student', compact('subjects', 'recentAttempts'));
    }

    private function parentDashboard()
    {
        $parent = auth()->user()->parentModel;
        $children = $parent ? $parent->children()->with('user')->get() : collect();

        $childrenAttempts = [];
        foreach ($children as $child) {
            $childrenAttempts[$child->id] = Attempt::where('user_id', $child->user_id)
                ->with('quiz.subject')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboards.parent', compact('children', 'childrenAttempts'));
    }
}
