@extends('kios.layouts.main')

@section('container')
    <div class="relative overflow-x-auto">
        <div class="flex items-center justify-between py-4 border-b-2">
            <div class="flex text-xl">
                <span class="text-gray-700 font-semibold dark:text-gray-300">Recent Activity</span>
            </div>
        </div>
    </div>

    <div class="flex mt-6">
        <a href="{{ route('download.recap') }}" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Download CSV</a>
    </div>
@endsection
