@extends('gudang.layouts.main')

@section('container')
    {{-- Header Add SKU --}}
    <div class="flex flex-row justify-between items-center border-b border-gray-400 py-3">
        <div class="flex flex-col my-2 w-2/3">
            <div class="flex flex-row">
                <a href="/gudang/inventory" class="w-5 mr-3">
                    <span class="material-symbols-outlined text-red-500">arrow_back</span>
                </a>
                <div class="font-semibold mr-4 text-xl text-gray-700 dark:text-gray-300">Input SKU Baru</div>
            </div>
        </div>
    </div>
    {{--  --}}
    <div class="relative overflow-x-auto my-4">
        <div class="flex items-center justify-between py-4">
            <div class="flex text-xl">
                <span class="text-gray-700 font-semibold dark:text-gray-300">Table Input SKU</span>
            </div>
            <div class="relative text-lg">
                <button type="button" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Submit</button>
            </div>
        </div>
    </div>
    {{-- Table Input SKU --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-2">Seri</th>
                    <th scope="col" class="px-4 py-2">RD Name</th>
                    <th scope="col" class="px-4 py-2">Need SN</th>
                    <th scope="col" class="px-4 py-2">SKU DJI</th>
                    <th scope="col" class="px-4 py-2">DJI Name</th>
                    <th scope="col" class="px-4 py-2">Product Type</th>
                    <th scope="col" class="px-4 py-2">Status</th>
                    <th scope="col" class="px-4 py-2">Kategori</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">MAVIC MINI</option>
                            <option value="">MINI SE</option>
                            <option value="">MAVIC AIR 2S</option>
                            <option value="">ACCESSORIES</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">YES</option>
                            <option value="">No</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">DR</option>
                            <option value="">HH</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">1</option>
                            <option value="">5</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">GBL</option>
                            <option value="">BRD</option>
                            <option value="">BDY</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">MAVIC MINI</option>
                            <option value="">MINI SE</option>
                            <option value="">MAVIC AIR 2S</option>
                            <option value="">ACCESSORIES</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">YES</option>
                            <option value="">No</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">DR</option>
                            <option value="">HH</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">1</option>
                            <option value="">5</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">GBL</option>
                            <option value="">BRD</option>
                            <option value="">BDY</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">MAVIC MINI</option>
                            <option value="">MINI SE</option>
                            <option value="">MAVIC AIR 2S</option>
                            <option value="">ACCESSORIES</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">YES</option>
                            <option value="">No</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">DR</option>
                            <option value="">HH</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">1</option>
                            <option value="">5</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">GBL</option>
                            <option value="">BRD</option>
                            <option value="">BDY</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">MAVIC MINI</option>
                            <option value="">MINI SE</option>
                            <option value="">MAVIC AIR 2S</option>
                            <option value="">ACCESSORIES</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">YES</option>
                            <option value="">No</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">DR</option>
                            <option value="">HH</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">1</option>
                            <option value="">5</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">GBL</option>
                            <option value="">BRD</option>
                            <option value="">BDY</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">MAVIC MINI</option>
                            <option value="">MINI SE</option>
                            <option value="">MAVIC AIR 2S</option>
                            <option value="">ACCESSORIES</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">YES</option>
                            <option value="">No</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200" required>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">DR</option>
                            <option value="">HH</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">1</option>
                            <option value="">5</option>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <select class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                            <option hidden></option>
                            <option value="">GBL</option>
                            <option value="">BRD</option>
                            <option value="">BDY</option>
                            <option value="">ACC</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection