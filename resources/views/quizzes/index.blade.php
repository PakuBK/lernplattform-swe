<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Quizzes') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
            <div class="mb-3">
                <a href="{{ route('quizzes.create') }}" class="btn btn-primary">Create New Quiz</a>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($quizzes->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Subject</th>
                                    <th>Theme</th>
                                    <th>Time Limit</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quizzes as $quiz)
                                <tr>
                                    <td><strong>{{ $quiz->title }}</strong></td>
                                    <td>{{ $quiz->subject->name }}</td>
                                    <td>{{ $quiz->theme->name ?? 'N/A' }}</td>
                                    <td>{{ $quiz->time_limit ? $quiz->time_limit . ' min' : 'No limit' }}</td>
                                    <td>
                                        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('quiz.start', $quiz) }}" class="btn btn-sm btn-success">Take Quiz</a>
                                        @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
                                        <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted">No quizzes available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
