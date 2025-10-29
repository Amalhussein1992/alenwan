<x-filament-panels::page>
    @php
        $data = $this->getAnalyticsData();
    @endphp

    <div class="grid gap-6">
        {{-- Header Widgets --}}
        <x-filament-widgets::widgets
            :widgets="$this->getHeaderWidgets()"
            :columns="$this->getHeaderWidgetsColumns()"
        />

        {{-- Content Statistics --}}
        <div class="rounded-lg bg-white shadow dark:bg-gray-800">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ __('filament.analytics.content_statistics') }}
                </h3>

                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-lg bg-blue-50 p-4 dark:bg-blue-900/20">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('filament.analytics.total_movies') }}</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($data['content']['total_movies']) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-green-50 p-4 dark:bg-green-900/20">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('filament.analytics.total_series') }}</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($data['content']['total_series']) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-purple-50 p-4 dark:bg-purple-900/20">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('filament.analytics.total_episodes') }}</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($data['content']['total_episodes']) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-yellow-50 p-4 dark:bg-yellow-900/20">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('filament.fields.is_premium') }}</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($data['content']['premium_content']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Popular Content --}}
        <div class="grid gap-6 lg:grid-cols-2">
            {{-- Popular Movies --}}
            <div class="rounded-lg bg-white shadow dark:bg-gray-800">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('filament.analytics.most_viewed') }} - {{ __('filament.resources.movies.plural_label') }}
                    </h3>

                    <div class="mt-4 space-y-3">
                        @forelse($data['popular_movies'] as $movie)
                            <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    @if($movie->poster)
                                        <img src="{{ Storage::url($movie->poster) }}" alt="{{ $movie->title }}" class="h-12 w-12 rounded object-cover">
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded bg-gray-200 dark:bg-gray-600">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $movie->title }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($movie->views_count) }} {{ __('filament.fields.views_count') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('filament.messages.no_records') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Popular Series --}}
            <div class="rounded-lg bg-white shadow dark:bg-gray-800">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('filament.analytics.most_viewed') }} - {{ __('filament.resources.series.plural_label') }}
                    </h3>

                    <div class="mt-4 space-y-3">
                        @forelse($data['popular_series'] as $series)
                            <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    @if($series->poster)
                                        <img src="{{ Storage::url($series->poster) }}" alt="{{ $series->title }}" class="h-12 w-12 rounded object-cover">
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded bg-gray-200 dark:bg-gray-600">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $series->title }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($series->views_count) }} {{ __('filament.fields.views_count') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('filament.messages.no_records') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Categories --}}
        <div class="rounded-lg bg-white shadow dark:bg-gray-800">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ __('filament.analytics.top_categories') }}
                </h3>

                <div class="mt-4 space-y-3">
                    @forelse($data['categories'] as $category)
                        <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $category->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $category->movies_count }} {{ __('filament.resources.movies.plural_label') }},
                                    {{ $category->series_count }} {{ __('filament.resources.series.plural_label') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($category->movies_count + $category->series_count) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('filament.messages.no_records') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
