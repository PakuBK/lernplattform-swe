<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Teacher Dashboard') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <a href="{{ route('subjects.create') }}" class="btn btn-primary">Create New Subject</a>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">My Subjects</h5>
                        </div>
                        <div class="card-body">
                            @if($subjects->count() > 0)
                            <div class="row">
                                @foreach($subjects as $subject)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $subject->name }}</h5>
                                            <p class="card-text">{{ Str::limit($subject->description, 150) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="badge bg-info">{{ $subject->themes_count }} Themes</span>
                                                    <span class="badge bg-success">{{ $subject->quizzes_count }} Quizzes</span>
                                                </div>
                                                <div>
                                                    <a href="{{ route('subjects.show', $subject) }}" class="btn btn-sm btn-primary">View</a>
                                                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-warning">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-muted">No subjects yet. Create your first subject!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
