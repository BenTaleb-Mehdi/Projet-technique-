<div id="alert-container" class="fixed top-4 right-4 z-[120] min-w-[300px]"></div>
<div id="product-modal" 
     class="fixed inset-0 z-[150] flex items-center justify-center p-4 overflow-y-auto" 
     x-show="isProductModalOpen"
     x-cloak>
  
  <!-- Backdrop -->
  <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" 
       x-show="isProductModalOpen"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       @click="isProductModalOpen = false"></div>

  <!-- Modal Card -->
  <div class="relative flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl overflow-hidden max-w-4xl w-full z-10"
       x-show="isProductModalOpen"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0 scale-95"
       x-transition:enter-end="opacity-100 scale-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100 scale-100"
       x-transition:leave-end="opacity-0 scale-95">
       
       <div class="text-end p-5">
         <button type="button" 
                 class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-all" 
                 @click="isProductModalOpen = false">
          <i data-lucide="x" class="w-4 h-4"></i>  
        </button>
       </div>

      <!-- Card Section -->
      <div class="w-full px-3 sm:px-6 lg:px-6 mx-auto pb-6">
        <form id="productForm" @submit.prevent="saveProduct($event)" data-store-url="{{ route('products.store') }}" class="pt-0 p-4 sm:pt-0 sm:p-7">
          @csrf
          <input type="hidden" name="_method" id="methodField" value="POST">
          <input type="hidden" id="productId">

          <div class="space-y-4 sm:space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="space-y-2">
                <label for="productName" class="inline-block text-sm font-medium text-gray-800">
                  {{ __('models.product_name') }}
                </label>
                <input id="productName" type="text" name="name" class="py-2 px-3 block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('views.enter_product_name') }}">
              </div>
              <div class="space-y-2">
                <label for="productPrice" class="inline-block text-sm font-medium text-gray-800">
                  {{ __('models.price') }}
                </label>
                <input id="productPrice" type="number" step="0.01" name="price" class="py-2 px-3 block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('views.enter_price') }}">
              </div>
            </div>

            <div class="space-y-2">
              <label for="af-submit-app-upload-images" class="inline-block text-sm font-medium text-gray-800">
                {{ __('views.preview_image') }}
              </label>
              <label for="af-submit-app-upload-images" class="group p-4 sm:p-7 block cursor-pointer text-center border-2 border-dashed border-gray-200 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 transition-all hover:border-blue-400">
                <input id="af-submit-app-upload-images" @change="handleImageChange($event)" name="image" type="file" class="sr-only">
                <i data-lucide="upload-cloud" class="w-10 h-10 mx-auto text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                <span class="mt-2 block text-sm text-gray-800">
                  {{ __('views.browse_device') }} <span class="group-hover:text-blue-700 text-blue-600 font-semibold">{{ __('views.drag_n_drop') }}</span>
                </span>
                <span class="mt-1 block text-xs text-gray-500">
                  {{ __('views.max_file_size') }}
                </span>
              </label>
              
              <div class="mt-4 hidden" id="previewContainer">
                  <p class="text-sm text-gray-500 mb-2">{{ __('views.preview_label') }}</p>
                  <img id="imagePreview" src="" alt="{{ __('views.preview_alt') }}" class="w-full h-48 object-cover rounded-lg border border-gray-200 shadow-inner">
              </div>
            </div>

            <div class="space-y-2">
              <label class="inline-block text-sm font-medium text-gray-800">
                {{ __('views.select_categories') }}
              </label>
              <select id="categorySelect" name="categories[]" multiple data-hs-select='{
                "placeholder": "{{ __('views.select_categories_placeholder') }}",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex items-center gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                "dropdownClasses": "mt-2 z-[110] w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto shadow-lg",
                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
              }' class="hidden">
                <option value="">{{ __('actions.choose') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->label }}</option>
                @endforeach
              </select>
            </div>

            <div class="space-y-2">
              <label for="productDescription" class="inline-block text-sm font-medium text-gray-800">
                {{ __('models.description') }}
              </label>
              <textarea id="productDescription" name="description" class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" rows="4" placeholder="{{ __('views.description_placeholder') }}"></textarea>
            </div>
          </div>

          <div class="mt-8 flex gap-x-2">
            <button type="submit" id="submitBtn" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 transition-all shadow-sm">
              {{ __('actions.submit') }}
            </button>
            <button type="button" 
                    class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-all" 
                    @click="isProductModalOpen = false">
            {{ __('actions.cancel') }}
          </button>
          </div>
        </form>
      </div>
  </div>
</div>