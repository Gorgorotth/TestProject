<x-layout>
    <div class="max-w-lg mx-auto border border-gray-200 mt-10 bg-gray-100 p-6 rounded-xl">
    <h1 class="font-bold text-center text-xl">Add password to your zip file /or download it</h1>
    <form method="POST" action="{{route('zip.setPassword', ['id' => $id])}}" class="mt-10">
        @csrf

        <x-form.input name="password" type="password" required=""/>

        <div class="text-center">
            <button type="submit" class="bg-blue-500 text-white rounded my-2 py-2 px-8 hover:bg-yellow-500">Add password</button>
            </div>
    </form>

        <div class="text-center mt-20">
        <form method="post" action="{{route('zip.download', ['id' => $id])}}">
            @csrf
            <button type="submit" class="bg-blue-500 text-white rounded my-2 py-2 px-8 hover:bg-green-500">Download</button>
        </form>

        </div>



    </div>
</x-layout>
