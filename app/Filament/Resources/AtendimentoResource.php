<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtendimentoResource\Pages;
use App\Models\Atendimento;
use App\Models\Pessoa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AtendimentoResource extends Resource
{
    protected static ?string $model = Atendimento::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Atendimentos';
    protected static ?string $modelLabel = 'Atendimento';
    protected static ?string $pluralModelLabel = 'Atendimentos';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Dados do Atendimento')
                ->schema([
                    Forms\Components\Select::make('pessoa_id')
                        ->label('Pessoa')
                        ->options(function () {
                            $query = Pessoa::query();
                            if (Auth::user()->hasRole('author')) {
                                $query->where('user_id', Auth::id());
                            }
                            return $query->pluck('nome', 'id');
                        })
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->columnSpanFull(),

                    Forms\Components\DatePicker::make('data_atendimento')
                        ->label('Data do Atendimento')
                        ->required()
                        ->default(now())
                        ->displayFormat('d/m/Y')
                        ->native(false),

                    Forms\Components\Hidden::make('user_id')
                        ->default(fn() => Auth::id()),

                    Forms\Components\Textarea::make('descricao')
                        ->label('Descreva o Atendimento')
                        ->required()
                        ->rows(5)
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('imagem')
                        ->label('Imagem')
                        ->image()
                        ->imageEditor()
                        ->directory('atendimentos')
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->getStateUsing(fn($record) => $record->titulo)
                    ->searchable(query: fn(Builder $query, string $search) =>
                        $query->where('descricao', 'like', "%{$search}%")
                    ),

                Tables\Columns\TextColumn::make('pessoa.nome')
                    ->label('Pessoa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('voluntario.name')
                    ->label('Atendido por')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('data_atendimento')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('imagem')
                    ->label('Imagem')
                    ->circular(),

                Tables\Columns\TextColumn::make('curtidas_count')
                    ->label('❤️')
                    ->sortable(),

                Tables\Columns\TextColumn::make('comentarios_count')
                    ->label('💬')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('pessoa_id')
                    ->label('Pessoa')
                    ->options(fn() => Pessoa::pluck('nome', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->user_id === Auth::id()),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => $record->user_id === Auth::id()),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (Auth::user()->hasRole('author')) {
            return $query->whereHas('pessoa', fn($q) =>
                $q->where('user_id', Auth::id())
            );
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
            'index'  => Pages\ListAtendimentos::route('/'),
            'create' => Pages\CreateAtendimento::route('/create'),
            'edit'   => Pages\EditAtendimento::route('/{record}/edit'),
        ];
    }
}