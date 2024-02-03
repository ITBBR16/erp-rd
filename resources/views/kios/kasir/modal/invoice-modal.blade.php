<div id="kasir-invoice" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-fit max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="bg-gray-50 dark:bg-slate-900">
                <div class="px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
                    <div class="mx-auto">
                        {{-- Body --}}
                        <div id="print-invoice" class="text-xs flex flex-col p-4 sm:p-10 bg-white shadow-md rounded-xl dark:bg-gray-800">
                            <div style="max-width: 210mm;">
                                <div class="flex justify-between">
                                    <div class="w-60">
                                        <img src="/img/Logo Rumah Drone Black.png" alt="Logo Rumah Drone Black.png">
                                    </div>
                                    <div class="text-end">
                                        <h2 class="text-xl md:text-2xl font-semibold text-gray-800 dark:text-gray-200">Invoice #</h2>
                                        <address class="mt-2 not-italic text-gray-800 dark:text-gray-200">
                                            PT. Odo Multi Aero<br>
                                            Jl. Kwoka Q2 No.6, Kota Malang<br>
                                            Telp./Whatsapp 082232377753	<br>
                                          </address>
                                    </div>
                                </div>
                                <div class="mt-3 grid sm:grid-cols-2 gap-3">
                                    <div>
                                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                                            <dl class="grid grid-cols-3">
                                                <dt class="col-span-1 font-semibold text-gray-800 dark:text-gray-200">Nama:</dt>
                                                <dd id="invoice-nama-customer" class="col-span-2 text-gray-500"></dd>
                                            </dl>
                                            <dl class="-mt-1 grid grid-cols-3">
                                                <dt class="col-span-1 font-semibold text-gray-800 dark:text-gray-200">No Tlp:</dt>
                                                <dd id="invoice-no-tlp" class="col-span-2 text-gray-500"></dd>
                                            </dl>
                                            <dl class="-mt-1 grid grid-cols-3">
                                                <dt class="col-span-1 font-semibold text-gray-800 dark:text-gray-200">Alamat:</dt>
                                                <dd id="invoice-jalan" class="col-span-2 text-gray-500"></dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                                <dt class="col-span-4 font-semibold text-gray-800 dark:text-gray-200">No Invoice :</dt>
                                                <dd class="col-span-1 text-gray-500">{{ $today->format('Ymd') }}{{ $invoiceid + 1 }}</dd>
                                            </dl>
                                            <dl class="-mt-1 grid sm:grid-cols-5 gap-x-3">
                                                <dt class="col-span-4 font-semibold text-gray-800 dark:text-gray-200">Due date:</dt>
                                                <dd class="col-span-1 text-gray-500">{{ $duedate->format('d/m/Y') }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative overflow-x-auto pt-4">
                                    <table class="border text-xs w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-900 border-b-2 uppercase dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-2 py-1" style="width: 30%;">
                                                    Product Name
                                                </th>
                                                <th scope="col" class="px-2 py-1" style="width: 30%;">
                                                    Description
                                                </th>
                                                <th scope="col" class="px-2 py-1" style="width: 10%;">
                                                    QTY
                                                </th>
                                                <th scope="col" class="px-2 py-1" style="width: 15%;">
                                                    Item Price
                                                </th>
                                                <th scope="col" class="px-2 py-1" style="width: 15%;">
                                                    Total Price
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="invoice-kasir-container">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="grid grid-cols-3 mt-4">
                                    <div class="col-span-2">
                                        <h4 class="text-xs font-semibold text-gray-800 dark:text-gray-200">PERHATIAN!</h4>
                                        <p class="text-xs text-gray-500">- Garansi berlaku setelah penerimaan barang</p>
                                        <p class="text-xs text-gray-500">- Garansi tidak berlaku akibat human error</p>
                                        <p class="text-xs text-gray-500">- Garansi tidak berlaku apabila barang pernah diperbaiki/dibongkar pemilik/pihak lain</p>
                                        <p class="text-xs text-gray-500">- Pembeli Wajib membawa nota dan kartu garansi pada saat klaim garansi</p>
                                        <p class="text-xs text-gray-500">- Pembayaran melalui Marketplace atau transfer rek BCA 4400175395 | Mandiri 1560012623593 a/n Farra Rachmanda</p>
                                    </div>
                                    <div class="flex sm:justify-end">
                                        <div class="text-sm w-full max-w-2xl sm:text-end space-y-2">
                                            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                                    <dt class="col-span-2 font-semibold text-gray-800 dark:text-gray-200">Subtotal:</dt>
                                                    <dd id="invoice-subtotal" class="col-span-3 text-gray-500"></dd>
                                                </dl>
                                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                                    <dt class="col-span-2 font-semibold text-gray-800 dark:text-gray-200">Discount:</dt>
                                                    <dd id="invoice-discount" class="col-span-3 text-gray-500"></dd>
                                                </dl>
                                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                                    <dt class="col-span-2 font-semibold text-gray-800 dark:text-gray-200">Tax:</dt>
                                                    <dd id="invoice-tax" class="col-span-3 text-gray-500"></dd>
                                                </dl>
                                                <dl class="grid sm:grid-cols-5 gap-x-3">
                                                    <dt class="col-span-2 font-semibold text-gray-800 dark:text-gray-200">Total:</dt>
                                                    <dd id="invoice-total" class="col-span-3 text-gray-500"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Body --}}
                        <div class="p-4 flex justify-end gap-x-3">
                            <button id="ddPrintButton" data-dropdown-toggle="ddPrint" data-dropdown-placement="bottom" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Action
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <button type="submit" form="kasir-form" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                        </div>
                        <div id="ddPrint" class="z-10 hidden bg-white rounded-lg shadow w-60 dark:bg-gray-700">
                            <ul class="h-24 py-2 overflow-y-auto text-gray-700 dark:text-gray-200" aria-labelledby="ddPrintButton">
                                <li>
                                    <button id="button-download-invoice" type="button" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                        <span class="pl-2">Download Invoice</span>
                                    </button>
                                </li>
                                <li>
                                    <button id="button-print-invoice" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                                        <span class="pl-2">Print Invoice</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
