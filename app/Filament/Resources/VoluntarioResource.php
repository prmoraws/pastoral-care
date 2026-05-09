<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoluntarioResource\Pages;
use App\Models\Voluntario;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VoluntarioResource extends Resource
{
    protected static ?string $model = \App\Models\User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Voluntários';
    protected static ?string $modelLabel = 'Voluntário';
    protected static ?string $pluralModelLabel = 'Voluntários';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Dados do Voluntário')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome Completo')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\TextInput::make('perfilVoluntario.contato')
                        ->label('Contato')
                        ->maxLength(20),

                    Forms\Components\TextInput::make('perfilVoluntario.igreja')
                        ->label('Igreja / Região / Bloco')
                        ->maxLength(255),

                    Forms\Components\Select::make('perfilVoluntario.condicao')
                        ->label('Condição')
                        ->options([
                            'Bispo'          => 'Bispo',
                            'Pastor'         => 'Pastor',
                            'Esposa'         => 'Esposa',
                            'Obreiro'        => 'Obreiro',
                            'Evangelista'    => 'Evangelista',
                            'Lider de Grupo' => 'Líder de Grupo',
                            'Membro'         => 'Membro',
                        ])
                        ->native(false),

                    Forms\Components\Toggle::make('perfilVoluntario.ativo')
                        ->label('Ativo')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('perfilVoluntario.avatar')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=833ab4&color=fff'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),

                Tables\Columns\TextColumn::make('perfilVoluntario.contato')
                    ->label('Contato')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('perfilVoluntario.igreja')
                    ->label('Igreja/Região/Bloco')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('perfilVoluntario.condicao')
                    ->label('Condição')
                    ->badge()
                    ->color('success')
                    ->placeholder('—'),

                Tables\Columns\IconColumn::make('perfilVoluntario.ativo')
                    ->label('Ativo')
                    ->boolean(),

                Tables\Columns\TextColumn::make('atendimentos_count')
                    ->label('Atendimentos')
                    ->counts('atendimentos')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\SelectFilter::make('condicao')
                    ->label('Condição')
                    ->options([
                        'Bispo'          => 'Bispo',
                        'Pastor'         => 'Pastor',
                        'Esposa'         => 'Esposa',
                        'Obreiro'        => 'Obreiro',
                        'Evangelista'    => 'Evangelista',
                        'Lider de Grupo' => 'Líder de Grupo',
                        'Membro'         => 'Membro',
                    ])
                    ->query(fn($query, $data) => $data['value']
                        ? $query->whereHas('perfilVoluntario', fn($q) => $q->where('condicao', $data['value']))
                        : $query),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('roles', fn($q) => $q->where('name', 'author'));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListVoluntarios::route('/'),
            'create' => Pages\CreateVoluntario::route('/create'),
            'edit'   => Pages\EditVoluntario::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
}
