<x-layout>
    <div class="h-full">
        <div class="flex justify-between">
            <h1 class="text-xl mb-4">Your 5 Kanye Quotes</h1>
            <button id="refresh_quotes" class="bg-green-700 px-6">Refresh Source</button>
            <button id="next_quotes" class="bg-blue-700 px-6">Next</button>
        </div>

        <div id="loading_spinner">
            <svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        
        <div id="quotes_list" class="mt-4 flex flex-col gap-4"></div>
        <x-quote />
    </div>
</x-layout>