@if (session()->has('success'))

    <div x-data="{show: true}"
         x-init="setTimeout(() => show=false, 4000)"
         x-show="show"
         class="fixed bg-green-500 rounded-xl bottom-3 right-3">

        <p class="text-white p-1 mx-2 my-2">{{session()->get('success')}}</p>
    </div>

@elseif(session()->has('error'))

    <div x-data="{show: true}"
         x-init="setTimeout(() => show=false, 4000)"
         x-show="show"
         class="fixed bg-red-500 rounded-xl bottom-3 right-3">

        <p class="text-white p-1 mx-2 my-2">{{session()->get('error')}}</p>

    </div>
@elseif(session()->has('alert'))

    <div x-data="{show: true}"
         x-init="setTimeout(() => show=false, 4000)"
         x-show="show"
         class="fixed flex bg-yellow-400 rounded-xl bottom-3 right-3">
        <div class="flex">
            <img src="/images/warning.png" alt="Warning" class="bg-white-400 hover:bg-green-900" width="40" height="4">
        </div>
        <div>
            <p class="text-white p-1 mx-2 my-2">{{session()->get('alert')}}</p>
        </div>

    </div>
@endif

