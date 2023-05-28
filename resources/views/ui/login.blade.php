@extends('ui.template.layout')
@section('content')

<div class="flex flex-col justify-center mt-10 px-6 py-12 lg:px-8">
    <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm p-10 rounded-sm border border-slate-600">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-32 w-auto" src="{{ url('images/ebidmo.png') }}" alt="eBidMo">
            <h2 class="mt-2 text-center text-2xl font-semibold leading-9 tracking-tight text-gray-200 mb-10 pb-2 border-b border-slate-600">Account Login</h2>
        </div>
        <form class="space-y-5" action="#" method="POST">
            <div>
                <label for="username" class="inline-flex text-sm font-medium leading-6 text-gray-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    &nbsp;Email
                </label>
            <div class="mt-2">
                <input id="username" name="username" type="text" autocomplete="username" required class="block w-full rounded-sm border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-300 sm:text-sm sm:leading-6">
            </div>
            </div>
    
            <div>
            <div class="flex items-center justify-between">
                <label for="password" class="inline-flex text-sm font-medium leading-6 text-gray-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"></path>
                    </svg>
                    &nbsp;Password
                </label>
                
            </div>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-sm border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-300 sm:text-sm sm:leading-6">
            </div>
            <div class="flex items-center justify-between mt-2">
                <span class="text-sm font-semibold text-gray-400">
                    <input class="leading-tight text-orange-400" type="checkbox" id="remember" name="remember">
                    Remember me
                </span>
                <div class="text-sm">
                    <a href="{{ url('account/forgot-password') }}" class="font-semibold text-orange-400 hover:text-orange-500">Forgot password?</a>
                </div>
            </div>
            </div>
    
            <div>
            <button type="submit" class="flex w-full justify-center items-center rounded-sm bg-slate-900 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-slate-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-950">
                Sign in
            </button>
            </div>
        </form>
        <p class="mt-10 text-center text-sm text-gray-300">
            Don't have an account?
            <a href="{{ url('register') }}" class="font-semibold text-orange-400 hover:text-orange-500">Sign Up</a>
          </p>
    </div>
</div>

@endsection