<x-guest-layout title="Error: Oops! Something went wrong.">
    <div class="py-12 bg-red-900/10 dark:bg-red-800 rounded-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg text-center space-y-2">
                <h2 class="font-semibold text-xl text-red-800 dark:text-red-200 leading-tight">
                    {{ __('Error: Oops! Something went wrong.') }}
                </h2>
                <div class="text-gray-900 dark:text-gray-100">
                    {{ $exception->getMessage() }}
                </div>
                <a href="mailto:support@menuempire.com" class="mt-10 block">
                    <x-primary-button>Email Us</x-primary-button>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
