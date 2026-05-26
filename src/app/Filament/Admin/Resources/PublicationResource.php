<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PublicationResource\Pages;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'CV Management';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('profile_id')
                ->relationship('profile', 'full_name')
                ->required()
                ->searchable()
                ->preload(),
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            Forms\Components\Textarea::make('authors')
                ->rows(2)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('journal_name')->maxLength(180),
            Forms\Components\TextInput::make('publisher')->maxLength(160),
            Forms\Components\TextInput::make('publication_year')
                ->numeric()
                ->minValue(1900)
                ->maxValue((int) now()->format('Y') + 1),
            Forms\Components\DatePicker::make('publication_date'),
            Forms\Components\TextInput::make('doi')->maxLength(120),
            Forms\Components\TextInput::make('external_id')->maxLength(100)
                ->label('SINTA/External ID'),
            Forms\Components\TextInput::make('sinta_url')
                ->url()
                ->label('SINTA URL')
                ->columnSpanFull(),
            Forms\Components\TextInput::make('sinta_score')->numeric()->step(0.01),
            Forms\Components\TextInput::make('sinta_quartile')->maxLength(20),
            Forms\Components\TextInput::make('citation_count')->numeric()->default(0),
            Forms\Components\Select::make('output_type')->options([
                'article' => 'Article',
                'research' => 'Research',
                'service' => 'Community Service',
                'ipr' => 'IPR',
                'book' => 'Book',
                'other' => 'Other',
            ])->default('article')->required(),
            Forms\Components\Select::make('source_view')->options([
                'scopus' => 'Scopus',
                'garuda' => 'SINTA/Garuda',
                'googlescholar' => 'Google Scholar',
                'rama' => 'RAMA',
                'wos' => 'Web of Science',
                'researches' => 'Researches',
                'services' => 'Community Services',
                'iprs' => 'IPRs',
                'books' => 'Books',
            ]),
            Forms\Components\Select::make('indexing_source')->options([
                'sinta' => 'SINTA',
                'scopus' => 'Scopus',
                'wos' => 'Web of Science',
                'google_scholar' => 'Google Scholar',
                'other' => 'Other',
            ])->default('sinta')->required(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_visible')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(45),
                Tables\Columns\TextColumn::make('output_type')->badge(),
                Tables\Columns\TextColumn::make('source_view')->badge(),
                Tables\Columns\TextColumn::make('journal_name')->toggleable(),
                Tables\Columns\TextColumn::make('publication_year')->sortable(),
                Tables\Columns\TextColumn::make('sinta_quartile')->badge(),
                Tables\Columns\TextColumn::make('citation_count')->sortable(),
                Tables\Columns\TextColumn::make('indexing_source')->badge(),
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
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
