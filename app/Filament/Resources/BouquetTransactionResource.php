<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BouquetTransactionResource\Pages;
use App\Filament\Resources\BouquetTransactionResource\RelationManagers;
use App\Models\BouquetTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BouquetTransactionResource extends Resource
{
    protected static ?string $model = BouquetTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(function () {
                        return \App\Models\User::all()->pluck('name', 'id')->toArray();
                    })
                    ->required(),

                Forms\Components\Select::make('bouquet_id')
                    ->label('Bouquet')
                    ->options(function () {
                        return \App\Models\Bouquet::all()->pluck('name', 'id')->toArray();
                    })
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('sub_total_amount')
                    ->label('Sub Total Amount')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('grand_total_amount')
                    ->label('Grand Total Amount')
                    ->numeric()
                    ->required(),

                Forms\Components\FileUpload::make('proof')
                    ->label('Proof')
                    ->image()
                    ->directory('proofs')
                    ->required(),

                Forms\Components\Select::make('bank_id')
                    ->label('Bank')
                    ->options(function () {
                        return \App\Models\Bank::all()->pluck('name', 'id')->toArray();
                    })
                    ->required(),

                Forms\Components\Toggle::make('is_paid')
                    ->label('Is Paid')
                    ->required(),

                Forms\Components\TextInput::make('transaction_trx_id')
                    ->label('Transaction ID')
                    ->default(fn () => BouquetTransaction::generateUniqueTrxId())
                    ->disabled()
                    ->required(),

                // Add status field
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'paid' => 'Paid',
                        'processing order' => 'Processing Order',
                        'in delivery' => 'In Delivery',
                        'success' => 'Success',
                    ])
                    ->default('unpaid') // Default status is 'unpaid'
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                ImageColumn::make('proof')
                    ->label('Proof')
                    ->size(50)
                    ->sortable()
                    ->extraAttributes(['class' => 'cursor-pointer'])
                    ->url(fn (BouquetTransaction $record) => $record->proof ? asset('storage/' . $record->proof) : null, true),

                TextColumn::make('user.name')->label('User Name')->sortable(),
                TextColumn::make('transaction_trx_id')->label('Transaction trx id')
                ->sortable()
                ->copyable(),
                TextColumn::make('grand_total_amount')->label('Grand Total')->money('IDR'),

                // Editable status field
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'checking' => 'Checking',
                        'paid' => 'Paid',
                        'processing order' => 'Processing Order',
                        'in delivery' => 'In Delivery',
                        'success' => 'Success',
                    ])
                    ->sortable()
                    ->searchable()
                    ->default('unpaid')
                    ->action(function (BouquetTransaction $record, $state) {
                        $record->update(['status' => $state]);
                    }),

                ToggleColumn::make('is_paid')
                    ->label('Is Paid')
                    ->sortable()
                    ->onColor('success')
                    ->offColor('danger')
                    ->action(function (BouquetTransaction $record, bool $state): void {
                        $record->update(['is_paid' => $state]);
                    }),
            ])
            ->filters([
                // You can add filters here if needed
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBouquetTransactions::route('/'),
            'create' => Pages\CreateBouquetTransaction::route('/create'),
            'edit' => Pages\EditBouquetTransaction::route('/{record}/edit'),
        ];
    }
}
