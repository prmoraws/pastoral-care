<?php

namespace App\Filament\Widgets;

use App\Models\Assistido;
use App\Models\Regiao;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class AssistidosPorRegiao extends ChartWidget
{
    protected static ?string $heading = 'Top 10 Regiões com mais Assistidos';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $dados = Regiao::all()->map(function ($regiao) {
            return [
                'nome'  => $regiao->nome,
                'total' => Assistido::where('regiao_id', $regiao->id)->count(),
            ];
        })->filter(fn($r) => $r['total'] > 0)
          ->sortByDesc('total')
          ->take(10)
          ->values();

        $cores = [
            'rgba(131, 58, 180, 0.8)',
            'rgba(253, 29, 29, 0.8)',
            'rgba(252, 176, 69, 0.8)',
            'rgba(32, 201, 151, 0.8)',
            'rgba(13, 202, 240, 0.8)',
            'rgba(111, 66, 193, 0.8)',
            'rgba(214, 51, 132, 0.8)',
            'rgba(253, 126, 20, 0.8)',
            'rgba(25, 135, 84, 0.8)',
            'rgba(13, 110, 253, 0.8)',
        ];

        return [
            'datasets' => [
                [
                    'label'           => 'Assistidos',
                    'data'            => $dados->pluck('total')->toArray(),
                    'backgroundColor' => array_slice($cores, 0, $dados->count()),
                    'borderColor'     => array_map(fn($c) => str_replace('0.8', '1', $c), array_slice($cores, 0, $dados->count())),
                    'borderWidth'     => 1,
                ],
            ],
            'labels' => $dados->pluck('nome')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}