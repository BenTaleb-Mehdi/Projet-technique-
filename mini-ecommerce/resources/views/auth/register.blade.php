@extends('layouts.app')

@section('content')
<div class="max-w-[40rem] px-4 py-10 sm:px-6 lg:px-8 mx-auto">
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 sm:p-7">
      <div class="text-center">
        <h1 class="block text-2xl font-bold text-gray-800">{{ __('Register') }}</h1>
        <p class="mt-2 text-sm text-gray-600">
          Already have an account?
          <a class="text-blue-600 decoration-2 hover:underline font-medium focus:outline-none focus:underline" href="{{ route('login') }}">
            Sign in here
          </a>
        </p>
      </div>

      <div class="mt-5">
        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="grid gap-y-4">
            <div>
              <label for="name" class="block text-sm mb-2 font-medium text-gray-700">{{ __('Name') }}</label>
              <input id="name" type="text" name="name" value="{{ old('name') }}" 
                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('name') border-red-500 @enderror" 
                required autocomplete="name" autofocus>
              
              @error('name')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="email" class="block text-sm mb-2 font-medium text-gray-700">{{ __('Email Address') }}</label>
              <input id="email" type="email" name="email" value="{{ old('email') }}" 
                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('email') border-red-500 @enderror" 
                required autocomplete="email">
              
              @error('email')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="password" class="block text-sm mb-2 font-medium text-gray-700">{{ __('Password') }}</label>
              <input id="password" type="password" name="password" 
                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('password') border-red-500 @enderror" 
                required autocomplete="new-password">
              
              @error('password')
                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="password-confirm" class="block text-sm mb-2 font-medium text-gray-700">{{ __('Confirm Password') }}</label>
              <input id="password-confirm" type="password" name="password_confirmation" 
                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
                required autocomplete="new-password">
            </div>

            <button type="submit" class="w-full mt-2 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
              {{ __('Register') }}
            </button>
          </div>
        </form>
        </div>
    </div>
  </div>
</div>
@endsection