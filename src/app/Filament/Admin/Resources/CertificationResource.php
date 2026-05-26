<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CertificationResource\Pages;
use App\Models\Certification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CertificationResource extends Resource
{
    protected static ?string $model = Certification::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'CV Management';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('profile_id')->relationship('profile', 'full_name')->required()->searchable()->preload(),
            Forms\Components\TextInput::make('name')->required()->maxLength(180),
            Forms\Components\TextInput::make('issuer')->required()->maxLength(150),
            Forms\Components\DatePicker::make('issued_at'),
            Forms\Components\DatePicker::make('expired_at'),
            Forms\Components\TextInput::make('credential_id')->maxLength(120),
            Forms\Components\TextInput::make('credential_url')->url(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_visible')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('issuer')->searchable(),
                Tables\Columns\TextColumn::make('issued_at')->date(),
                Tables\Columns\TextColumn::make('expired_at')->date(),
                Tables\Columns\IconColumn::make('is_visible')->boolean(),
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
            'index' => Pages\ListCertifications::route('/'),
            'create' => Pages\CreateCertification::route('/create'),
            'edit' => Pages\EditCertification::route('/{record}/edit'),
        ];
    }
}
