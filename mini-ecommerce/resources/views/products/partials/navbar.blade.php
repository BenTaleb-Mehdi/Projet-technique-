<header class="relative flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-3 p-5">
  <nav class="max-w-[85rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between p-5">
    <div class="flex items-center justify-between">
      <a class="flex-none text-xl font-semibold focus:outline-hidden focus:opacity-80" href="{{ route('products.index') }}" aria-label="{{ __('views.brand') }}">
        ECO Shop
      </a>
      <div class="sm:hidden">
        <button type="button" class="hs-collapse-toggle relative size-9 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" id="hs-navbar-example-collapse" aria-expanded="false" aria-controls="hs-navbar-example" aria-label="{{ __('actions.toggle_navigation') }}" data-hs-collapse="#hs-navbar-example">
          <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
          <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
          <span class="sr-only">{{ __('actions.toggle_navigation') }}</span>
        </button>
      </div>
    </div>

    <div id="hs-navbar-example" class="hidden hs-collapse overflow-hidden transition-all duration-300 basis-full grow sm:block" aria-labelledby="hs-navbar-example-collapse">
      <div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">
        
       



        @auth
        <div class="hs-dropdown relative inline-flex ms-2">
          <button id="hs-dropdown-account" type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none">
            <span class="flex shrink-0 justify-center items-center size-6 bg-blue-600 text-white text-[10px] font-semibold rounded-full uppercase">
              {{ substr(Auth::user()->name, 0, 1) }}
            </span>
            <span class="hidden md:block text-gray-600 font-medium">{{ Auth::user()->name }}</span>
            <svg class="hs-dropdown-open:rotate-180 size-4 text-gray-500 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
          </button>

          <div class="hs-dropdown-menu transition-[opacity,margin] duration-150 hs-dropdown-open:opacity-100 opacity-0 hidden min-w-48 bg-white border border-gray-200 shadow-lg rounded-xl p-1 mt-2 z-50" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account">
            <div class="py-2 px-3 border-b border-gray-100">
              <p class="text-xs text-gray-500">Role</p>
              <p class="text-xs font-bold uppercase {{ Auth::user()->role === 'admin' ? 'text-red-600' : 'text-blue-600' }}">
                {{ Auth::user()->role }}
              </p>
            </div>

            @if(Auth::user()->role === 'admin')
            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none" href="{{ route('admin.partials.index') }}">
              <i data-lucide="layout-dashboard" class="size-4"></i> {{ __('views.dashboard') }}
            </a>
            @endif

            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none" href="{{ route('lang.switch', 'en') }}">
              English
              @if(app()->getLocale() == 'en')
                <svg class="ms-auto size-3.5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
              @endif
            </a>

            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none" href="{{ route('lang.switch', 'fr') }}">
              Français
              @if(app()->getLocale() == 'fr')
                <svg class="ms-auto size-3.5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
              @endif
            </a>

            <div class="mt-1 border-t border-gray-100">
              <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-red-50 focus:outline-none" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i data-lucide="log-out" class="size-4"></i> Logout
              </a>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
              @csrf
            </form>
          </div>
        </div>
        @else
        <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none" href="{{ route('login') }}">
          Login
        </a>
        @endauth

      </div>
    </div>
  </nav>
</header>