<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoteResource\Pages;
use App\Filament\Resources\VoteResource\RelationManagers;
use App\Models\Vote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VoteResource extends Resource
{
    protected static ?string $model = Vote::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $pluralModelLabel = 'Data Pemilihan';

    protected static ?string $navigationLabel = 'Rekapitulasi Suara';

    protected static ?string $navigationGroup = 'Pemilihan';

    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hashed_user')
                    ->label('ID Pemilih')
                    ->description(fn ($record) => 'Fakultas: ' . substr(hash_hmac('sha256', $record->voter->faculty ?? '', config('app.key')), 0, 8))
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('voter', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                            ->orWhere('nim', 'like', "%{$search}%");
                        });
                    }),

                Tables\Columns\TextColumn::make('voted_at')
                    ->label('Waktu Memilih')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('candidate.number')
                    ->label('No. Kandidat')
                    ->formatStateUsing(fn ($state) => str_pad($state, 2, '0', STR_PAD_LEFT))
                    ->sortable(),

                Tables\Columns\TextColumn::make('electionPeriod.name')
                    ->label('Periode')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('election_period_id')
                    ->label('Filter Periode')
                    ->relationship('electionPeriod', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('voted_at')
                    ->form([
                        Forms\Components\DatePicker::make('voted_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('voted_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['voted_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('voted_at', '>=', $date),
                            )
                            ->when(
                                $data['voted_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('voted_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                //
            ])
            ->bulkActions([])
            ->emptyStateHeading('Belum ada data pemilihan')
            ->defaultSort('voted_at', 'desc')
            ->deferLoading()
            ->persistFiltersInSession();
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
            'index' => Pages\ListVotes::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['voter', 'candidate', 'electionPeriod'])
            ->select('votes.*');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
