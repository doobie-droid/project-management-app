@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-6">
        <div class="w-full    flex justify-end">
            <a href="{{ route('tasks.index') }}"
                class="bg-gray-700 hover:bg-gray-800 rounded transition text-white py-2 px-4 align-left">New
                Task</a>
        </div>
        <h2 class="text-xl font-bold mb-4">Edit Task</h2>

        <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Task Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}"
                    class="mt-1 block w-full border border-gray-300 rounded p-2" required>
            </div>


            <div class="flex justify-between">
                <a href="javascript:history.back()" class="text-sm text-gray-600 hover:underline">
                    ← Back
                </a>
                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-500 transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
