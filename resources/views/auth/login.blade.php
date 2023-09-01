@extends('layouts.standard')

@section('content')

  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <div class="grid lg:grid-cols-2 h-screen mx-8 py-4">

    <div class="p-8 flex items-center justify-center">
        <div class="w-10/12">

            <h1 class="text-primary text-2xl font-bold mb-2">Welcome Back</h1>

            <p class="text-black text-base">Please enter your details to sign in.</p>

            {{-- form --}}
            <form method="POST" action="{{ route('login') }}" class="w-full max-w-md mt-4">

                @csrf

                <!-- Email Address -->
                <div>
                <x-input-label for="email" :value="__('Email')" />
                
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ml-3">
                    {{ __('Log in') }}
                </x-primary-button>
                </div>

            </form>
        </div>

    </div>

    <div class="p-8 hidden bg-gray-200 lg:flex items-center ">
      
      <div class="max-w-md">
      
        <h2 class="text-2xl font-bold mb-4">Client Testimonials</h2>
      
        <blockquote class="italic text-gray-700">
          "Working with Company XYZ was an amazing experience!"
        </blockquote>
      
      </div>

    </div>

  </div>

@endsection