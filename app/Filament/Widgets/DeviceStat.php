<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DeviceStat extends BaseWidget
{

    protected static ?string $pollingInterval = '2s';

    private function determineState(int|float $value): string
    {
        return match ($value) {
            $value < 300 => "Kering",
            $value > 300 && $value < 500 => "Baik",
            $value > 500 && $value < 700 => "Sangat Baik",
            default => "-"
        };
    }

    protected function getStats(): array
    {
        return Device::all()
            ->transform(function (Device $device) {
                return (new Stat(
                    $device->mac_address,
                    $this->determineState($device->telemetries()->where('key', 'moisture')->latest('created_at')->first()?->value) ?? 0,
                ))
                    ->extraAttributes([
                        'class' => 'cursor-pointer',
                    ])
                    ->description('Kelembaban tanah')
                    ->chart(
                        $device->telemetries()
                            ->whereDate('created_at', now()->format('Y-m-d'))
                            ->where('key', 'moisture')
                            ->get()
                            ->pluck('value')
                            ->toArray()
                    );
            })
            ->toArray();
    }
}
