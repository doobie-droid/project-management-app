@extends('layouts.app')

@section('content')
    <div class="flex justify-center min-h-screen">
        <div class="w-full sm:w-[80%] bg-gray-200 p-4 flex flex-col items-center">
            <h1 class="text-2xl font-bold mb-4">Project List</h1>

            @if ($projects->isEmpty())
                <p>No projects found</p>
            @else
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Description</th>
                            <th class="py-2 px-4 border-b">Created At</th>
                            <th class="py-2 px-4 border-b"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $project->id }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('projects.edit', $project) }}"
                                        class="hover:bg-green-100 rounded py-1 px-2 w-full">
                                        {{ $project->name }}
                                    </a>
                                </td>
                                <td class="py-2 px-4 border-b">{{ $project->description }}</td>
                                <td class="py-2 px-4 border-b">{{ $project->created_at }}</td>
                                <td class="py-2 px-4 border-b">
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                        onsubmit="return confirm('Send To Trash?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <form action="{{ route('projects.store') }}" method="POST"
                class="space-y-4 flex justify-start items-center min-w-full gap-3 mt-6">
                @csrf

                <div>

                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full border-0 border-black border-b-2 bg-transparent focus:outline-none  p-2"
                        required autocomplete="off">
                    <label for="name" class="block text-sm font-medium text-gray-700">Project
                        Name</label>
                </div>

                <div>
                    <input name="description" id="description" rows="1"
                        class="mt-1 block w-full border-0 border-black border-b-2 bg-transparent focus:outline-none  p-2"></input>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                </div>

                <div class="self-end">
                    <button type="submit" class="bg-green-500 text-white p-2   hover:bg-green-700 rounded-full transition">
                        <svg class="h-6 w-6 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 12H18M12 6V18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-4 flex gap-2">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
@endsection
