<x-filament-panels::page>
    <div class="flex flex-col gap-4 w-full">
        @livewire(\App\Filament\Widgets\DeviceStat::class)
        @livewire(\App\Filament\Widgets\LatestTelemetryTable::class)
    </div>
</x-filament-panels::page>