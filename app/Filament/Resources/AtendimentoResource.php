<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtendimentoResource\Pages;
use App\Models\Assistido;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AtendimentoResource extends Resource
{
    protected static ?string $model = Assistido::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Assistidos';
    protected static ?string $modelLabel = 'Assistido';
    protected static ?string $pluralModelLabel = 'Assistidos';
    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return !auth()->user()->hasRole('author');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Dados do Assistido')
                ->schema([
                    Forms\Components\FileUpload::make('foto')
                        ->label('Foto do Assistido')
                        ->image()
                        ->imageEditor()
                        ->directory('assistidos')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('nome_assistido')
                        ->label('Nome do Assistido')
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
                        ->maxLength(255),

                    Forms\Components\TextInput::make('bairro')
                        ->label('Bairro')
                        ->required()
                        ->maxLength(100),

                    Forms\Components\TextInput::make('cidade')
                        ->label('Cidade')
                        ->required()
                        ->maxLength(100),
                ])->columns(2),

            Forms\Components\Section::make('Dados do Atendimento')
                ->schema([
                    Forms\Components\Hidden::make('user_id')
                        ->default(fn() => Auth::id()),

                    Forms\Components\DatePicker::make('data_atendimento')
                        ->label('Data do Atendimento')
                        ->required()
                        ->default(now())
                        ->displayFormat('d/m/Y')
                        ->native(false),

                    Forms\Components\Textarea::make('descricao')
                        ->label('Descreva o Atendimento')
                        ->required()
                        ->rows(5)
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('imagem')
                        ->label('Imagem do Atendimento')
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
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->nome_assistido)),

                Tables\Columns\TextColumn::make('nome_assistido')
                    ->label('Assistido')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('cidade')
                    ->label('Cidade')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bairro')
                    ->label('Bairro')
                    ->searchable(),

                Tables\Columns\TextColumn::make('voluntario.name')
                    ->label('Voluntário')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('data_atendimento')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('curtidas_count')
                    ->label('❤️')
                    ->sortable(),

                Tables\Columns\TextColumn::make('comentarios_count')
                    ->label('💬')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Voluntário')
                    ->relationship('voluntario', 'name')
                    ->visible(fn() => Auth::user()->hasRole('editor') || Auth::user()->hasRole('super_admin')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->user_id === Auth::id() || Auth::user()->hasRole('super_admin')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => $record->user_id === Auth::id() || Auth::user()->hasRole('super_admin')),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

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
            'index'  => Pages\ListAtendimentos::route('/'),
            'create' => Pages\CreateAtendimento::route('/create'),
            'edit'   => Pages\EditAtendimento::route('/{record}/edit'),
        ];
    }
}
