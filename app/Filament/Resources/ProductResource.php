<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Subcategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'catalog';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('app.label.catalog');
    }

    public static function getModelLabel(): string
    {
        return __('app.label.product_single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.label.product_plural');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::$model::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('ProductTabs')
                    ->columnSpanFull()
                    ->tabs([

                        Forms\Components\Tabs\Tab::make(__('app.label.general'))
                            ->schema([

                                Forms\Components\Section::make(__('app.label.general'))
                                    ->schema([

                                        Forms\Components\Grid::make()
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\Section::make()
                                                    ->columnSpan(1)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('name')
                                                            ->label(__('app.label.name'))
                                                            ->required(),

                                                        Forms\Components\TextInput::make('slug')
                                                            ->label(__('app.label.slug'))
                                                            ->helperText(__('app.helper.helper_slug'))
                                                            ->unique(ignoreRecord: true)
                                                            ->maxLength(64)
                                                            ->rule('regex:/^[A-Za-z0-9_-]+$/'),
                                                    ]),

                                                Forms\Components\Section::make()
                                                    ->columnSpan(1)
                                                    ->schema([
                                                        Forms\Components\Select::make('category_id')
                                                            ->label(__('app.label.category'))
                                                            ->options(Category::listOptions())
                                                            ->required()
                                                            ->searchable()
                                                            ->reactive()
                                                            ->afterStateUpdated(fn (callable $set) => $set('subcategory_id', null)),

                                                        Forms\Components\Select::make('subcategory_id')
                                                            ->label(__('app.label.subcategory'))
                                                            ->options(function (callable $get) {
                                                                $categoryId = $get('category_id');
                                                                if (!$categoryId) {
                                                                    return [];
                                                                }

                                                                return Subcategory::query()
                                                                    ->where('category_id', $categoryId)
                                                                    ->where('status', Subcategory::STATUS_ACTIVE)
                                                                    ->pluck('name', 'id')
                                                                    ->toArray();
                                                            })
                                                            ->searchable()
                                                            ->required(),
                                                    ]),
                                            ]),

                                    ])
                                    ->columns(1),

                                Forms\Components\Section::make(__('app.label.prices'))

                                    ->schema([

                                        Forms\Components\Grid::make()
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\Section::make()
                                                    ->columnSpan(1)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('price')
                                                            ->label(__('app.label.price'))
                                                            ->numeric()
                                                            ->required(),

                                                        Forms\Components\TextInput::make('old_price')
                                                            ->label(__('app.label.old_price'))
                                                            ->numeric(),
                                                    ]),

                                                Forms\Components\Section::make()
                                                    ->columnSpan(1)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('sort')
                                                            ->label(__('app.label.sort'))
                                                            ->numeric()
                                                            ->default(0),

                                                        Forms\Components\Toggle::make('status')
                                                            ->label(__('app.label.status'))
                                                            ->default(true),

                                                        Forms\Components\Toggle::make('is_new_collection')
                                                            ->label(__('app.label.is_new'))
                                                            ->default(false),
                                                    ]),
                                            ]),
                                    ])
                                    ->columns(1),
                            ]),

                        // --- Variants (Colors) ---
                        Forms\Components\Tabs\Tab::make(__('app.label.variants'))
                            ->schema([
                                Forms\Components\Repeater::make('variants')
                                    ->label(__('app.label.variants'))
                                    ->relationship('variants')
                                    ->schema([
                                        // Color Info
                                        Forms\Components\Section::make(__('app.label.color_information'))
                                            ->schema([
                                                Forms\Components\Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('color_name')
                                                            ->label(__('app.label.color_name'))
                                                            ->required()
                                                            ->columnSpan(1),

                                                        Forms\Components\ColorPicker::make('color_code')
                                                            ->label(__('app.label.color_code'))
                                                            ->columnSpan(1),

                                                        Forms\Components\TextInput::make('sku')
                                                            ->label(__('app.label.sku'))
                                                            ->helperText(__('app.helper.sku_helper'))
                                                            ->maxLength(64)
                                                            ->columnSpan(1),
                                                    ]),
                                            ]),

                                        // Pricing
                                        Forms\Components\Section::make(__('app.label.pricing'))
                                            ->schema([
                                                Forms\Components\Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('price')
                                                            ->label(__('app.label.price'))
                                                            ->numeric()
                                                            ->helperText(__('app.helper.price_helper'))
                                                            ->columnSpan(1),

                                                        Forms\Components\TextInput::make('old_price')
                                                            ->label(__('app.label.old_price'))
                                                            ->numeric()
                                                            ->columnSpan(1),
                                                    ]),
                                            ])
                                            ->collapsible(),

                                        // Materials
                                        Forms\Components\Section::make(__('app.label.materials'))
                                            ->schema([
                                                Forms\Components\Select::make('materials')
                                                    ->label(__('app.label.materials'))
                                                    ->relationship('materials', 'name')
                                                    ->multiple()
                                                    ->preload()
                                                    ->searchable()
                                                    ->helperText(__('app.helper.materials_helper')),
                                            ])
                                            ->collapsible(),

                                        // Image
                                        Forms\Components\Section::make(__('app.label.main_image'))
                                            ->schema([
                                                Forms\Components\SpatieMediaLibraryFileUpload::make('variant_image')
                                                    ->collection('variant_image')
                                                    ->label(__('app.label.variant_image'))
                                                    ->helperText(__('app.helper.variant_image_helper'))
                                                    ->image()
                                                    ->downloadable()
                                                    ->openable()
                                                    ->imageEditor()
                                                    ->imageEditorMode(3)
                                                    ->acceptedFileTypes(['image/png', 'image/jpeg'])
                                                    ->required(),
                                            ])
                                            ->collapsible(),

                                        // Sizes with Stock
                                        Forms\Components\Section::make(__('app.label.sizes_stock'))
                                            ->schema([
                                                Forms\Components\Repeater::make('sizes')
                                                    ->label(__('app.label.sizes'))
                                                    ->relationship('sizes')
                                                    ->schema([
                                                        Forms\Components\Grid::make(4)
                                                            ->schema([
                                                                Forms\Components\Select::make('size_id')
                                                                    ->label(__('app.label.size'))
                                                                    ->options(\App\Models\ProductSize::pluck('name', 'id'))
                                                                    ->searchable()
                                                                    ->required()
                                                                    ->columnSpan(1),

                                                                Forms\Components\TextInput::make('stock')
                                                                    ->label(__('app.label.stock'))
                                                                    ->numeric()
                                                                    ->default(0)
                                                                    ->minValue(0)
                                                                    ->required()
                                                                    ->columnSpan(1),

                                                                Forms\Components\TextInput::make('dimensions')
                                                                    ->label(__('app.label.dimensions'))
                                                                    ->helperText(__('app.helper.dimensions_helper'))
                                                                    ->maxLength(128)
                                                                    ->columnSpan(1),

                                                                Forms\Components\Toggle::make('status')
                                                                    ->label(__('app.label.status'))
                                                                    ->default(true)
                                                                    ->columnSpan(1),
                                                            ]),
                                                    ])
                                                    ->defaultItems(0)
                                                    ->addActionLabel(__('app.helper.add_size'))
                                                    ->collapsible()
                                                    ->itemLabel(fn (array $state): ?string =>
                                                        isset($state['size_id'])
                                                            ? \App\Models\ProductSize::find($state['size_id'])?->name . ' (' . __('app.label.stock') . ': ' . ($state['stock'] ?? 0) . ')'
                                                            : __('app.helper.new_size')
                                                    ),
                                            ])
                                            ->collapsible(),

                                        // Status & Sort
                                        Forms\Components\Section::make(__('app.label.settings'))
                                            ->schema([
                                                Forms\Components\Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\Toggle::make('status')
                                                            ->label(__('app.label.status'))
                                                            ->default(true)
                                                            ->columnSpan(1),

                                                        Forms\Components\TextInput::make('sort')
                                                            ->label(__('app.label.sort'))
                                                            ->numeric()
                                                            ->default(0)
                                                            ->columnSpan(1),
                                                    ]),
                                            ])
                                            ->collapsible()
                                            ->collapsed(),
                                    ])
                                    ->defaultItems(0)
                                    ->addActionLabel(__('app.helper.add_color_variant'))
                                    ->orderable('sort')
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['color_name'] ?? __('app.helper.new_variant'))
                                    ->columnSpanFull(),
                            ]),

                        // --- Тексты ---
                        Forms\Components\Tabs\Tab::make(__('app.label.texts'))
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->label(__('app.label.description'))
                                    ->disableToolbarButtons(['attachFiles'])
                                    ->columnSpanFull(),

                                Forms\Components\RichEditor::make('material_description')
                                    ->label(__('app.label.material_description'))
                                    ->disableToolbarButtons(['attachFiles'])
                                    ->columnSpanFull(),

                                Forms\Components\RichEditor::make('care_description')
                                    ->label(__('app.label.care_description'))
                                    ->disableToolbarButtons(['attachFiles'])
                                    ->columnSpanFull(),

                                Forms\Components\RichEditor::make('delivery_description')
                                    ->label(__('app.label.delivery_description'))
                                    ->disableToolbarButtons(['attachFiles'])
                                    ->columnSpanFull(),

                                Forms\Components\RichEditor::make('capacity_description')
                                    ->label(__('app.label.capacity_description'))
                                    ->disableToolbarButtons(['attachFiles'])
                                    ->columnSpanFull(),

                            ]),

                        // --- Изображения ---
                        Forms\Components\Tabs\Tab::make(__('app.label.images'))
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('preview_image')
                                    ->collection('preview_image')
                                    ->label(__('app.label.preview_image'))
                                    ->helperText(__('app.helper.preview_image_helper'))
                                    ->image()
                                    ->downloadable()
                                    ->openable()
                                    ->imageEditor()
                                    ->imageEditorMode(3)
                                    ->acceptedFileTypes(['image/png'])
                                    ->optimize('png')
                                    ->required(),

                                Forms\Components\SpatieMediaLibraryFileUpload::make('hover_image')
                                    ->collection('hover_image')
                                    ->label(__('app.label.hover_image'))
                                    ->helperText(__('app.helper.hover_image_helper'))
                                    ->image()
                                    ->downloadable()
                                    ->openable()
                                    ->imageEditor()
                                    ->imageEditorMode(3)
                                    ->acceptedFileTypes(['image/png'])
                                    ->optimize('png'),

                                Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                                    ->collection('gallery')
                                    ->label(__('app.label.gallery'))
                                    ->image()
                                    ->multiple()
                                    ->downloadable()
                                    ->openable()
                                    ->reorderable()
                                    ->imageEditor()
                                    ->imageEditorMode(3)
                                    ->optimize('png')
                                    ->acceptedFileTypes(['image/png']),
                            ]),

                        Forms\Components\Tabs\Tab::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->label(__('app.label.meta_title'))
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('meta_description')
                                    ->label(__('app.label.meta_description'))
                                    ->rows(3),
                            ]),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([

                SpatieMediaLibraryImageColumn::make('preview_image')
                    ->collection('preview_image')
                    ->label(__('app.label.preview_image'))
                    ->square()
                    ->height(60),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('app.label.name'))
                    ->sortable()
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('app.label.category'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('subcategory.name')
                    ->label(__('app.label.subcategory'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('price')
                    ->label(__('app.label.price'))
                    ->money('UZS', locale: 'uz_UZ')
                    ->sortable(),

                Tables\Columns\TextColumn::make('variants_count')
                    ->label(__('app.label.variants'))
                    ->counts('variants')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('variants.sizes_sum_stock')
                    ->label(__('app.label.total_stock'))
                    ->sum('variants.sizes', 'stock')
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_new_collection')
                    ->label(__('app.label.is_new'))
                    ->boolean()
                    ->toggleable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('status')
                    ->label(__('app.label.status'))
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('sort')
                    ->label(__('app.label.sort'))
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('app.label.updated'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('app.label.created'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('app.label.status'))
                    ->options(Product::statusOptions()),

                SelectFilter::make('category_id')
                    ->label(__('app.label.category'))
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('subcategory_id')
                    ->label(__('app.label.subcategory'))
                    ->relationship('subcategory', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('is_new_collection')
                    ->label(__('app.label.is_new'))
                    ->options([
                        1 => __('app.status.active'),
                        0 => __('app.status.inactive'),
                    ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
