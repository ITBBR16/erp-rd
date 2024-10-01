<div class="hidden p-4" id="hasil-recap" role="tabpanel" aria-labelledby="hasil-recap-tab">
    <div class="grid grid-cols-3 gap-3">
        <div class="relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Merge Nota & Mutasi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Catatam
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataMutasi as $mutasi)
                        @foreach ($mutasi->mergeMutasiTransaksiRepair as $item)
                            <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <td class="px-6 py-2">
                                    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                        <li>
                                            
                                        </li>
                                    </ul>
                                </td>
                                <td class="px-6 py-2">
                                    
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-span-2 border rounded-md shadow-md p-3">
            <form action="{{ route('mergeMutasiTransaksi') }}" method="POST" autocomplete="off">
                @csrf
                <h3 class="pb-2 border-b-2 font-semibold">Form Pencocokan Mutasi dan Transaksi</h3>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    {{-- Form Mutasi --}}
                    <div class="space-y-4">
                        <div id="container-pencocokan-mutasi">
                            <div id="form-pencocokan-mutasi" class="grid grid-cols-3 gap-4" style="grid-template-columns: 5fr 5fr 1fr">
                                <div>
                                    <label for="pilih-mutasi-0" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Mutasi :</label>
                                    <select name="data_mutasi[]" id="pilih-mutasi-0" data-id="0" class="select-mutasi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih Mutasi</option>
                                        @foreach ($dataMutasiSementara as $mutasiSementara)
                                            @if ($mutasiSementara->status == 'Unprocess')
                                                <option value="{{ $mutasiSementara->id }}">M-{{ $mutasiSementara->id }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="nominal-mutasi-0" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal :</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                        <input name="nominal_mutasi[]" id="nominal-mutasi-0" type="text" class="nominal_mutasi rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly>
                                    </div>
                                </div>
                                {{-- <div class="flex justify-center items-end pb-2">
                                    <button type="button" class="remove-form-prtr" data-id="">
                                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-rose-600">
                            <div class="flex cursor-pointer mt-2 hover:text-red-400">
                                <button id="add-form-ptm" type="button" class="flex flex-row justify-between gap-2">
                                    <span class="material-symbols-outlined">add_circle</span>
                                    <span class="">Tambah Mutasi Baru</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- Form Transaksi --}}
                    <div class="space-y-4 border-l-2 pl-3">
                        <div id="container-pencocokan-transaksi">
                            <div id="form-pencocokan-transaksi" class="grid grid-cols-3 gap-4" style="grid-template-columns: 5fr 5fr 1fr">
                                <div>
                                    <label for="pilih-transaksi-0" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Transaksi :</label>
                                    <select name="data_transaksi[]" id="pilih-transaksi-0" data-id="0" class="select-transaksi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih Transaksi</option>
                                        @foreach ($dataTransaksi as $transaksi)
                                            <option value="{{ $transaksi->transaksi_id }}">{{ $transaksi->transaksi_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="nominal-transaksi-0" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal :</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                        <input name="nominal_transaksi[]" id="nominal-transaksi-0" type="text" class="nominal_transaksi rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly>
                                    </div>
                                </div>
                                {{-- <div class="flex justify-center items-end pb-2">
                                    <button type="button" class="remove-form-prtt" data-id="">
                                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-rose-600">
                            <div class="flex cursor-pointer mt-2 hover:text-red-400">
                                <button id="add-form-ptt" type="button" class="flex flex-row justify-between gap-2">
                                    <span class="material-symbols-outlined">add_circle</span>
                                    <span class="">Tambah Transaksi Baru</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan : </label>
                    <textarea name="catatan_pencocokan" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Catatan . . ."></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" id="button-pencocokan" class="submit-button-form cursor-not-allowed text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" disabled>Submit</button>
                    <div class="loader-button-form" style="display: none">
                        <button class="cursor-not-allowed text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            Loading . . .
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        let mutasiSementara = @json($dataMutasiSementara);
        let allTransaksi = @json($dataTransaksi);
    </script>
</div>