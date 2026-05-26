<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProfileResource\Pages;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'CV Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\TextInput::make('full_name')->required()->maxLength(120),
            Forms\Components\TextInput::make('headline')->required()->maxLength(160),
            Forms\Components\TextInput::make('birth_place')->maxLength(100),
            Forms\Components\DatePicker::make('birth_date'),
            Forms\Components\TextInput::make('current_city')->maxLength(100),
            Forms\Components\TextInput::make('email')->required()->email()->maxLength(150),
            Forms\Components\TextInput::make('phone')->required()->maxLength(30),
            Forms\Components\TextInput::make('nidn')
                ->label('NIDN')
                ->maxLength(20),
            Forms\Components\TextInput::make('academic_position')
                ->label('Jabatan Akademik')
                ->maxLength(100),
            Forms\Components\FileUpload::make('photo_path')
                ->label('Avatar')
                ->image()
                ->imageEditor()
                ->directory('profiles')
                ->disk('public')
                ->visibility('public'),
            Forms\Components\TextInput::make('website_url')->url(),
            Forms\Components\TextInput::make('linkedin_url')->url(),
            Forms\Components\TextInput::make('github_url')->url(),
            Forms\Components\TextInput::make('instagram_url')->url(),
            Forms\Components\Select::make('preferred_locale')
                ->options(['id' => 'ID', 'en' => 'EN'])
                ->default('id')
                ->required(),
            Forms\Components\Select::make('cv_status')
                ->options(['draft' => 'Draft', 'published' => 'Published'])
                ->default('draft')
                ->required(),
            Forms\Components\Textarea::make('professional_summary_id')
                ->label('Ringkasan Profesional (ID)')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\Textarea::make('professional_summary_en')
                ->label('Professional Summary (EN)')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\Textarea::make('academic_summary_id')
                ->label('Ringkasan Akademik (ID)')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\Textarea::make('academic_summary_en')
                ->label('Academic Summary (EN)')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('sinta_overall_score')
                ->label('SINTA Score Overall')
                ->numeric()
                ->step(0.01),
            Forms\Components\TextInput::make('sinta_score_3yr')
                ->label('SINTA Score 3Yr')
                ->numeric()
                ->step(0.01),
            Forms\Components\TextInput::make('affil_score')
                ->label('Affil Score')
                ->numeric()
                ->step(0.01),
            Forms\Components\TextInput::make('affil_score_3yr')
                ->label('Affil Score 3Yr')
                ->numeric()
                ->step(0.01),
            Forms\Components\Textarea::make('summary_id')
                ->label('Legacy Summary (ID)')
                ->rows(3)
                ->columnSpanFull(),
            Forms\Components\Textarea::make('summary_en')
                ->label('Legacy Summary (EN)')
                ->rows(3)
                ->columnSpanFull(),
            Forms\Components\Toggle::make('show_birth_date')->default(true),
            Forms\Components\Toggle::make('is_visible')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('headline')->limit(40),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('cv_status')->badge(),
                Tables\Columns\IconColumn::make('is_visible')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
