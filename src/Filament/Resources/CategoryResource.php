<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages\CreateCategory;
use LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages\EditCategory;
use LaraZeus\Bolt\Filament\Resources\CategoryResource\Pages\ListCategories;

class CategoryResource extends BoltResource
{
    public static function getModel(): string
    {
        return config('zeus-bolt.models.Category');
    }

    protected static ?string $navigationIcon = 'clarity-tags-line';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->label(__('Name'))
                    ->afterStateUpdated(function (Closure $set, $state, $context) {
                        if ($context === 'edit') {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')->required()->maxLength(255)->label(__('slug')),
                TextInput::make('ordering')->required()->numeric()->label(__('ordering')),
                Toggle::make('is_active')->label(__('Is Active'))->default(1),
                Textarea::make('description')->maxLength(65535)->columnSpan(['sm' => 2])->label(__('Description')),
                FileUpload::make('logo')
                    ->disk(config('zeus-bolt.uploads.disk', 'public'))
                    ->directory(config('zeus-bolt.uploads.dir', 'logos'))
                    ->columnSpan(['sm' => 2])
                    ->label(__('logo')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->disk(config('zeus-bolt.uploads.disk', 'public'))
                    ->toggleable()
                    ->label(__('Logo')),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('forms_count')
                    ->counts('forms')
                    ->label(__('Forms'))
                    ->toggleable()
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->toggleable()
                    ->label(__('Is Active')),
            ])
            ->reorderable('ordering')
            ->defaultSort('id', 'description')
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    ForceDeleteAction::make(),
                    RestoreAction::make(),
                ]),
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make('is_active')
                    ->label(__('is active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                Filter::make('not_active')
                    ->label(__('not active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false)),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('Category');
    }

    public static function getPluralLabel(): string
    {
        return __('Categories');
    }

    protected static function getNavigationLabel(): string
    {
        return __('Categories');
    }
}
