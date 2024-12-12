@foreach ($suppliers as $item)
    <div id="edit-supplier{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Update {{ $item->first_name }} {{ $item->last_name }}</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-supplier{{ $item->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-6 py-6 lg:px-8">
                    <form action="{{ route('supplier-kios.update', $item->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="pic_name" id="pic_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('pic_name') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('pic_name', $item->pic_name) }}" required>
                                <label for="pic_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">PIC Name</label>
                                @error('pic_name')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama_perusahaan') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('nama_perusahaan', $item->nama_perusahaan) }}" required>
                                <label for="nama_perusahaan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Company Name</label>
                                @error('nama_perusahaan')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="npwp" id="npwp" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('npwp') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('npwp', $item->npwp) }}" required>
                                <label for="npwp" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">NPWP</label>
                                @error('npwp')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="no_telpon" id="no_telpon" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('no_telpon') border-red-600 dark:border-red-500 @enderror" pattern="[0-9]{12,}" placeholder="" value="{{ old('no_telpon', $item->no_telpon) }}" required>
                                <label for="no_telpon" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Telpon PIC</label>
                                @error('no_telpon')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="alamat_lengkap" id="alamat_lengkap" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('alamat_lengkap') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('alamat_lengkap', $item->alamat_lengkap) }}" required>
                            <label for="alamat_lengkap" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat Lengkap</label>
                            @error('alamat_lengkap')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <h3 class="my-3 font-semibold text-gray-900 dark:text-white">Kategori Supplier</h3>
                        <div class="w-full text-sm font-medium text-gray-900 border border-gray-200 dark:border-gray-600 dark:text-white">
                            <div class="flex flex-col">
                                @php $count = 0; @endphp
                                @foreach ($kategori as $ktg)
                                    @if ($count % 2 == 0)
                                        <div class="flex flex-row w-full">
                                    @endif
                                    <div class="ml-4 flex flex-row items-center w-1/2">
                                        @php
                                            $checked = $item->kategoris->contains('id', $ktg->id);
                                        @endphp
                                        <input {{ $checked ? 'checked' : '' }} type="checkbox" name="kategori[]" id="kategori{{ $ktg->id }}" value="{{ $ktg->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="kategori{{ $ktg->id }}" class="py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $ktg->nama }}</label>
                                    </div>
                                    @if ($count % 2 != 0 || $loop->last)
                                        </div>
                                    @endif
                                    @php $count++; @endphp
                                @endforeach
                            </div>
                        </div>
                        <div class="flex justify-end pt-4 items-center border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
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
    </div>
@endforeach
