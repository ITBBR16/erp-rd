<div id="disabled-part" tabindex="-1" class="modal fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            {{-- Header Modal --}}
            <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Info
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="disabled-part">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            {{-- Body Modal --}}
            <div class="px-6 py-6 lg:px-8">
                <div class="flex items-center justify-center">
                    <figure class="max-w-lg">
                        <img class="h-auto max-w-full rounded-lg ml-12" src="/img/maintainance.png" alt="Not Found" width="250" height="150">
                        <figcaption class="mt-2 text-lg font-bold text-gray-900 dark:text-white">Mohon maaf masih ada perbaikan.</figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>