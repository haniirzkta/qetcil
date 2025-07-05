<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BouquetTransactionResource\Pages;
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
                        return \App\Models\User::all()->mapWithKeys(function ($user) {
                            return [$user->id => $user->name ?? 'Unnamed User'];
                        })->toArray();
                    })
                    ->required(),

                Forms\Components\Select::make('bouquet_id')
                    ->label('Bouquet')
                    ->options(function () {
                        return \App\Models\Bouquet::all()->mapWithKeys(function ($bouquet) {
                            return [$bouquet->id => $bouquet->name ?? 'Unnamed Bouquet'];
                        })->toArray();
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
                        return \App\Models\Bank::all()->mapWithKeys(function ($bank) {
                            return [$bank->id => $bank->bank_name ?? 'Unnamed Bank'];
                        })->toArray();
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

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'paid' => 'Paid',
                        'processing order' => 'Processing Order',
                        'in delivery' => 'In Delivery',
                        'success' => 'Success',
                    ])
                    ->default('unpaid')
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

                TextColumn::make('transaction_trx_id')
                    ->label('Transaction trx id')
                    ->sortable()
                    ->copyable(),

                TextColumn::make('user.address.address')
    ->label('Alamat')
    ->wrap()
    ->sortable(),

TextColumn::make('user.address.city')
    ->label('Kota')
    ->sortable(),

TextColumn::make('user.address.post_code')
    ->label('Kode Pos')
    ->sortable(),



                TextColumn::make('grand_total_amount')
                    ->label('Grand Total')
                    ->money('IDR'),

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
                // Tambahkan filter jika diperlukan
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