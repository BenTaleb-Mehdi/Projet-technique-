<div class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-y-auto" 
     x-show="isDeleteModalOpen"
     x-cloak>
  
  <!-- Backdrop -->
  <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" 
       x-show="isDeleteModalOpen"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       @click="isDeleteModalOpen = false"></div>

  <!-- Modal Card -->
  <div class="relative bg-white border border-gray-200 shadow-xl rounded-xl overflow-hidden max-w-md w-full z-10 p-6 text-center"
       x-show="isDeleteModalOpen"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0 scale-95"
       x-transition:enter-end="opacity-100 scale-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100 scale-100"
       x-transition:leave-end="opacity-0 scale-95">
       
       <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
           <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
       </div>

       <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('actions.confirm_delete') }}</h3>
       <p class="text-sm text-gray-500 mb-6">
           {{ __('views.delete_warning_message') ?? 'Are you sure you want to delete this product? This action cannot be undone.' }}
       </p>

       <div class="flex justify-center gap-3">
           <button type="button" 
                   @click="isDeleteModalOpen = false"
                   class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 transition-all">
               {{ __('actions.cancel') }}
           </button>
           <button type="button" 
                    @click="deleteProduct()"
                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 transition-all shadow-sm">
                {{ __('actions.delete') }}
            </button>
       </div>
    </div>
</div>