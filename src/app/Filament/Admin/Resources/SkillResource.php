<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SkillResource\Pages;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $navigationGroup = 'CV Management';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('profile_id')->relationship('profile', 'full_name')->required()->searchable()->preload(),
            Forms\Components\TextInput::make('name')->required()->maxLength(100),
            Forms\Components\Select::make('category')->options([
                'programming' => 'Programming',
                'database' => 'Database',
                'devops' => 'DevOps',
                'analysis' => 'Analysis',
                'networking' => 'Networking',
                'reporting' => 'Reporting',
                'other' => 'Other',
            ])->required(),
            Forms\Components\Select::make('proficiency_level')->options([
                'beginner' => 'Beginner',
                'intermediate' => 'Intermediate',
                'advanced' => 'Advanced',
                'expert' => 'Expert',
            ])->required(),
            Forms\Components\TextInput::make('proficiency_score')->numeric()->minValue(1)->maxValue(5),
            Forms\Components\TextInput::make('years_of_experience')->numeric()->minValue(0)->maxValue(60),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_visible')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category')->badge(),
                Tables\Columns\TextColumn::make('proficiency_level')->badge(),
                Tables\Columns\TextColumn::make('proficiency_score'),
                Tables\Columns\TextColumn::make('years_of_experience')->label('Years'),
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
            'index' => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }
}
