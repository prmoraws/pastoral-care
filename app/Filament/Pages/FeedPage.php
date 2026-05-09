<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class FeedPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Meus Atendimentos';
    protected static ?string $title = 'Meus Atendimentos';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.feed-page';

    // Só aparece para author
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('author');
    }

    public function mount(): void
    {
        // Redireciona direto para o feed
        redirect()->route('feed');
    }
}