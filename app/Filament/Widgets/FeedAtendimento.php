<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FeedAtendimento extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Feed de Atendimento', '')
                ->description('Abrir página do feed')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary')
                ->url(route('feed'))
                ->openUrlInNewTab(),

        ];
    }
}