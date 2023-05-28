@extends('web.template.layout')
@section('content')

    <header class="absolute inset-x-0 top-0 z-50">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
        <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">eBidmo</span>
        </a>
        </div>
        <div class="flex lg:hidden">
        <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Open main menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
        <a href="/" class="text-sm font-semibold leading-6 text-gray-200">Home</a>

        <a href="https://www.exypnos.net/news-and-updates/" class="text-sm font-semibold leading-6 text-gray-200">News & Updates</a>
        <a href="https://www.exypnos.net/" class="text-sm font-semibold leading-6 text-gray-200">Company</a>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        <!--<a href="#" class="text-sm font-semibold leading-6 text-gray-200">Sign Up <span aria-hidden="true">&rarr;</span></a>-->
        </div>
    </nav>
    </header>

    <div class="relative isolate px-6 lg:px-8">

    <div class="mx-auto max-w-2xl py-24 sm:py-24 lg:py-32">
        <h1 class="text-4xl font-bold tracking-tight text-amber-500 sm:text-6xl text-center mb-10">Coming Soon <i class="fa fa-cog fa-spin"></i></h1>
        
        <div class="h-32 w-32 mx-auto" style="background: url('{{ url('images/ebidmo.png')}}') no-repeat; background-size: 120px 120px; background-position: center;"></div>
        <!--<img class="h-32 w-auto mx-auto text-center" src="{{ url('images/ebidmo.png') }}" alt="">-->
        <div class="text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-200 sm:text-6xl">Discover a new way to buy and sell online with eBidMo!</h1>
        <p class="mt-6 text-lg leading-8 text-gray-500">Get ready to experience the next level of bidding with our revolutionary features that will keep you engaged and entertained.</p>
        <div class="hidden sm:mb-8 sm:flex sm:justify-center mt-6">
            <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-100 ring-1 ring-gray-200/10 hover:ring-gray-200/20">
            Be the first to experience the newest and hottest marketplace before anyone else! <a href="https://www.exypnos.net/ebidmoph/" class="font-semibold text-amber-400"><span class="absolute inset-0" aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
        <!--<div class="mt-10 flex items-center justify-center gap-x-6">
            <a href="#" class="rounded-md bg-amber-500 px-3.5 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-amber-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600">Get started</a>
        </div>-->
        <div class="mt-10 flex items-center justify-center gap-x-3">
            <p class="text-white">Follow us on facebook</p>
            <a href="https://www.facebook.com/exypnos.rs" class="text-white"><i class="fab fa-facebook-square fa-2x text-gray-300"></i></a>
        </div>
        </div>
    </div>

    </div>
    
@endsection
