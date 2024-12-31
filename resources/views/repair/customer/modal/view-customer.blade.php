@foreach ($dataCustomer as $customer)
    <div id="view-customer{{ $customer->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail {{ $customer->first_name }} {{ $customer->last_name }}</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="view-customer{{ $customer->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="dark:text-white">
                            <div class="grid grid-cols-4 gap-4 md:gap-6 mb-4">
                                <div class="col-span-1">
                                    <h3 class="text-black dark:text-white">First Name</h3>
                                </div>
                                <div class="col-span-1">
                                    :
                                </div>
                                <div class="col-span-2">
                                    <h3 class="text-black dark:text-white">{{ $customer->first_name }}</h3>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-4 md:gap-6 mb-4">
                                <div class="col-span-1">
                                    <h3 class="text-black dark:text-white">Last Name</h3>
                                </div>
                                <div class="col-span-1">
                                    :
                                </div>
                                <div class="col-span-2">
                                    <h3 class="text-black dark:text-white">{{ $customer->last_name }}</h3>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-4 md:gap-6 mb-4">
                                <div class="col-span-1">
                                    <h3 class="text-black dark:text-white">No Telpon</h3>
                                </div>
                                <div class="col-span-1">
                                    :
                                </div>
                                <div class="col-span-2">
                                    <h3 class="text-black dark:text-white">{{ $customer->no_telpon }}</h3>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-4 md:gap-6 mb-4">
                                <div class="col-span-1">
                                    <h3 class="text-black dark:text-white">Email</h3>
                                </div>
                                <div class="col-span-1">
                                    :
                                </div>
                                <div class="col-span-2">
                                    <h3 class="text-black dark:text-white">{{ $customer->email ?? '-' }}</h3>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-4 md:gap-6 mb-4">
                                <div class="col-span-1">
                                    <h3 class="text-black dark:text-white">Instansi</h3>
                                </div>
                                <div class="col-span-1">
                                    :
                                </div>
                                <div class="col-span-2">
                                    <h3 class="text-black dark:text-white">{{ ($customer->instansi) ?? '-' }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="border-l-2 border-gray-900 dark:border-gray-200 pl-2 dark:text-white">
                            <div class="grid grid-cols-2 gap-4 md:gap-6 mb-4">
                                <div>
                                    <h3 class="text-black dark:text-white">Provinsi :</h3>
                                </div>
                                <div>
                                    <h3 class="text-black dark:text-white">{{ $customer->provinsi->name ?? '-' }}</h3>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 md:gap-6 mb-4">
                                <div>
                                    <h3 class="text-black dark:text-white">Kota / Kabupaten :</h3>
                                </div>
                                <div>
                                    <h3 class="text-black dark:text-white">{{ $customer->kota->name ?? '-' }}</h3>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 md:gap-6 mb-4">
                                <div>
                                    <h3 class="text-black dark:text-white">Kecamatan :</h3>
                                </div>
                                <div>
                                    <h3 class="text-black dark:text-white">{{ $customer->kecamatan->name ?? '-' }}</h3>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 md:gap-6 mb-4">
                                <div>
                                    <h3 class="text-black dark:text-white">Kelurahan :</h3>
                                </div>
                                <div>
                                    <h3 class="text-black dark:text-white">{{ $customer->kelurahan->name ?? '-' }}</h3>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 md:gap-6 mb-4">
                                <div>
                                    <h3 class="text-black dark:text-white">Kode Pos :</h3>
                                </div>
                                <div>
                                    <h3 class="text-black dark:text-white">{{ $customer->kode_pos ?? '-' }}</h3>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 md:gap-6 mb-4">
                                <div>
                                    <h3 class="text-black dark:text-white">Nama Jalan :</h3>
                                </div>
                                <div>
                                    <h3 class="text-black dark:text-white">{{ $customer->nama_jalan ?? '-' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
