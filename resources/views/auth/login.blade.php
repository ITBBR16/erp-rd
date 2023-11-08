@extends('auth.layouts.main')

@section('container')
    <img src="/img/wave.png" alt="Login" class="fixed hidden lg:block inset-0 h-full" style="z-index: -1;">
    <div class="w-screen h-screen flex flex-col justify-center items-center lg:grid lg:grid-cols-2">
        <img src="/img/unlock.svg" alt="" class="hidden lg:block w-1/3 transition-all mx-auto">
        <div class="flex flex-col justify-center items-center w-1/2">
            <img src="img/Logo Rumah Drone - Digital_Abstract Logo - Black.png" class="w-32 border rounded-full border-gray-700" />
            <h2 class="my-8 font-display font-bold text-3xl text-gray-700 text-center">
                Welcome Back
            </h2>
            @if (session()->has('loginError'))
        
                <div id="alert-failed-login" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                    <span class="material-symbols-outlined flex-shrink-0 w-5 h-5">info</span>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('loginError') }}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-failed-login" aria-label="Close">
                        <span class="sr-only">Dismiss</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            
            @endif
            <form action="{{ route('form-login') }}" method="POST">
                @csrf
                <div class="relative">
                    <span class="material-symbols-outlined absolute text-gray-700 text-3xl">person</span>
                    <input type="text" name="username" id="username" placeholder="Username" class="pl-8 text-gray-900 border-0 border-b-2 focus:outline-none focus:ring-0 focus:border-blue-600 text-lg @error('username') border-red-600 dark:border-red-500 @enderror" value="{{ old('username') }}" autofocus>
                </div>
                <div class="relative mt-8">
                    <span class="material-symbols-outlined absolute text-gray-700 text-3xl">lock</span>
                    <input type="password" name="password" id="password" placeholder="Password" class="pl-8 text-gray-900 border-0 border-b-2 font-display focus:outline-none focus:ring-0 focus:border-blue-600 text-lg @error('password') border-red-600 dark:border-red-500 @enderror">
                </div>
                <div class="relative mt-4 text-center">
                    <button type="submit" class="py-3 px-20 text-blue-600 hover:text-white border border-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection