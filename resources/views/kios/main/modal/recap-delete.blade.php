@foreach ($dailyRecap as $dr)
    <div id="recap-delete{{ $dr->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="flex flex-col p-8 bg-white shadow-md hover:shodow-lg rounded-2xl dark:bg-gray-800">
                <form action="{{ route('daily-recap.destroy', $dr->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="keperluan_id" value="{{ $dr->keperluan->nama }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-16 h-16 rounded-2xl p-3 border border-blue-100 text-blue-400 bg-blue-50 dark:border-gray-400 dark:bg-gray-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex flex-col ml-3">
                                <div class="font-medium leading-none dark:text-gray-100">Hapus Data {{ $dr->customer->first_name }} {{ $dr->customer->last_name }} ?</div>
                                <p class="text-sm text-gray-600 leading-none mt-1 dark:text-gray-500">Data Recap Akan Dihapus Permanent</p>
                            </div>
                            <button type="submit" class="flex-no-shrink bg-red-500 px-5 ml-4 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 text-white rounded-full" data-modal-hide="recap-delete">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach