<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Filament\Resources\CandidateResource\RelationManagers;
use App\Models\Candidate;
use App\Models\ElectionPeriod;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class CandidateResource extends Resource
{
    protected static ?string $model = Candidate::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $pluralModelLabel = 'Kandidat';

    protected static ?string $navigationLabel = 'Manajemen Kandidat';

    protected static ?string $navigationGroup = 'Pemilihan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Periode')
                    ->schema([
                        Forms\Components\Select::make('election_period_id')
                            ->label('Periode Pemilihan')
                            ->options(
                                ElectionPeriod::query()
                                    ->where('is_active', true)
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->native(false)
                            ->searchable(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Data Pasangan Calon')
                    ->schema([
                        Forms\Components\Select::make('chairman_id')
                            ->label('Ketua')
                            ->options(
                                User::where('role', 'Mahasiswa')
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $user = User::find($state);
                                    $set('chairman_name', $user->name);
                                    $set('chairman_nim', $user->nim);
                                }
                            }),

                        Forms\Components\Select::make('vice_chairman_id')
                            ->label('Wakil Ketua')
                            ->options(
                                User::where('role', 'Mahasiswa')
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $user = User::find($state);
                                    $set('vice_chairman_name', $user->name);
                                    $set('vice_chairman_nim', $user->nim);
                                }
                            }),

                        Forms\Components\TextInput::make('number')
                            ->label('Nomor Urut')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(99)
                            ->afterStateHydrated(function (TextInput $component, $state) {
                                $component->state((int) $state);
                            })
                            ->dehydrateStateUsing(function ($state) {
                                return (int) $state;
                            }),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Detail Kandidat')
                    ->schema([
                        Forms\Components\FileUpload::make('photo_url')
                            ->label('Foto Pasangan')
                            ->image()
                            ->directory('candidates')
                            ->maxSize(2048)
                            ->downloadable()
                            ->openable()
                            ->previewable(),

                        Forms\Components\Textarea::make('vision')
                            ->label('Visi')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('mission')
                            ->label('Misi')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.'&background=random'),

                Tables\Columns\TextColumn::make('number')
                    ->label('No. Urut')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => str_pad($state, 2, '0', STR_PAD_LEFT))
                    ->searchable()
                    ->color('candidate'),

                Tables\Columns\TextColumn::make('chairman.name')
                    ->label('Ketua')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('viceChairman.name')
                    ->label('Wakil')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('electionPeriod.name')
                    ->label('Periode')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('votes_count')
                    ->label('Suara')
                    ->counts('votes')
                    ->sortable()
                    ->color('vote'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('election_period_id')
                    ->label('Periode Pemilihan')
                    ->options(fn () => ElectionPeriod::pluck('name', 'id'))
                    ->searchable(),

                Tables\Filters\SelectFilter::make('chairman_id')
                    ->label('Ketua')
                    ->options(fn () => User::where('role', 'Mahasiswa')->pluck('name', 'id'))
                    ->searchable(),

                Tables\Filters\SelectFilter::make('vice_chairman_id')
                    ->label('Wakil Ketua')
                    ->options(fn () => User::where('role', 'Mahasiswa')->pluck('name', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        Storage::delete($record->photo_url);
                    }),
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
            'index' => Pages\ListCandidates::route('/'),
            'create' => Pages\CreateCandidate::route('/create'),
            'edit' => Pages\EditCandidate::route('/{record}/edit'),
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
