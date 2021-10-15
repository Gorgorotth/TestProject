<x-layout>
    <div class="block mt-6">
        @foreach($files as $file)
            @csrf
            <div class="md:justify-start block my-6  mx-2">

                <p class="text-green-500">File Name:  {{$file->name}}
                </p>
                </div>
                <div class="block">
                    <a class="mx-6  hover:text-blue-400" href="{{$file->file_path}}">Raw File--{{$file->name}}</a>
                    @if ($file->zipped == true)
                    <a class="mx-6  hover:text-blue-400" href="{{route('file.edit',['id' => $file->id])}}">Zip File--{{$file->name . '.zip'}}</a>
                    @endif
                </div>

                <div class="flex md:justify-end border-b border-gray-600">

                    <a  class="mx-6  hover:text-blue-400" href="{{route('file.edit', ['id' => $file->id])}}">Edit</a><br>

                    <a class="mx-6  hover:text-blue-400" href="">Delete</a><br>

{{--                    <a class="mx-2  hover:text-blue-400" href="{{route('delete.file', ['slug' => $post->slug])}}">Delete</a><br>--}}

                </div>

        @endforeach
    </div>
</x-layout>
