<?php

namespace App\Filament\Widgets;

use App\Models\Assistido;
use App\Models\Bloco;
use App\Models\Regiao;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalAssistidos  = Assistido::count();
        $totalBlocos      = Bloco::count();
        $totalRegioes     = Regiao::count();
        $totalVoluntarios = User::role('author')->count();
        $totalCoordenadores = User::role('editor')->count();

        $assistidosEsteMes = Assistido::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            Stat::make('Total de Assistidos', $totalAssistidos)
                ->description('Todos os atendimentos registrados')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart(
                    Assistido::selectRaw('COUNT(*) as count')
                        ->groupBy('created_at')
                        ->orderBy('created_at')
                        ->limit(7)
                        ->pluck('count')
                        ->toArray()
                ),

            Stat::make('Assistidos este mês', $assistidosEsteMes)
                ->description('Registrados em ' . now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),

            Stat::make('Blocos', $totalBlocos)
                ->description("{$totalRegioes} regiões cadastradas")
                ->descriptionIcon('heroicon-m-map')
                ->color('warning'),

            Stat::make('Voluntários', $totalVoluntarios)
                ->description("{$totalCoordenadores} coordenadores")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }
}