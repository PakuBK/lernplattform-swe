<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Student Dashboard') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Available Subjects</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($subjects as $subject)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $subject->name }}</h5>
                                            <p class="card-text">{{ Str::limit($subject->description, 100) }}</p>
                                            <p class="text-muted small">Teacher: {{ $subject->teacher->name ?? 'N/A' }}</p>
                                            <a href="{{ route('subjects.show', $subject) }}" class="btn btn-primary btn-sm">View Details</a>
                                            <a href="{{ route('quiz.random', $subject) }}" class="btn btn-success btn-sm">Random Quiz</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Quiz Attempts</h5>
                        </div>
                        <div class="card-body">
                            @if($recentAttempts->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Quiz</th>
                                            <th>Subject</th>
                                            <th>Score</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentAttempts as $attempt)
                                        <tr>
                                            <td>{{ $attempt->quiz->title }}</td>
                                            <td>{{ $attempt->quiz->subject->name }}</td>
                                            <td>{{ $attempt->score }}/{{ $attempt->max_score }}</td>
                                            <td>{{ $attempt->completed_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('quiz.summary', $attempt) }}" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p class="text-muted">No quiz attempts yet. Start taking quizzes!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
