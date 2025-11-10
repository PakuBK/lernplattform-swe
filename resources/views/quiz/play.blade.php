<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ $quiz->title }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ $quiz->title }}</h5>
                                @if($quiz->time_limit)
                                <span class="badge bg-warning">Time Limit: {{ $quiz->time_limit }} minutes</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if($quiz->description)
                            <p class="text-muted">{{ $quiz->description }}</p>
                            @endif

                            <form method="POST" action="{{ route('quiz.submit', $attempt) }}">
                                @csrf

                                @foreach($quiz->questions as $index => $question)
                                <div class="mb-4 p-3 border rounded">
                                    <h6 class="mb-3">
                                        Question {{ $index + 1 }}
                                        <span class="badge bg-info">{{ $question->points }} points</span>
                                    </h6>
                                    <p>{{ $question->question_text }}</p>

                                    <div class="options">
                                        @foreach($question->options as $option)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" 
                                                   name="question_{{ $question->id }}" 
                                                   id="option_{{ $option->id }}" 
                                                   value="{{ $option->id }}">
                                            <label class="form-check-label" for="option_{{ $option->id }}">
                                                {{ $option->option_text }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit Quiz</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
