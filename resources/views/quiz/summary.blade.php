<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Quiz Summary</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">{{ $attempt->quiz->title }} - Results</h5>
                        </div>
                        <div class="card-body text-center">
                            <h2 class="display-4">
                                Your Score: {{ $attempt->score }}/{{ $attempt->max_score }}
                            </h2>
                            <p class="lead">
                                Percentage: {{ round(($attempt->score / $attempt->max_score) * 100, 2) }}%
                            </p>
                            <p class="text-muted">
                                Completed: {{ $attempt->completed_at->format('F d, Y \a\t H:i') }}
                            </p>
                            @if(($attempt->score / $attempt->max_score) >= 0.7)
                            <div class="alert alert-success">
                                <strong>Great job!</strong> You passed the quiz!
                            </div>
                            @else
                            <div class="alert alert-warning">
                                Keep practicing to improve your score!
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Answer Review</h5>
                        </div>
                        <div class="card-body">
                            @foreach($attempt->answers as $index => $answer)
                            <div class="mb-4 p-3 border rounded {{ $answer->is_correct ? 'border-success bg-light' : 'border-danger' }}">
                                <h6 class="mb-3">
                                    Question {{ $index + 1 }}
                                    @if($answer->is_correct)
                                    <span class="badge bg-success">Correct</span>
                                    @else
                                    <span class="badge bg-danger">Incorrect</span>
                                    @endif
                                </h6>
                                <p><strong>{{ $answer->question->question_text }}</strong></p>

                                <div class="mt-2">
                                    @foreach($answer->question->options as $option)
                                    <div class="mb-2">
                                        @if($option->is_correct)
                                        <span class="badge bg-success">✓</span>
                                        @endif
                                        @if($answer->question_option_id == $option->id)
                                        <strong>Your answer: {{ $option->option_text }}</strong>
                                        @else
                                        {{ $option->option_text }}
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                        <a href="{{ route('subjects.show', $attempt->quiz->subject) }}" class="btn btn-secondary">Back to Subject</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
