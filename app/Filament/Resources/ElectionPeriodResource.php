<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElectionPeriodResource\Pages;
use App\Filament\Resources\ElectionPeriodResource\RelationManagers;
use App\Models\ElectionPeriod;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ElectionPeriodResource extends Resource
{
    protected static ?string $model = ElectionPeriod::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $pluralModelLabel = 'Periode Pemilihan';

    protected static ?string $navigationLabel = 'Manajemen Periode';

    protected static ?string $navigationGroup = 'Pengaturan Sistem';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Periode')
                    ->description('Tentukan periode waktu pemilihan berlangsung')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Periode')
                            ->placeholder('Contoh: Pemilihan BEM 2024')
                            ->columnSpanFull(),
                            
                        Forms\Components\DateTimePicker::make('start_date')
                            ->required()
                            ->seconds(false)
                            ->minutesStep(15)
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->weekStartsOnMonday()
                            ->live()
                            ->label('Tanggal Mulai')
                            ->helperText('Waktu mulai pemilihan'),
                            
                        Forms\Components\DateTimePicker::make('end_date')
                            ->required()
                            ->seconds(false)
                            ->minutesStep(15)
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->weekStartsOnMonday()
                            ->label('Tanggal Berakhir')
                            ->helperText('Waktu berakhirnya pemilihan dan penghitungan suara')
                            ->minDate(function (Forms\Get $get) {
                                $startDate = $get('start_date');
                                return $startDate ? Carbon::parse($startDate) : now();
                            })
                            ->rules([
                                function (Forms\Get $get) {
                                    return function (string $attribute, $value, \Closure $fail) use ($get) {
                                        $startDate = $get('start_date');
                                        if ($startDate && $value && Carbon::parse($value)->lt(Carbon::parse($startDate))) {
                                            $fail("Tanggal berakhir harus setelah tanggal mulai.");
                                        }
                                    };
                                },
                            ]),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Pengaturan Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                        ->label('Status Periode')
                        ->options([
                            'Non-aktif' => 'Non-aktif',
                            'Belum dimulai' => 'Belum dimulai',
                            'Sedang Berlangsung' => 'Sedang Berlangsung',
                            'Telah Selesai' => 'Telah Selesai',
                        ])
                        ->required()
                        ->live(),
                            
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Tambahan')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Informasi tambahan tentang periode pemilihan ini'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->color('election')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Periode')
                    ->description(fn ($record) => $record->description ? Str::limit($record->description, 40) : '')
                    ->wrap(),
                    
                Tables\Columns\TextColumn::make('date_range')
                    ->label('Periode Waktu')
                    ->state(function ($record) {
                        $start = Carbon::parse($record->start_date)->format('d M Y H:i');
                        $end = Carbon::parse($record->end_date)->format('d M Y H:i');
                        return "{$start} - {$end}";
                    })
                    ->sortable(['start_date'])
                    ->color(fn ($state) => $state ? 'success' : 'danger'),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Status Periode')
                    ->options([
                        'Non-aktif' => 'Non-aktif',
                        'Belum dimulai' => 'Belum dimulai',
                        'Sedang Berlangsung' => 'Sedang Berlangsung',
                        'Telah Selesai' => 'Telah Selesai',
                    ])
                    ->rules(['required'])
                    ->selectablePlaceholder(false)
                    ->afterStateUpdated(function ($state, Model $record) {
                        $record->status = $state;
                        $record->save();
                    })
                    ->disabledClick(),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                    
                Tables\Columns\TextColumn::make('candidates_count')
                    ->label('Kandidat')
                    ->counts('candidates')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('votes_count')
                    ->label('Suara')
                    ->counts('votes')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->hidden(fn ($record) => $record->is_active)
                        ->action(function ($record) {
                            ElectionPeriod::where('id', '!=', $record->id)
                                ->update(['is_active' => false]);
                                
                            $record->is_active = true;
                            $record->save();
                        }),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan Periode')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->is_active = true;
                                $record->save();
                            });
                            
                            ElectionPeriod::whereNotIn('id', $records->pluck('id'))
                                ->update(['is_active' => false]);
                        })
                        ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListElectionPeriods::route('/'),
            'create' => Pages\CreateElectionPeriod::route('/create'),
            'edit' => Pages\EditElectionPeriod::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('is_active', true)->exists() ? 'success' : 'primary';
    }
}
