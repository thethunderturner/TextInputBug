<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestResource\Pages;
use App\Models\Test;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;

class TestResource extends Resource
{
    protected static ?string $model = Test::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount_in_euro')
                    ->suffixIcon('heroicon-m-currency-euro')
                    ->mask(RawJs::make(<<<'JS'
                $money($input)
            JS)),
                FileUpload::make('attachments')
                    ->required()
                    ->multiple()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount_in_euro')
                    ->label('Amount')
                    ->sortable()
                    ->money('EUR')
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    ),
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
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTest::route('/create'),
            'edit' => Pages\EditTest::route('/{record}/edit'),
        ];
    }
}
