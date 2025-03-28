<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex justify-center min-h-screen">
        <div class="w-full sm:w-[80%] bg-gray-200 p-2 flex flex-col items-center ">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $project->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $project->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $project->description }}</td>
                                <td class="py-2 px-4 border-b">{{ $project->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <div class="mt-4 flex gap-2">
                {{ $projects->links() }}
            </div>
        </div>

    </div>

</body>

</html>
