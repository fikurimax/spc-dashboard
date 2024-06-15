<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use App\Models\Telemetry;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class TelemetryChart extends ChartWidget
{
    protected static ?string $heading = 'Live Record';
    protected static string $color = 'info';
    protected static ?string $pollingInterval = '2s';
    protected static ?string $maxHeight = '600px';

    public static function getStockChartData()
    {
        // Get data for the last 3 hours
        $startTime = Carbon::now()->subHours(3);
        $stockUpdates = Telemetry::where('created_at', '>=', $startTime)
            ->orderBy('created_at')
            ->get();

        $labels = [];
        $data = [];

        // Divide the time range into 15 parts
        $timeInterval = $startTime->diffInMinutes(Carbon::now()) / 15;

        for ($i = 0; $i < 15; $i++) {
            $time = $startTime->copy()->addMinutes($i * $timeInterval);
            $labels[] = $time->format('H:i');

            // Get the closest stock value for the current interval
            $stockValue = $stockUpdates->filter(function ($update) use ($time, $timeInterval) {
                return $update->created_at->between($time, $time->copy()->addMinutes($timeInterval));
            })->first();

            $data[] = $stockValue ? $stockValue->value : 0;
        }

        return compact('labels', 'data');
    }

    protected function getData(): array
    {
        $telemetry = Telemetry::query()
            ->whereBetween('created_at', [Carbon::now()->subHour(), Carbon::now()])
            ->latest('created_at')
            ->take(15)
            ->get();

        $devices = Device::all();

        return [
            'datasets' => $devices->map(fn ($device) => [
                'label' => $device->name,
                'data' => $device->telemetries()
                    ->whereBetween('created_at', [Carbon::now()->subHour(), Carbon::now()])
                    ->latest('created_at')
                    ->take(15)
                    ->get()
                    ->pluck('value')->toArray(),
            ]),
            'labels' => $telemetry->map(fn ($tel) => Carbon::parse($tel->created_at)->format('H:i'))->pluck('created_at')->toArray()
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
