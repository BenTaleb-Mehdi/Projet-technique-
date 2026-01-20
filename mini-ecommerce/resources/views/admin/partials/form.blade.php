<div id="alert-container" class="fixed top-4 right-4 z-[100] min-w-[300px]"></div>
<div id="hs-danger-alert" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1" aria-labelledby="hs-danger-alert-label">
  
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-4xl md:w-full m-3 md:mx-auto">
    
    <div class="relative flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl overflow-hidden">
       <div class="text-end p-5">
         <button type="button" class="py-2 px-3 max-w-[50px] inline-lex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50" data-hs-overlay="#hs-danger-alert">
          <i data-lucide="x" class="w-4"></i>  
        </button>
       </div>
      <!-- Card Section -->
      <div class="w-full px-3 sm:px-6 lg:px-6  mx-auto">
        <form id="productForm" data-store-url="{{ route('products.store') }}">
          @csrf
          <input type="hidden" name="_method" id="methodField" value="POST">
          <input type="hidden" id="productId">

          <div class="bg-white rounded-xl shadow-xs">
            <div class="pt-0 p-4 sm:pt-0 sm:p-7">
              <div class="space-y-4 sm:space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="space-y-2">
                  <label for="af-submit-app-project-name" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                    Product name
                  </label>

                  <input id="productName" type="text" name="name" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter product name">
                </div>
                <div class="space-y-2">
                  <label for="af-submit-app-price" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                    Price
                  </label>

                  <input id="productPrice" type="number" step="0.01" name="price" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter price">
                </div>
                </div>

        

                <div class="space-y-2">
                  <label for="af-submit-app-upload-images" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                    Preview image
                  </label>

                  <label for="af-submit-app-upload-images" class="group p-4 sm:p-7 block cursor-pointer text-center border-2 border-dashed border-gray-200 rounded-lg focus-within:outline-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2">
                    <input id="af-submit-app-upload-images" name="image" type="file" class="sr-only">
                    <svg class="size-10 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z"/>
                      <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                    </svg>
                    <span class="mt-2 block text-sm text-gray-800">
                      Browse your device or <span class="group-hover:text-blue-700 text-blue-600">drag 'n drop'</span>
                    </span>
                    <span class="mt-1 block text-xs text-gray-500">
                      Maximum file size is 2 MB
                    </span>
                  </label>
                  
                  <div class="mt-4 hidden" id="previewContainer">
                      <p class="text-sm text-gray-500 mb-2">Aperçu :</p>
                      <img id="imagePreview" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg border border-gray-200">
                  </div>
                </div>


                <div class="space-y-2">
                  <label class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                    Select Categories
                  </label>
                  
                  <select id="categorySelect" name="categories[]" multiple data-hs-select='{
                    "placeholder": "Select categories...",
                    "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex items-center gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500",
                    "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 shadow-md",
                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100",
                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                  }' class="hidden">
                    <option value="">Choose</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->label }}</option>
                    @endforeach
                  </select>
                </div>

             

                <div class="space-y-2">
                  <label for="af-submit-app-description" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                    Description
                  </label>

                  <textarea id="productDescription" name="description" class="py-1.5 sm:py-2 px-3 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" rows="6" placeholder="A detailed summary..."></textarea>
                </div>
              </div>
              <!-- End Grid -->

              <div class="mt-5 flex gap-x-2">
                <button type="submit" id="submitBtn" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                  Submit
                </button>
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50" data-hs-overlay="#hs-danger-alert">
                Cancel
              </button>
              </div>

            </div>
          </div>
          <!-- End Card -->
        </form>
      </div>
      <!-- End Card Section -->
    </div>
  </div>
</div>