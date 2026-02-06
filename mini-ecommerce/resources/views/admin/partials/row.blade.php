                <tbody id="product-table-body" 
                       class="divide-y divide-gray-200 bg-white transition-opacity duration-200"
                       :class="isLoading ? 'opacity-50 pointer-events-none' : ''">
                    <template x-for="product in products" :key="product.id">
                        <tr class="hover:bg-gray-50 transition" :id="'row-' + product.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <template x-if="product.image_url">
                                    <img :src="'/images/' + product.image_url" class="h-10 w-10 rounded-full object-cover" :alt="product.name">
                                </template>
                                <template x-if="!product.image_url">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <i data-lucide="image" class="w-5 h-5"></i>
                                    </div>
                                </template>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800" x-text="product.name"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                      x-text="new Number(product.price).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' $'">
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                <div class="flex flex-wrap gap-1">
                                    <template x-for="cat in (product.categories || [])" :key="cat.id">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800" x-text="cat.label"></span>
                                    </template>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" x-text="product.description || ''"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                <div class="flex justify-end gap-x-3">
                                    <button type="button" @click="editProduct(product)" class="text-indigo-500 hover:text-indigo-900 font-semibold">
                                        <i data-lucide="pencil" class="size-4"></i>
                                    </button>
                                    <button type="button" @click="confirmDelete(product.id)" class="text-red-500 hover:text-red-800 font-semibold">
                                        <i data-lucide="trash-2" class="size-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template x-if="products.length === 0 && !isLoading">
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                {{ __('views.no_products_found') ?? 'No products found.' }}
                            </td>
                        </tr>
                    </template>
                </tbody>