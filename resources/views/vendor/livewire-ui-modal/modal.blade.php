<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset

    <div
        x-data="LivewireUIModal()"
        x-init="init()"
        x-on:close.stop="setShowPropertyTo(false)"
        x-on:keydown.escape.window="closeModalOnEscape()"
        x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
        x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
        x-show="show"
        class="position-fixed inset-0 z-10 overflow-y-auto w-100 overflow-auto h-100"
        style="display: none;top:0;z-index: 1000;"
    >
        <div class="d-flex justify-content-center min-h-screen align-items-center vh-100 sm:block sm:p-0">
            <div
                x-show="show"
                x-on:click="closeModalOnClickAway()"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="position-fixed w-100 h-100 inset-0 transition-all transform"
            >
                <div class="w-100 h-100 inset-0" style="background: rgba(0, 0, 0, 0.6)"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                x-show="show && showActiveComponent"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-bind:class="modalWidth"
                class="p-3 inline-block w-full align-middle  rounded text-left transform transition-all bg-white position-absolute"
                id="modal-container"
                style="width: 100%; max-width: 500px; "
            >
                <div class="d-flex justify-content-end">
                    <button
                        x-on:click="closeModal()"
                        class="btn btn-close"></button>
                </div>
                @forelse($components as $id => $component)
                    <div class="scrollbar-orange overflow-auto " style="max-height: 80vh" x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}" wire:key="{{ $id }}">
                        @livewire($component['name'], $component['attributes'], key($id))
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>
