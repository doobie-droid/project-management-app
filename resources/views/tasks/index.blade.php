@extends('layouts.app')

@section('content')
    <div class="flex justify-center min-h-screen">

        <div class="w-full sm:w-[80%] bg-gray-200 p-4 flex flex-col items-center">
            <div class="flex gap-4 justify-between items-center w-full">

                <h1 class="text-2xl font-bold mb-4 text-green-400 hover:text-green-500 underline underline-offset-2"><a
                        href="/">Home</a>
                </h1>

                <form method="GET" action="{{ route('tasks.index') }}" class="mb-4 place-items-end">
                    <div class="flex items-center gap-4">

                        <select name="project_id" id="project_id"
                            class="tom-select border-0 border-black border-b-2 bg-transparent focus:outline-none p-2">
                            <option value="">All Projects</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                            Filter
                        </button>

                    </div>
                </form>

            </div>

            @if ($tasks->isEmpty())
                <p>No tasks found</p>
            @else
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 px-4 border-b"></th>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Task Name</th>
                            <th class="py-2 px-4 border-b">Project</th>
                            <th class="py-2 px-4 border-b">Created At</th>

                            <th class="py-2 px-4 border-b"></th>
                            <th class="py-2 px-4 border-b"></th>
                        </tr>
                    </thead>
                    <tbody id="taskTableBody">
                        @foreach ($tasks as $task)
                            <tr data-id="{{ $task->id }}" data-priority="{{ $task->priority }}"
                                class="cursor-grab active:cursor-grabbing">
                                <td class="py-2 px-2 border-b text-gray-500 align-middle">

                                    <span class="block leading-tight text-lg select-none">
                                        &#61;
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b">{{ $task->id }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('tasks.edit', $task) }}"
                                        class="hover:bg-green-100 rounded py-1 px-2 w-full">
                                        {{ $task->name }}
                                    </a>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('projects.edit', $task->project) }}"
                                        class="hover:bg-green-100 rounded py-1 px-2 w-full">
                                        {{ $task->project->name }}
                                    </a>
                                </td>
                                <td class="py-2 px-4 border-b">{{ $task->created_at }}</td>
                                <td class="py-2 px-4 border-b">
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                        onsubmit="return confirm('Send To Trash?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                <td class="py-2 px-2 border-b text-gray-500 align-middle">

                                    <span class="block leading-tight text-lg select-none">
                                        &#61;
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <form action="{{ route('tasks.store') }}" method="POST"
                class="space-y-4 flex justify-start items-center min-w-full gap-3 mt-6">
                @csrf

                <div>

                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full border-0 border-black border-b-2 bg-transparent focus:outline-none  p-2"
                        required autocomplete="off">
                    <label for="name" class="block text-sm font-medium text-gray-700">Task
                        Name</label>
                </div>

                <div>
                    <select name="project_id" id="project_id"
                        class="mt-1 block w-full border-0  bg-transparent focus:outline-none p-2" required>
                        <option value="" disabled selected hidden>Select Project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
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
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.getElementById('taskTableBody');

            new Sortable(tableBody, {
                animation: 150,
                onEnd: function(evt) {

                    let order = [];
                    const rows = Array.from(document.querySelectorAll('#taskTableBody tr'));
                    const minPriority = Math.min(...rows.map(row => Number(row.dataset.priority)));
                    order = rows.map((row, index) => ({
                        id: row.dataset.id,
                        priority: minPriority + index
                    }));

                    console.log(order);
                    // Send updated positions to server via POST
                    fetch("{{ route('tasks.reorder') }}", {
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                order: order
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                        })
                        .catch(error => {
                            console.error('Error updating task order:', error);
                        });
                }
            });
        });
    </script>
@endsection
