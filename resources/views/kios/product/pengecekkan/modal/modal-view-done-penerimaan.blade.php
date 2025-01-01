@foreach ($historyPenerimaan as $history)
    @if ($history->pengiriman->status == 'Diterima' || $history->pengiriman->status == 'InRD')
        <div id="view-done-penerimaan-{{ $history->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-lg max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-5 border-b rounded-t bg-white dark:bg-gray-700">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail Resi : {{ $history->pengiriman->no_resi }}</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="view-done-penerimaan-{{ $history->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="px-6 py-6 lg:px-8">
                        <div class="grid md:grid-cols-2 md:gap-6 pt">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text"id="ekspedisi{{ $history->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $history->pengiriman->ekspedisi->ekspedisi }}" disabled>
                                <label for="ekspedisi{{ $history->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Ekspedisi</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <span class="absolute start-0 bottom-3 text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </span>
                                <input type="text" id="tanggal_diterima{{ $history->id }}" class="block py-2.5 ps-6 pe-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ \Carbon\Carbon::parse($history->tanggal_diterima)->isoFormat('D MMMM YYYY') }}" disabled>
                                <label for="tanggal_diterima{{ $history->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-6 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Tanggal Diterima</label>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6 pt">
                            <div class="relative z-0 w-full group">
                                <input type="number" name="total_paket{{ $history->id }}" id="total_paket" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $history->total_paket }}" disabled>
                                <label for="total_paket{{ $history->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total Paket</label>
                            </div>
                            <div class="relative z-0 w-full group">
                                <input type="text" name="kondisi_paket{{ $history->id }}" id="kondisi_paket" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $history->kondisi_barang }}" disabled>
                                <label for="kondisi_paket{{ $history->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kondisi Paket</label>
                            </div>
                        </div>
                        <h3 class="mt-6 text-gray-900 dark:text-white font-semibold text-xl">Data File</h3>
                        <div class="mt-3 grid grid-cols-2 gap-4 md:gap-6">
                            <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">File Resi :</label>
                            <div class="flex items-center justify-center w-full max-w-md">
                                @php
                                    $imageLink = $history->link_img_resi ?? "";
                                    preg_match('/\/file\/d\/(.*?)\/view/', $imageLink, $matches);
                                    $fileId = isset($matches[1]) ? $matches[1] : null;
                                @endphp
                                @if (!empty($imageLink))
                                    <img src="https://drive.google.com/thumbnail?id={{ $fileId }}" class="w-32" alt="File Paket" loading="lazy">
                                @endif
                            </div>
                        </div>
                        <div class="mt-3 grid grid-cols-2 gap-4 md:gap-6">
                            <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">File Barang Datang :</label>
                            <div class="flex items-center justify-center w-full max-w-md">
                                @php
                                    $imageLink = $history->link_img_paket ?? "";
                                    preg_match('/\/file\/d\/(.*?)\/view/', $imageLink, $matches);
                                    $fileId = isset($matches[1]) ? $matches[1] : null;
                                @endphp
                                @if (!empty($imageLink))
                                    <img src="https://drive.google.com/thumbnail?id={{ $fileId }}" class="w-32" alt="File Paket" loading="lazy">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach