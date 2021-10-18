<x-layout>
    <div class="max-w-lg mx-auto border border-gray-200 mt-10 bg-gray-100 p-6 rounded-xl">
        <h1 class="font-bold text-center text-xl">Add File</h1>
        <form method="POST" action="{{route('file.add')}}" class="mt-10" enctype="multipart/form-data">
            @csrf
            <x-form.input required="" name="fileName"/>
            <x-form.input name="file" type="file"/>
            <div>
                <button type="submit" class="bg-blue-500 text-white rounded my-2 py-2 px-8">Add a file</button>
            </div>
        </form>
    </div>
</x-layout>
