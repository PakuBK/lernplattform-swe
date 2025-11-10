<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ $subject->name }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Subject Information</h5>
                                <div>
                                    <a href="{{ route('quiz.random', $subject) }}" class="btn btn-success">Take Random Quiz</a>
                                    @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
                                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">Edit</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p><strong>Description:</strong> {{ $subject->description ?? 'No description available.' }}</p>
                            <p><strong>Teacher:</strong> {{ $subject->teacher->name ?? 'Not assigned' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Themes</h5>
                        </div>
                        <div class="card-body">
                            @if($subject->themes->count() > 0)
                            <div class="list-group">
                                @foreach($subject->themes as $theme)
                                <div class="list-group-item">
                                    <h6>{{ $theme->name }}</h6>
                                    <p class="mb-2 text-muted">{{ $theme->description }}</p>
                                    @if($theme->materials->count() > 0)
                                    <div class="mt-2">
                                        <small class="text-muted">Materials:</small>
                                        @foreach($theme->materials as $material)
                                        <div class="ms-3">
                                            <i class="bi bi-file-pdf"></i> {{ $material->title }}
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-muted">No themes available.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Quizzes</h5>
                        </div>
                        <div class="card-body">
                            @if($subject->quizzes->count() > 0)
                            <div class="list-group">
                                @foreach($subject->quizzes as $quiz)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6>{{ $quiz->title }}</h6>
                                            <p class="mb-1 text-muted">{{ $quiz->description }}</p>
                                            @if($quiz->time_limit)
                                            <small class="text-muted">Time: {{ $quiz->time_limit }} min</small>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('quiz.start', $quiz) }}" class="btn btn-sm btn-primary">Start</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-muted">No quizzes available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
