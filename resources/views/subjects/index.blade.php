<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Subjects') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
            <div class="mb-3">
                <a href="{{ route('subjects.create') }}" class="btn btn-primary">Create New Subject</a>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($subjects->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Teacher</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjects as $subject)
                                <tr>
                                    <td><strong>{{ $subject->name }}</strong></td>
                                    <td>{{ Str::limit($subject->description, 50) }}</td>
                                    <td>{{ $subject->teacher->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('subjects.show', $subject) }}" class="btn btn-sm btn-info">View</a>
                                        @if(auth()->user()->isTeacher() || auth()->user()->isAdmin())
                                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
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
                    <p class="text-muted">No subjects available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
