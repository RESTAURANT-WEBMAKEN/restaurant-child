<x-filament-panels::page>

    {{ $this->checkForUpdatesInfolist }}
    
    <div class="overflow-x-auto">
        <pre class="max-w-full">{!! $this->change_log() !!}</pre><br>
    </div>

</x-filament-panels::page>
