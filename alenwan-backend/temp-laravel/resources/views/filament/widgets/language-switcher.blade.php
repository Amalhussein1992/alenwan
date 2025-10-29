<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-center gap-4">
            @foreach($this->getAvailableLocales() as $code => $locale)
                <button
                    wire:click="switchLanguage('{{ $code }}')"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all
                        {{ $this->getCurrentLocale() === $code
                            ? 'bg-primary-500 text-white shadow-lg'
                            : 'bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700'
                        }}"
                >
                    <span class="text-2xl">{{ $locale['flag'] }}</span>
                    <span class="font-medium">{{ $locale['name'] }}</span>
                </button>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
