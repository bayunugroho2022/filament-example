<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class ProductStats extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Produk per Kategori';

    protected function getData(): array
    {
        $categories = Category::withCount('products')->get();

        return [
            'labels' => $categories->pluck('name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Jumlah Produk',
                    'data' => $categories->pluck('products_count')->toArray(),
                    'backgroundColor' => $this->generateColors($categories->count()),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    /**
     * Generate random colors or preset for the chart
     */
    private function generateColors(int $count): array
    {
        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
            '#9966FF', '#FF9F40', '#8B0000', '#008080'
        ];

        // Repeat if not enough colors
        return array_slice(array_pad($colors, $count, $colors), 0, $count);
    }
}
