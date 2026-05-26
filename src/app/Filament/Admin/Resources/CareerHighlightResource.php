<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CareerHighlightResource\Pages;
use App\Models\CareerHighlight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CareerHighlightResource extends Resource
{
    protected static ?string $model = CareerHighlight::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'CV Management';

    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('profile_id')->relationship('profile', 'full_name')->required()->searchable()->preload(),
            Forms\Components\TextInput::make('title')->required()->maxLength(160),
            Forms\Components\Textarea::make('description_id')->rows(3),
            Forms\Components\Textarea::make('description_en')->rows(3),
            Forms\Components\TextInput::make('metric_value')->maxLength(80),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_visible')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('metric_value'),
                Tables\Columns\IconColumn::make('is_visible')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->defaultSort('sort_order')
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
            'index' => Pages\ListCareerHighlights::route('/'),
            'create' => Pages\CreateCareerHighlight::route('/create'),
            'edit' => Pages\EditCareerHighlight::route('/{record}/edit'),
        ];
    }
}
