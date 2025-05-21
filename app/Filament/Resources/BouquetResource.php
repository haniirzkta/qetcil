<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BouquetResource\Pages;
use App\Filament\Resources\BouquetResource\RelationManagers;
use App\Models\Bouquet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;


class BouquetResource extends Resource
{
    protected static ?string $model = Bouquet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->maxLength(255),

                FileUpload::make('thumbnail')
                ->required()
                ->image(),

                TextInput::make('about')
                ->required()
                ->maxLength(255),

                TextInput::make('price')
                ->required()
                ->numeric(),

                Select::make('category_id')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->required(),

                Select::make('is_popular')
                ->options([
                    true => 'Popular',
                    false => 'Not Popular',
                ])
                ->required(),

                TextInput::make('stock')
                ->required()
                ->numeric(),

                Select::make('is_sold')
                ->options([
                    true => 'Sold',
                    false => 'Not Sold',
                ])
                ->required(),

                Repeater::make('bouquetPhotos')
                ->relationship('bouquetPhotos')
                ->schema([
                    FileUpload::make('photo')
                    ->required()
                    ->image(),
                ]),

                // Repeater::make('bouquetSizes')
                // ->schema([
                //     TextInput::make('jewelrySize_id')
                //     ->relationship('jewelrySizes', 'size')
                //     ->searchable()
                //     ->preload()
                //     ->required(),
                // ]),

                // Repeater::make('bouquetSizes')
                // ->schema([
                //     Select::make('size')
                //     ->searchable()
                //     ->preload()
                //     ->required(),
                // ]),




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail'),

                TextColumn::make('name')
                ->searchable(),


                TextColumn::make('price')
                ->money('IDR'),

                TextColumn::make('stock'),

                TextColumn::make('category.name')
                ->searchable(),

                IconColumn::make('is_popular')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger')
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->label('Popular'),






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
            'index' => Pages\ListBouquets::route('/'),
            'create' => Pages\CreateBouquet::route('/create'),
            'edit' => Pages\EditBouquet::route('/{record}/edit'),
        ];
    }
}
