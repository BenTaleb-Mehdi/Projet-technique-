<div id="hs-scroll-inside-body-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none lg:w-full" role="dialog" tabindex="-1" aria-labelledby="hs-scroll-inside-body-modal-label">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-7xl sm:w-full m-3 h-[calc(100%-56px)] sm:mx-auto lg:w-full">
    <div class="max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto">
      <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
        <h3 id="hs-scroll-inside-body-modal-label" class="font-bold text-gray-800">
          Add new product
        </h3>
        <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#hs-scroll-inside-body-modal">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
      <div class="p-2 overflow-y-auto w-full">

          <!-- Card Section -->
          <div class="w-full sm:px-6 lg:px-8 lg:py-5 mx-auto">
            <form id="Formproduct" enctype="multipart/form-data" data-url="{{ route('products.store') }}">
              @csrf
              <!-- Card -->
              <div class="w-full bg-white rounded-xl shadow-xs">
              
                <div class="pt-0 p-4 sm:pt-0 sm:p-7">
                  <!-- Grid -->
                  <div class="space-y-4 sm:space-y-6">
                  
                    <div class="space-y-2">
                      <label for="af-submit-app-project-name" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                        Product name
                      </label>

                      <input id="af-submit-app-project-name" type="text" name="productName" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter product name">
                    </div>

                    <div class="space-y-2">
                      <label for="af-submit-project-url" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                        Product price
                      </label>

                      <input id="af-submit-project-url" name="productPrice" type="text" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border border-gray-200 shadow-2xs sm:text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter product price">
                    </div>

                    <div class="space-y-2">
                      <label for="af-submit-app-upload-images" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                        Preview image
                      </label>

                      <label for="af-submit-app-upload-images" class="group p-4 sm:p-7 block cursor-pointer text-center border-2 border-dashed border border-gray-200 rounded-lg focus-within:outline-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2">
                        <input id="af-submit-app-upload-images" name="productImage" type="file" class="sr-only">
                        <svg class="size-10 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z"/>
                          <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                        </svg>
                        <span class="mt-2 block text-sm text-gray-800">
                          Browse your device <span class="group-hover:text-blue-700 text-blue-600">drag 'n drop'</span>
                        </span>
                        <span class="mt-1 block text-xs text-gray-500">
                          Maximum file size is 2 MB
                        </span>
                      </label>
                    </div>

                    <div class="space-y-2">
                      <label for="af-submit-app-category" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                        Product category
                      </label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px; margin-bottom: 10px;">
                        @foreach($categories as $category)
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" 
                                      name="categories[]" 
                                      value="{{ $category->id }}" 
                                      id="cat_{{ $category->id }}">
                                <label style="margin-top: 0;" for="cat_{{ $category->id }}">
                                    {{ $category->label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    </div>

                    <div class="space-y-2">
                      <label for="af-submit-app-description" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                        Product description
                      </label>

                      <textarea name="productDescription" id="af-submit-app-description" class="py-1.5 sm:py-2 px-3 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" rows="6" placeholder="Enter product description"></textarea>
                    </div>
                  </div>
                  <!-- End Grid -->

                  <div class="mt-5 flex justify-left gap-x-2">
                    <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                      Submit your product
                    </button>
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#hs-scroll-inside-body-modal">
                    Close
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
</div>

