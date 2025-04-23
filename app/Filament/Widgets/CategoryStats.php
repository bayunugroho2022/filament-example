<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CategoryStats extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = Trend::model(Category::class)
            ->between(now()->subMonths(6), now()) // contoh: data 6 bulan terakhir
            ->perMonth()
            ->count();

        $datasets = [
            [
                'label' => 'Categories',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                'backgroundColor' => '#FF6384',
            ],
        ];

        $labels = $data->map(fn (TrendValue $value) => \Carbon\Carbon::parse($value->date)->format('M d'));

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
