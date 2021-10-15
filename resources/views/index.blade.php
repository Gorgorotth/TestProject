<x-layout>
<div class="max-w-lg mx-auto border border-gray-200 mt-10 bg-gray-100 p-6 rounded-xl">
    <h1 class="font-bold text-center text-xl">Log In</h1>
    <form method="POST" action="{{route('submit.login')}}" class="mt-10">
        @csrf

        <x-form.input name="email" type="email" autocomplete="username"/>

        <x-form.input name="password" type="password" autocomplte="new.password"/>

        <div>
            <button type="submit" class="bg-blue-500 text-white rounded my-2 py-2 px-8">Log in</button>
        </div>


    </form>
</div>
</x-layout>
