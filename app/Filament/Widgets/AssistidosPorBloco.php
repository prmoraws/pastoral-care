<?php

namespace App\Filament\Widgets;

use App\Models\Assistido;
use App\Models\Bloco;
use Filament\Widgets\ChartWidget;

class AssistidosPorBloco extends ChartWidget
{
    protected static ?string $heading = 'Assistidos por Bloco';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $blocos = Bloco::withCount(['regiaos as assistidos_count' => function ($q) {
            $q->join('assistidos', 'assistidos.regiao_id', '=', 'regiaos.id');
        }])->orderByDesc('assistidos_count')->get();

        // Fallback: contar direto por bloco_id
        $dados = Bloco::all()->map(function ($bloco) {
            return [
                'nome'  => $bloco->nome,
                'total' => Assistido::where('bloco_id', $bloco->id)->count(),
            ];
        })->filter(fn($b) => $b['total'] > 0)->sortByDesc('total')->values();

        $cores = [
            '#833ab4', '#fd1d1d', '#fcb045', '#20c997',
            '#0dcaf0', '#6f42c1', '#d63384', '#fd7e14',
            '#198754', '#0d6efd', '#6c757d', '#dc3545',
        ];

        return [
            'datasets' => [
                [
                    'label'           => 'Assistidos',
                    'data'            => $dados->pluck('total')->toArray(),
                    'backgroundColor' => array_slice($cores, 0, $dados->count()),
                    'borderRadius'    => 6,
                ],
            ],
            'labels' => $dados->pluck('nome')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}