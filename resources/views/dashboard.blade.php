<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ url('/telescope/') }}" class="bg-white border border-transparent focus:outline-none focus:underline font-medium hover:text-gray-800 leading-5 px-4 py-2 rounded-md text-gray-900 text-sm">{{ __('Access Telescope') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>