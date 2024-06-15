<?php

namespace App\Filament\Widgets;

use App\Models\Telemetry;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTelemetryTable extends BaseWidget
{
    protected static ?string $pollingInterval = '2s';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Telemetry::query()
                    ->with('device')
                    ->latest('created_at')
                    ->limit(10)
            )
            ->paginated(false)
            ->poll('2s')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Date'),
                Tables\Columns\TextColumn::make('device.name')->label('Device'),
                Tables\Columns\TextColumn::make('key')->label('Key'),
                Tables\Columns\TextColumn::make('value')->label('Value'),
            ]);
    }
}
