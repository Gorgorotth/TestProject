<x-layout>
    <div class="block">
    @foreach($files as $file)
        <div class="flex mt-8 pb-8 md:justify-between border-b border-gray-600">
                <div class="flex ">
                    <p class="text-green-500">File Name:{{$file->name}}</p>
                    <a class="mx-6  hover:text-blue-400" href="{{$file->file_path}}">Raw File</a>
                    @if ($file->zipped == true)
                    <a class="mx-6  hover:text-blue-400" href="{{route('file.edit',['id' => $file->id])}}">Zip file</a>
                    @endif
                </div>

                <div class="flex ">

                    <a  class="mx-6  hover:text-blue-400" href="{{route('file.edit', ['id' => $file->id])}}">Edit</a><br>

                    <a class="mx-6  hover:text-blue-400" href="{{route('file.delete', ['id' => $file->id])}}">Delete</a><br>

            </div>
            </div>
        @endforeach

    </div>
</x-layout>
