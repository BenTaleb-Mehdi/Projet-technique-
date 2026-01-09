@extends('layouts.admin')

@section('content')

<div class="flex flex-col w-full bg-white rounded-xl shadow-sm border border-gray-200">
  <div class="text-end p-5">
    <button type="button" 
            onclick="openCreateModal()"
            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" 
            aria-haspopup="dialog" 
            aria-expanded="false" 
            aria-controls="hs-danger-alert" 
            data-hs-overlay="#hs-danger-alert">
      Add Product
    </button>
  </div>
  
  <div class="-m-1.5 overflow-x-auto">
    
    <div class="p-1.5 min-w-full inline-block align-middle">
      
      <div class="overflow-hidden rounded-xl">

        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Image</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Product Name</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
              <th scope="col" class="px-6 py-3 text-end text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
          </thead>
          
          <tbody id="product-table-body" class="divide-y divide-gray-200">
            @foreach($products as $product)
                @include('admin.products.row', ['product' => $product])
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<div id="hs-danger-alert" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1" aria-labelledby="hs-danger-alert-label">
  
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
    
    <div class="relative flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl overflow-hidden">
       <div class="text-end p-5">
         <button type="button" class="py-2 px-3 max-w-[50px] inline-lex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50" data-hs-overlay="#hs-danger-alert">
          X
        </button>
       </div>
      <!-- Card Section -->
      <div class="w-full px-4 py-10 sm:px-6 lg:px-8  mx-auto">
        <form id="productForm">
          <input type="hidden" name="_method" id="methodField" value="POST">
          <input type="hidden" id="productId">

          <div class="bg-white rounded-xl shadow-xs">
            <div class="pt-0 p-4 sm:pt-0 sm:p-7">
              <div class="space-y-4 sm:space-y-6">
                <div class="space-y-2">
                  <label for="af-submit-app-project-name" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                    Product name
                  </label>

                  <input id="productName" type="text" name="name" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter product name">
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
                </div>
                <div class="space-y-2">
                  <label for="af-submit-app-price" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                    Price
                  </label>

                  <input id="productPrice" type="text" name="price" class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter price">
                </div>

                <div class="space-y-2">
                  <label class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                    Select Categories
                  </label>
                  <div class="grid grid-cols-2 gap-2 mt-2">
                    @foreach($categories as $category)
                    <div class="flex">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="cat-{{ $category->id }}">
                        <label for="cat-{{ $category->id }}" class="text-sm text-gray-500 ms-3">{{ $category->label }}</label>
                    </div>
                    @endforeach
                  </div>
                </div>

             

                <div class="space-y-2">
                  <label for="af-submit-app-description" class="inline-block text-sm font-medium text-gray-800 mt-2.5">
                    Description
                  </label>

                  <textarea id="productDescription" name="description" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" rows="6" placeholder="A detailed summary..."></textarea>
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

<script>
  let isEditing = false;
  let currentProductId = null;

  function openCreateModal() {
      isEditing = false;
      currentProductId = null;
      document.getElementById('productForm').reset();
      document.getElementById('methodField').value = 'POST';
      document.getElementById('submitBtn').innerText = 'Create Product';
      
      // Uncheck all checkboxes
      document.querySelectorAll('input[name="categories[]"]').forEach(cb => cb.checked = false);
  }

  function editProduct(product) {
      isEditing = true;
      currentProductId = product.id;
      
      document.getElementById('productForm').reset();
      document.getElementById('methodField').value = 'PUT'; // Laravel spoofing for PUT
      document.getElementById('submitBtn').innerText = 'Update Product';
      
      // Populate fields
      document.getElementById('productName').value = product.name;
      document.getElementById('productPrice').value = product.price;
      document.getElementById('productDescription').value = product.description;
      
      // Handle categories
      // Assuming product.categories is an array of objects
      const categoryIds = product.categories.map(c => c.id);
      document.querySelectorAll('input[name="categories[]"]').forEach(cb => {
          cb.checked = categoryIds.includes(parseInt(cb.value));
      });
  }

  document.addEventListener('DOMContentLoaded', () => {
    const productForm = document.querySelector('#productForm');
    const tableBody = document.querySelector('#product-table-body');

    productForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(productForm);

        let url = "{{ route('products.store') }}";
        if (isEditing && currentProductId) {
             url = `/admin/products/${currentProductId}`; // Assuming resource route convention or we can generate it differently if needed
             // NOTE: Since route() helper in JS is static, we construct the URL manually or Use a global js variable if strictly needed.
             // Manual construction /admin/products/{id} is standard.
             // Also note: FormData with PUT method in Laravel usually requires _method field (which we added) and standard POST request.
        }

        try {
            const response = await fetch(url, {
                method: "POST", // Always POST when using FormData (with _method=PUT for updates)
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'text/html' // Expect HTML fragment
                },
                body: formData
            });

            if (response.ok) {
                const htmlRow = await response.text();
                
                if (isEditing) {
                    // Replace existing row
                    const existingRow = document.getElementById(`row-${currentProductId}`);
                    if (existingRow) {
                        existingRow.outerHTML = htmlRow;
                    }
                } else {
                    // Prepend new row
                    tableBody.insertAdjacentHTML('afterbegin', htmlRow);
                }
                
                // Reset and Close
                productForm.reset();
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.close(document.querySelector('#hs-danger-alert'));
                }
            } else {
                console.error('Server returned:', response.status, response.statusText);
                alert("Error saving product.");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("An error occurred.");
        }
    });
});
</script>
@endsection
