    <div class="bg-white border-x border-b border-gray-200 shadow-sm rounded-b-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('models.image') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('models.designation') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('models.price') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('models.category') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('views.actions') }}</th>
                    </tr>
                </thead>
                @include('admin.partials.row')
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end" 
             x-show="paginationHtml" 
             x-html="paginationHtml"
             @click.prevent="const link = $event.target.closest('a'); if(link) changePage(link.href)">
        </div>
    </div>