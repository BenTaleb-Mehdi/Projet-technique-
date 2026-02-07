<div class="flex justify-between">
  <div class="max-w-sm">
  <!-- SearchBox -->

    <div class="relative max-w-500">
      <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
        <svg class="shrink-0 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <path d="m21 21-4.3-4.3"></path>
        </svg>
      </div>
      <input class="py-2.5 py-3 ps-10 w-full pe-4 block border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="searchInput" type="text" role="combobox" aria-expanded="false" placeholder="" value="" data-hs-combo-box-input="" data-url="<?php echo e(route('admin.partials.index')); ?>">
    </div>


  <!-- End SearchBox -->
</div>
<button type="button" class="py-3 mb-5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-scroll-inside-body-modal" data-hs-overlay="#hs-scroll-inside-body-modal">
  add new product
</button>
</div>

<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="border border-gray-200 rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">name product</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">price product</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">category</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">description</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200" id="productBody">
            
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?php echo e($product->name); ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo e(number_format($product->price, 2)); ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                <?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span style="background: #eee; padding: 2px 5px; border-radius: 3px; font-size: 12px;">
                        <?php echo e($category->label); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?php echo e($product->description); ?></td>
            

            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div><?php /**PATH C:\GitHub\Projet technique\Projet-technique-\prototype_livecoding\resources\views/admin/partials/index.blade.php ENDPATH**/ ?>