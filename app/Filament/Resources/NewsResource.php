<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'resources';

    protected static ?int $navigationSort = 15;

    public static function getNavigationGroup(): ?string
    {
        return __('app.label.resources');
    }

    public static function getModelLabel(): string
    {
        return __('app.label.news_single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.label.news_plural');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::$model::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([

                        Forms\Components\Section::make(__('app.label.files'))
                            ->schema([

                                Forms\Components\TextInput::make('title')
                                    ->label(__('app.label.title'))
                                    ->required(),

                                Forms\Components\RichEditor::make('content')
                                    ->label(__('app.label.content'))
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\SpatieMediaLibraryFileUpload::make('preview_image')
                                    ->collection('preview_image')
                                    ->label(__('app.label.preview_image'))
                                    ->image()
                                    ->downloadable()
                                    ->openable()
                                    ->imageEditor()
                                    ->imageEditorMode(3)
                                    ->acceptedFileTypes(['image/png'])
                                    ->optimize('png')
                                    ->required(),

                                Forms\Components\SpatieMediaLibraryFileUpload::make('main_image')
                                    ->collection('main_image')
                                    ->label(__('app.label.main_image'))
                                    ->image()
                                    ->downloadable()
                                    ->openable()
                                    ->reorderable()
                                    ->imageEditor()
                                    ->imageEditorMode(3)
                                    ->optimize('png')
                                    ->acceptedFileTypes(['image/png']),
                            ]),

                        Forms\Components\Section::make(__('app.label.settings'))
                            ->schema([
                                Forms\Components\TextInput::make('sort')
                                    ->label(__('app.label.sort'))
                                    ->numeric()
                                    ->default(0),

                                Forms\Components\Toggle::make('status')
                                    ->label(__('app.label.status'))
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }
    

  public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([

                Tables\Columns\TextColumn::make('title')
                    ->label(__('app.label.title'))
                    ->sortable()
                    ->wrap()
                    ->searchable(),

                SpatieMediaLibraryImageColumn::make('preview_image')
                    ->collection('preview_image')
                    ->label(__('app.label.preview_image'))
                    ->square()
                    ->height(75),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('app.label.created'))
                    ->dateTime('d.m.Y H:i')
                    ->toggleable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('app.label.status'))
                    ->options(News::statusOptions()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'view' => Pages\ViewNews::route('/{record}'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
