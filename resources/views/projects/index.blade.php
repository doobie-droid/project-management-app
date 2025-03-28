<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex justify-center min-h-screen">
        <div class="w-full sm:w-[80%] bg-gray-200 p-4 flex flex-col items-center ">
            <h1 class="text-2xl font-bold mb-4">Project List</h1>
            @if ($projects->isEmpty())
                <p>No projects found</p>
            @else
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class=" text-left">
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Price</th>
                            <th class="py-2 px-4 border-b">Created At</th>
                            <th class="py-2 px-4 border-b"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $project->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $project->name }}</td>
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
                class="space-y-4 flex justify-start items-center   min-w-full gap-3">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full border border-gray-300 rounded p-2" required>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="1"
                        class="mt-1 block w-full border border-gray-300 rounded p-2"></textarea>
                </div>

                <div class="self-end">
                    <button type="submit"
                        class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-500 transition">
                        New
                    </button>
                </div>
            </form>
            <div class="mt-4 flex gap-2">
                {{ $projects->links() }}
            </div>
        </div>

    </div>

</body>

</html>
