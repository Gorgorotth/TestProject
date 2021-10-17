<x-layout>
    <div class="max-w-lg mx-auto border border-gray-200 mt-10 bg-gray-100 p-6 rounded-xl">
        <h1 class="font-bold text-center text-xl">Rename file</h1>
        <label>{{$file->name}}</label>
        <form method="POST" action="{{route('file.update', ['id' => $file->id])}}" class="mt-10">
            @csrf

            <x-form.input name="name" />

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white rounded my-2 py-2 px-8">Rename</button>
            </div>


        </form>
    </div>
</x-layout>
