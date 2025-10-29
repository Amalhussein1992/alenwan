@php
    $currentLocale = app()->getLocale();
@endphp

<div class="flex items-center gap-2">
    <x-filament::dropdown placement="bottom-end">
        <x-slot name="trigger">
            <button
                type="button"
                class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-800"
            >
                <span class="text-xl">
                    {{ $currentLocale === 'ar' ? '🇸🇦' : '🇬🇧' }}
                </span>
                <span class="hidden sm:inline">
                    {{ $currentLocale === 'ar' ? 'العربية' : 'English' }}
                </span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </x-slot>

        <x-filament::dropdown.list>
            <form method="POST" action="{{ route('filament.admin.switch-language') }}">
                @csrf
                <input type="hidden" name="locale" value="ar">
                <button
                    type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800 {{ $currentLocale === 'ar' ? 'bg-gray-50 dark:bg-gray-900' : '' }}"
                >
                    <span class="text-xl">🇸🇦</span>
                    <span>العربية</span>
                    @if($currentLocale === 'ar')
                        <svg class="w-4 h-4 ms-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </button>
            </form>

            <form method="POST" action="{{ route('filament.admin.switch-language') }}">
                @csrf
                <input type="hidden" name="locale" value="en">
                <button
                    type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800 {{ $currentLocale === 'en' ? 'bg-gray-50 dark:bg-gray-900' : '' }}"
                >
                    <span class="text-xl">🇬🇧</span>
                    <span>English</span>
                    @if($currentLocale === 'en')
                        <svg class="w-4 h-4 ms-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </button>
            </form>
        </x-filament::dropdown.list>
    </x-filament::dropdown>
</div>
