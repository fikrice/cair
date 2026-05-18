@if ($paginator->hasPages())
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <!-- Show Entries Info -->
        <div class="order-2 sm:order-1">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-400">
                Showing 
                <span class="text-gray-900 dark:text-white">{{ $paginator->firstItem() }}</span> 
                to 
                <span class="text-gray-900 dark:text-white">{{ $paginator->lastItem() }}</span> 
                of 
                <span class="text-gray-900 dark:text-white">{{ $paginator->total() }}</span> 
                entries
            </p>
        </div>

        <!-- Pagination Buttons (TailAdmin Style 1 Exact) -->
        <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="order-1 sm:order-2">
            <ul class="flex items-center gap-2">
                {{-- Previous Page Link --}}
                <li>
                    @if ($paginator->onFirstPage())
                        <span class="flex h-9 items-center justify-center rounded-lg border border-gray-200 bg-white px-4 text-sm font-medium text-gray-500 dark:border-gray-800 dark:bg-transparent opacity-50 cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex h-9 items-center justify-center rounded-lg border border-gray-200 bg-white px-4 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:bg-white/[0.03]">
                            Previous
                        </a>
                    @endif
                </li>

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li>
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-500 dark:border-gray-800 dark:bg-transparent">
                                {{ $element }}
                            </span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-500 text-sm font-medium text-white shadow-theme-xs">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:bg-white/[0.03]">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                <li>
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex h-9 items-center justify-center rounded-lg border border-gray-200 bg-white px-4 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:bg-white/[0.03]">
                            Next
                        </a>
                    @else
                        <span class="flex h-9 items-center justify-center rounded-lg border border-gray-200 bg-white px-4 text-sm font-medium text-gray-500 dark:border-gray-800 dark:bg-transparent opacity-50 cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
@endif
