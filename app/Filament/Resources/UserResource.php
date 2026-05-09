<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $pluralModelLabel = 'Usuários';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informações Pessoais')
                ->schema([
                    Forms\Components\FileUpload::make('avatar')
                        ->label('Foto de Perfil')
                        ->image()
                        ->imageEditor()
                        ->directory('avatars')
                        ->columnSpanFull(),

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

                    Forms\Components\TextInput::make('contato')
                        ->label('Contato')
                        ->tel()
                        ->maxLength(20),

                    Forms\Components\TextInput::make('password')
                        ->label('Senha')
                        ->password()
                        ->revealable()
                        ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn(string $operation) => $operation === 'create'),
                ])->columns(2),

            Forms\Components\Section::make('Papel e Função')
                ->schema([
                    Forms\Components\Select::make('roles')
                        ->label('Papel no Sistema')
                        ->relationship('roles', 'name')
                        ->options(
                            Role::whereIn('name', ['editor', 'author'])
                                ->pluck('name', 'id')
                                ->map(fn($name) => match ($name) {
                                    'editor' => 'Coordenador',
                                    'author' => 'Voluntário',
                                    default  => $name,
                                })
                        )
                        ->required()
                        ->native(false)
                        ->live(),

                    Forms\Components\Select::make('cargo')
                        ->label('Cargo (apenas Coordenador)')
                        ->options([
                            'Bispo'   => 'Bispo',
                            'Pastor'  => 'Pastor',
                            'Esposa'  => 'Esposa',
                            'Obreiro' => 'Obreiro',
                        ])
                        ->native(false)
                        ->nullable(),

                    Forms\Components\Toggle::make('ativo')
                        ->label('Usuário Ativo')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name)),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Papel')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'editor' => 'Coordenador',
                        'author' => 'Voluntário',
                        default  => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        'editor' => 'warning',
                        'author' => 'success',
                        default  => 'gray',
                    }),

                Tables\Columns\TextColumn::make('cargo')
                    ->label('Cargo')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('condicao')
                    ->label('Condição')
                    ->placeholder('—'),

                Tables\Columns\IconColumn::make('ativo')
                    ->label('Ativo')
                    ->boolean(),

                Tables\Columns\TextColumn::make('atendimentos_count')
                    ->label('Atendimentos')
                    ->counts('atendimentos')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->label('Papel')
                    ->relationship('roles', 'name')
                    ->options([
                        'editor' => 'Coordenador',
                        'author' => 'Voluntário',
                    ]),

                Tables\Filters\TernaryFilter::make('ativo')
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // Super Admin só gerenciado via Shield
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereDoesntHave('roles', fn($q) => $q->where('name', 'super_admin'));
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
}
