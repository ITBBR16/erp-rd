@foreach ($produks as $produk)
    <div id="delete-produk{{ $produk->id }}" tabindex="-1" class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[cal(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="flex flex-col p-8 bg-white shadow-md hover:shodow-lg rounded-2xl dark:bg-gray-800">
                <form action="{{ route('product.destroy', $produk->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-16 h-16 rounded-2xl p-3 border border-blue-100 text-blue-400 bg-blue-50 dark:border-gray-400 dark:bg-gray-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex flex-col ml-3">
                                <div class="font-medium leading-none dark:text-gray-100">Hapus Data {{ $produk->subjenis->produkjenis->jenis_produk }} {{ $produk->subjenis->paket_penjualan }} ?</div>
                                <p class="text-sm text-gray-600 leading-none mt-1 dark:text-gray-500">Data Produk Akan Dihapus Permanent</p>
                            </div>
                            <button type="submit" class="flex-no-shrink bg-red-500 px-5 ml-4 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 text-white rounded-full" data-modal-hide="delete-produk{{ $produk->id }}">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach