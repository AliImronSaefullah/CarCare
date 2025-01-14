<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarStoreResource\Pages;
use App\Filament\Resources\CarStoreResource\RelationManagers;
use App\Models\CarStore;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarStoreResource extends Resource
{
    protected static ?string $model = CarStore::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                ->helperText('Masukkan nama store anda.')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('phone_number')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('cs_name')
                ->required()
                ->maxLength(255),

                Forms\Components\Select::make('is_open')
                ->options([
                    '1' => 'Open',
                    '0' => 'Closed',
                ])
                ->required(),

                Forms\Components\Select::make('is_full')
                ->options([
                    '1' => 'Full Booked',
                    '0' => 'Available',
                ])
                ->required(),

                Forms\Components\Select::make('city_id')
                ->relationship('city', 'name')
                ->searchable()
                ->preload()
                ->required(),

                Forms\Components\Repeater::make('storeServices')
                ->relationship()
                ->schema([
                    Forms\Components\Select::make('car_service_id')
                    ->relationship('service', 'name')
                    ->required(),
                ]),

                Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->required(),

                Forms\Components\Textarea::make('address')
                ->required()
                ->rows(10)
                ->cols(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                ->searchable(),

                Tables\Columns\IconColumn::make('is_open')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger')
                ->trueIcon('heroicon-s-check-circle')
                ->falseIcon('heroicon-s-x-circle')
                ->label('Open?'),

                Tables\Columns\IconColumn::make('is_full')
                ->boolean()
                ->trueColor('danger')
                ->falseColor('success')
                ->trueIcon('heroicon-s-x-circle')
                ->falseIcon('heroicon-s-check-circle')
                ->label('``Available?'),

                Tables\Columns\ImageColumn::make('thumbnail'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCarStores::route('/'),
            'create' => Pages\CreateCarStore::route('/create'),
            'edit' => Pages\EditCarStore::route('/{record}/edit'),
        ];
    }
}