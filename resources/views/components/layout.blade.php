<!doctype html>
<html>
<head>
    <link href="https://unpkg.com/tailwindcss@2.2.11/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
@auth()
    <section class="border border-black">
        <div class="flex justify-between">
            <a href="/file" class="pl-2 hover:text-blue-300">Home</a>
            <div class="flex">
                <a href="{{route('file.create')}}" class="mr-2 hover:text-blue-400">Add new file</a>
                <a href="{{route('logout')}}" class="pr-2 hover:text-blue-400">Logout</a>
            </div>
        </div>
    </section>
@endauth
{{$slot}}
</body>
</html>
