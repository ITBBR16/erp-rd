@foreach ($dataCase as $case)
    @if ($case->estimasi && $case->estimasi->estimasiPart->contains(function($item) {
        return !empty($item->tanggal_dikirim) && empty($item->tanggal_diterima);
    }))
        <div id="penerimaan-part-estimasi-{{ $case->id }}" tabindex="-1" class="modal fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-5xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    {{-- Header Modal --}}
                    <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Penerimaan Sparepart {{ $case->customer->first_name }} {{ $case->customer->last_name }} - {{ $case->customer->id }}
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="penerimaan-part-estimasi-{{ $case->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    {{-- Body Modal --}}
                    <form action="{{ route('penerimaan-sparepart-estimasi.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="px-6 py-6 lg:px-8">
                            <div class="relative">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                        <tr>
                                            <th scope="col" class="p-4">
                                                <div class="flex items-center">
                                                    <input id="checkbox-all-penerimaan-{{ $case->id }}" data-id="{{ $case->id }}" type="checkbox" class="check-all-penerimaan-req-part w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="checkbox-all-penerimaan-{{ $case->id }}" class="sr-only">checkbox all</label>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Jenis Drone 
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Part
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                ID Item
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Tanggal Dikirim
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="container-data-penerimaan-req-part-{{ $case->id }}">
                                        @foreach ($case->estimasi->estimasiPart as $epart)
                                            @if ($epart->active == 'Active' && $epart->tanggal_diterima == '' && $epart->id_item != '')
                                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                                    <td class="p-4">
                                                        <div class="flex items-center">
                                                            <input type="checkbox" name="checkbox_select_penerimaan[]" data-id="{{ $case->id }}" id="checkbox-penerimaan-part-estimasi-{{ $case->id }}-{{ $epart->id }}" value="{{ $epart->id }}" class="check-data-penerimaan w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" value="">
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-2">
                                                        {{ $epart->sparepartGudang->produkSparepart->produkJenis->jenis_produk }}
                                                    </td>
                                                    <td class="px-6 py-2">
                                                        {{ $epart->sparepartGudang->produkSparepart->nama_internal }}
                                                    </td>
                                                    <td class="px-6 py-2">
                                                        @php
                                                            if ($epart->partIdITem->produk_asal === 'Belanja') {
                                                                $nama = 'N' . $epart->partIdITem->gudang_belanja_id . '.' . $epart->partIdITem->gudangBelanja->gudang_supplier_id . '.' . $epart->partIdITem->id;
                                                            } elseif ($epart->partIdITem->produk_asal == 'Split') {
                                                                $nama = 'P' . $epart->partIdITem->gudang_belanja_id . '.' . $epart->partIdITem->gudangBelanja->gudang_supplier_id . '.' . $epart->partIdITem->id;
                                                            } else {
                                                                $nama = 'E' . $epart->partIdITem->gudang_belanja_id . '.' . $epart->partIdITem->gudangBelanja->gudang_supplier_id . '.' . $epart->partIdITem->id;
                                                            }
                                                        @endphp
                                                        {{ $nama ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-2">
                                                        {{ $epart->tanggal_dikirim ?? 'Belum Dikirim' }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Footer Modal --}}
                        <div class="flex justify-end p-3 border-t border-gray-200 rounded-t dark:border-gray-600">
                            <button type="submit" id="button-penerimaan-req-part-{{ $case->id }}" class="submit-button-form cursor-not-allowed text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" disabled>Submit</button>
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
        </div>
    @endif
@endforeach
