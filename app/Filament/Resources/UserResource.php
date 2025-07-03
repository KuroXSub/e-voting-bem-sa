<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $pluralModelLabel = 'Pengguna';

    protected static ?string $navigationLabel = 'Manajemen Pengguna';

    protected static ?string $navigationGroup = 'Manajemen Akses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengguna')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('role')
                            ->label('Peran')
                            ->options([
                                'Admin' => 'Admin',
                                'Mahasiswa' => 'Mahasiswa',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),
                        Forms\Components\TextInput::make('nim')
                            ->label('NIM')
                            ->numeric()
                            ->unique(ignoreRecord: true)
                            ->visible(fn (Forms\Get $get) => $get('role') === 'Mahasiswa')
                            ->required(fn (Forms\Get $get) => $get('role') === 'Mahasiswa'),
                        Forms\Components\Select::make('verification')
                            ->label('Status Verifikasi')
                            ->options([
                                'Verified' => 'Verified',
                                'Unverified' => 'Unverified',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('password')
                            ->label('Kata Sandi')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->maxLength(255)
                            ->confirmed(), 

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Konfirmasi Kata Sandi')
                            ->password()
                            ->requiredWith('password')
                            ->dehydrated(false), 
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->label('Peran')
                    ->colors([
                        'primary' => 'Mahasiswa',
                        'success' => 'Admin',
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('verification')
                    ->label('Verifikasi')
                    ->options([
                        'Verified' => 'Verified',
                        'Unverified' => 'Unverified',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('role')
                    ->label('Peran')
                    ->options([
                        'Admin' => 'Admin',
                        'Mahasiswa' => 'Mahasiswa',
                    ]),
                Tables\Filters\SelectFilter::make('verification')
                    ->label('Status Verifikasi')
                    ->options([
                        'Verified' => 'Verified',
                        'Unverified' => 'Unverified',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
