@extends('layouts.app')

@section('content')
<div class="max-w-[35rem] px-4 py-10 sm:px-6 lg:px-8 mx-auto">
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 sm:p-7">
      <div class="text-center">
        <h1 class="block text-2xl font-bold text-gray-800">{{ __('Login') }}</h1>
      </div>

      <div class="mt-5">
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="grid gap-y-4">
            <div>
              <label for="email" class="block text-sm mb-2 font-medium text-gray-700">{{ __('Email Address') }}</label>
              <div class="relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}" 
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('email') border-red-500 @enderror" 
                  required autocomplete="email" autofocus>
                
                @error('email')
                  <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                    <i data-lucide="alert-circle" class="size-5 text-red-500"></i>
                  </div>
                @enderror
              </div>
              @error('email')
                <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <div class="flex justify-between items-center">
                <label for="password" class="block text-sm mb-2 font-medium text-gray-700">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                  <a class="text-sm text-blue-600 decoration-2 hover:underline font-medium focus:outline-none focus:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                  </a>
                @endif
              </div>
              <div class="relative">
                <input id="password" type="password" name="password" 
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('password') border-red-500 @enderror" 
                  required autocomplete="current-password">
                
                @error('password')
                  <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                    <i data-lucide="alert-circle" class="size-5 text-red-500"></i>
                  </div>
                @enderror
              </div>
              @error('password')
                <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
              @enderror
            </div>

            <div class="flex items-center">
              <div class="flex">
                <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                  class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500">
              </div>
              <div class="ms-3">
                <label for="remember" class="text-sm text-gray-700">{{ __('Remember Me') }}</label>
              </div>
            </div>

            <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
              {{ __('Login') }}
            </button>
          </div>
        </form>
        </div>
    </div>
  </div>
</div>
@endsection