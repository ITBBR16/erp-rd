<div id="recap-view{{ $recap->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Detail {{ $recap->customer->first_name }} {{ $recap->customer->last_name }} 
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">{{ $recap->status }}</span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="recap-view{{ $recap->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="px-6 py-6 lg:px-8">
                <div class="grid grid-cols-2 gap-6 mb-4">
                    <div class="grid-rows-2">
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">Nomor Telpon</h3>
                        <h3 class="text-base text-gray-900 dark:text-white">{{ $recap->customer->no_telpon }}</h3>
                    </div>
                    <div class="grid-rows-2">
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">Tanggal Dibuat</h3>
                        <h3 class="text-base text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($recap->created_at)->locale('id_ID')->isoFormat('D MMMM YYYY, HH:mm [WIB]') }}</h3>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-4 border-t-2">
                    <div class="grid-rows-2 mt-2">
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">Jenis Produk</h3>
                        <h3 class="text-base text-gray-900 dark:text-white"></h3>
                    </div>
                    <div class="grid-rows-2 mt-2">
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">Keperluan</h3>
                        <h3 class="text-base text-gray-900 dark:text-white">{{ $recap->keperluan->nama }}</h3>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-4">
                    <div class="grid-rows-2">
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">Kategori Permasalahan</h3>
                        <h3 class="text-base text-gray-900 dark:text-white"></h3>
                    </div>
                    <div class="grid-rows-2">
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">Permasalahan</h3>
                        <h3 class="text-base text-gray-900 dark:text-white"></h3>
                    </div>
                </div>
                <div class="grid-rows-2 mb-4">
                    <h3 class="text-base font-medium text-gray-900 dark:text-white">Link Permasalahan</h3>
                    {{-- @if ($recap->permasalahan->link_permasalahan != '-')
                        <a href="{{ $recap->permasalahan->link_permasalahan }}" class="text-base text-blue-500" target="__blank">{{ $recap->permasalahan->link_permasalahan }}</a>
                    @else
                        <h3 class="text-base text-gray-900 dark:text-white">-</h3>
                    @endif --}}
                </div>
                <div class="grid-rows-2">
                    <h3 class="text-base font-medium text-gray-900 dark:text-white">Deskripsi</h3>
                    <h3 class="text-base text-gray-900 dark:text-white"></h3>
                </div>
            </div>
        </div>
    </div>
</div>
