@extends('ui.template.layout')
@section('content')

<div class="flex flex-col justify-center mt-10 px-6 py-12 lg:px-8">
    <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm bg-white p-10 rounded-sm">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-2 text-center text-2xl font-semibold leading-9 tracking-tight text-gray-900 mb-10 pb-2 border-b border-gray-100">
                Forgot Password
            </h2>
        </div>
        <form class="space-y-3" action="#" method="POST">
            <div class="flex items-center justify-between">
                <label for="username" class="inline-flex text-sm font-medium leading-6 text-gray-900">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"></path>
                    </svg>
                    &nbsp;Email Address
                </label>
                <div class="text-sm">
                <a href="{{ url('login') }}" class="font-semibold text-orange-400 hover:text-orange-500">Back to login</a>
                </div>
            </div>
            <div class="mt-2">
                <input id="email-address" name="email-address" type="text" autocomplete="email-address" required class="block w-full rounded-sm border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-300 sm:text-sm sm:leading-6">
            </div>

            <button type="submit" class="flex w-full justify-center items-center rounded-sm bg-slate-800 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                Submit
            </button>
            </div>
        </form>
    </div>
</div>

@endsection