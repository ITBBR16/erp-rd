@extends('kios.layouts.main')

@section('container')
    <div class="relative overflow-x-auto">
        <div class="flex items-center justify-between py-4 border-b-2">
            <div class="flex text-xl">
                <span class="text-gray-700 font-semibold dark:text-gray-300">Download File CSV Daily Recap</span>
            </div>
        </div>
    </div>

    <form id="export-form-daily-recap" action="{{ route('export-daily-recap') }}" method="GET" autocomplete="off">
        <div class="flex flex-row space-x-4 mt-4">
            <div class="flex flex-col items-center space-x-4">
                <label for="start_date" class="text-black dark:text-gray-300">Tanggal Awal :</label>
                <div id="start-datepicker" inline-datepicker></div>
                <input type="hidden" name="start_date" id="start-date" readonly class="border rounded p-2 mt-1 mb-4" required/>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-black dark:text-gray-300">To</span>
            </div>
            <div class="flex flex-col items-center space-x-4">
                <label for="end_date" class="text-black dark:text-gray-300">Tanggal Akhir :</label>
                <div id="end-datepicker" inline-datepicker></div>
                <input type="hidden" name="end_date" id="end-date" readonly class="border rounded p-2 mt-1" required/>
            </div>

            <button 
                type="submit"
                class="self-start ml-4 text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">
                Download CSV
            </button>
        </div>
    </form>
@endsection
