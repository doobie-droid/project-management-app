@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <h1 class="text-2xl font-bold mb-6">Welcome to the Admin Dashboard</h1>

        <div class="flex space-x-4">
            <a href="{{ route('tasks.index') }}"
                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                View All Tasks
            </a>
        </div>
    </div>
@endsection
