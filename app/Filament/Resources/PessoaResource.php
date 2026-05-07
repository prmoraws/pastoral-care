<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PessoaResource\Pages;
use App\Models\Pessoa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PessoaResource extends Resource
{
    protected static ?string $model = Pessoa::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Pessoas';
    protected static ?string $modelLabel = 'Pessoa';
    protected static ?string $pluralModelLabel = 'Pessoas';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Dados da Pessoa')
                ->schema([
                    Forms\Components\FileUpload::make('foto')
                        ->label('Foto')
                        ->image()
                        ->imageEditor()
                        ->directory('pessoas')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('nome')
                        ->label('Nome Completo')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('contato')
                        ->label('Contato')
                        ->tel()
                        ->required()
                        ->maxLength(20),

                    Forms\Components\TextInput::make('endereco')
                        ->label('Endereço')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('observacoes')
                        ->label('Observações')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Responsável')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Voluntário Responsável')
                        ->options(
                            User::role('author')->where('ativo', true)
                                ->pluck('name', 'id')
                        )
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->default(fn() => Auth::user()->hasRole('author') ? Auth::id() : null)
                        ->disabled(fn() => Auth::user()->hasRole('author'))
                        ->dehydrated(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->nome)),

                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('contato')
                    ->label('Contato')
                    ->searchable(),

                Tables\Columns\TextColumn::make('endereco')
                    ->label('Endereço')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->endereco),

                Tables\Columns\TextColumn::make('voluntario.name')
                    ->label('Voluntário')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('atendimentos_count')
                    ->label('Atendimentos')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Atualização')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Voluntário')
                    ->options(User::role('author')->pluck('name', 'id'))
                    ->visible(fn() => Auth::user()->hasRole('editor') || Auth::user()->hasRole('super_admin')),

                Tables\Filters\TrashedFilter::make()
                    ->visible(fn() => Auth::user()->hasRole('editor') || Auth::user()->hasRole('super_admin')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Voluntário só vê suas próprias pessoas
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->withTrashed();

        if (Auth::user()->hasRole('author')) {
            return $query->where('user_id', Auth::id());
        }

        return $query;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPessoas::route('/'),
            'create' => Pages\CreatePessoa::route('/create'),
            'edit'   => Pages\EditPessoa::route('/{record}/edit'),
            'view'   => Pages\ViewPessoa::route('/{record}'),
        ];
    }
}
