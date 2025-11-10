<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Parent Dashboard') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">My Children's Progress</h5>
                        </div>
                        <div class="card-body">
                            @if($children->count() > 0)
                                @foreach($children as $child)
                                <div class="mb-4">
                                    <h6>{{ $child->user->name }} - Grade {{ $child->grade }} (Class {{ $child->class }})</h6>
                                    @if(isset($childrenAttempts[$child->id]) && $childrenAttempts[$child->id]->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Quiz</th>
                                                    <th>Subject</th>
                                                    <th>Score</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($childrenAttempts[$child->id] as $attempt)
                                                <tr>
                                                    <td>{{ $attempt->quiz->title }}</td>
                                                    <td>{{ $attempt->quiz->subject->name }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $attempt->score / $attempt->max_score >= 0.7 ? 'success' : 'warning' }}">
                                                            {{ $attempt->score }}/{{ $attempt->max_score }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $attempt->completed_at->format('M d, Y') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <p class="text-muted">No quiz attempts yet.</p>
                                    @endif
                                </div>
                                <hr>
                                @endforeach
                            @else
                            <p class="text-muted">No children linked to your account.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
