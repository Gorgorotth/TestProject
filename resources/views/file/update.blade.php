<x-layout>
    <div class="text-center">
        <div>
            <form method="POST" action="{{route('file.update', ['id' => $file->id])}}" enctype="multipart/form-data">
                @csrf
                <label for="fileName">Name</label><br>
                <input name="fileName" type="text" class=" border  border-gray-600 text-center" value="{{$file->name}}" />
                <button class="bg-blue-500 rounded text-white px-2" type="submit">Change Name</button>
            </form>
        </div>

        <div class="mt-10">

        </div>
    </div>
</x-layout>
