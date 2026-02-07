    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ __('views.product_management') }}</h1>
            <p class="text-sm text-gray-600">{{ __('views.manage_inventory') }}</p>
        </div>
        <button type="button" 
                @click="openCreateModal()"
                class="inline-flex items-center gap-x-2 py-2.5 px-4 rounded-lg text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('actions.add_product') }}
        </button>
    </div>

    <div class="p-4 border border-gray-200 bg-white rounded-t-xl">
        <div class="flex flex-wrap items-center gap-4 justify-end">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400" x-show="!isLoading"></i>
                    <div x-show="isLoading" class="animate-spin rounded-full h-4 w-4 border-2 border-blue-500 border-t-transparent"></div>
                </div>
                <input type="text" 
                       x-model.debounce.300ms="search"
                       placeholder="{{ __('views.search_product_placeholder') }}" 
                       class="py-3 pl-10 pr-4 block w-full bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            </div>

            <div class="relative w-full sm:w-56">
                <select id="categoryFilter" x-model="category" class="hidden" data-hs-select='{
                    "placeholder": "{{ __("views.all_categories") }}",
                    "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex items-center gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                    "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto shadow-lg",
                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100",
                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                }'>
                    <option value="">{{ __('views.all_categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->label }}</option>
                    @endforeach
                </select>
                <button type="button" @click="category = ''" class="absolute top-1/2 end-8 -translate-y-1/2 text-gray-400 hover:text-red-500">
                    <i data-lucide="x" class="size-3.5"></i>
                </button>
            </div>
        </div>
    </div>