<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DeviceStat extends BaseWidget
{

    protected function getStats(): array
    {
        return Device::all()
            ->transform(function (Device $device) {
                return (new Stat(
                    $device->name,
                    $device->telemetries()->where('key', 'moisture')->latest('created_at')->first()?->value ?? 0,
                ))
                    ->description('Kelembaban tanah')
                    ->chart(
                        $device->telemetries()
                            ->whereDate('created_at', now()->format('Y-m-d'))
                            ->where('key', 'moisture')
                            ->get()
                            ->toArray()
                    );
            })
            ->toArray();
    }
}
