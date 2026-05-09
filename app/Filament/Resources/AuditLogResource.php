<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Auditoria';
    protected static ?string $modelLabel = 'Log';
    protected static ?string $pluralModelLabel = 'Logs de Auditoria';
    protected static ?string $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 10;

    // Apenas Super Admin vê auditoria
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data/Hora')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->searchable(),

                Tables\Columns\TextColumn::make('acao')
                    ->label('Ação')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'criou'   => 'success',
                        'editou'  => 'warning',
                        'excluiu' => 'danger',
                        default   => 'gray',
                    }),

                Tables\Columns\TextColumn::make('modelo')
                    ->label('Registro')
                    ->searchable(),

                Tables\Columns\TextColumn::make('modelo_id')
                    ->label('ID'),

                Tables\Columns\TextColumn::make('dados_anteriores')
                    ->label('Antes')
                    ->formatStateUsing(fn($state) => $state ? json_encode($state, JSON_UNESCAPED_UNICODE) : '—')
                    ->limit(50)
                    ->tooltip(fn($state) => $state ? json_encode($state, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : null),

                Tables\Columns\TextColumn::make('dados_novos')
                    ->label('Depois')
                    ->formatStateUsing(fn($state) => $state ? json_encode($state, JSON_UNESCAPED_UNICODE) : '—')
                    ->limit(50)
                    ->tooltip(fn($state) => $state ? json_encode($state, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : null),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('acao')
                    ->label('Ação')
                    ->options([
                        'criou'   => 'Criou',
                        'editou'  => 'Editou',
                        'excluiu' => 'Excluiu',
                    ]),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
        ];
    }
}
