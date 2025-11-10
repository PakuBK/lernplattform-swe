<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">{{ __('Admin Dashboard') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Subjects</h5>
                            <h2>{{ $stats['total_subjects'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Quizzes</h5>
                            <h2>{{ $stats['total_quizzes'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Students</h5>
                            <h2>{{ $stats['total_students'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Total Attempts</h5>
                            <h2>{{ $stats['total_attempts'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('subjects.index') }}" class="btn btn-primary me-2">Manage Subjects</a>
                            <a href="{{ route('quizzes.index') }}" class="btn btn-success me-2">Manage Quizzes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
