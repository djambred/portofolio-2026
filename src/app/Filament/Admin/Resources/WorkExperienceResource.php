<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\WorkExperienceResource\Pages;
use App\Models\WorkExperience;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkExperienceResource extends Resource
{
    protected static ?string $model = WorkExperience::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'CV Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('profile_id')
                ->relationship('profile', 'full_name')
                ->required()
                ->searchable()
                ->preload(),
            Forms\Components\TextInput::make('company_name')->required()->maxLength(150),
            Forms\Components\TextInput::make('position_title')->required()->maxLength(150),
            Forms\Components\Select::make('employment_type')
                ->options([
                    'full_time' => 'Full Time',
                    'part_time' => 'Part Time',
                    'contract' => 'Contract',
                    'internship' => 'Internship',
                    'freelance' => 'Freelance',
                ])->required(),
            Forms\Components\TextInput::make('location')->maxLength(120),
            Forms\Components\DatePicker::make('start_date')->required(),
            Forms\Components\DatePicker::make('end_date'),
            Forms\Components\Toggle::make('is_current')->default(false),
            Forms\Components\Textarea::make('tools_text')->rows(3),
            Forms\Components\Textarea::make('description')->rows(5)->required()->columnSpanFull(),
            Forms\Components\TagsInput::make('achievements_id')->separator(','),
            Forms\Components\TagsInput::make('achievements_en')->separator(','),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_visible')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('position_title')->searchable(),
                Tables\Columns\TextColumn::make('employment_type')->badge(),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\IconColumn::make('is_current')->boolean(),
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
            'index' => Pages\ListWorkExperiences::route('/'),
            'create' => Pages\CreateWorkExperience::route('/create'),
            'edit' => Pages\EditWorkExperience::route('/{record}/edit'),
        ];
    }
}
