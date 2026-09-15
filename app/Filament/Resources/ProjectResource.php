<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'проект';

    protected static ?string $pluralModelLabel = 'портфолио';

    protected static ?string $navigationLabel = 'Портфолио';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Проект')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Название')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $operation, ?string $state, Forms\Set $set) {
                                    if ($operation === 'create') {
                                        $set('slug', Str::slug((string) $state));
                                    }
                                })
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('slug')
                                ->label('Адрес страницы')
                                ->prefix('/work/')
                                ->required()
                                ->alphaDash()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),
                            Forms\Components\TextInput::make('category')
                                ->label('Категория')
                                ->required()
                                ->maxLength(255)
                                ->datalist(array_values(config('studio.project_types'))),
                            Forms\Components\Textarea::make('excerpt')
                                ->label('Краткое описание')
                                ->required()
                                ->maxLength(300)
                                ->rows(2)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Forms\Components\Section::make('Кейс')
                        ->description('Показывается на странице проекта. Пустые блоки скрываются.')
                        ->schema([
                            Forms\Components\Textarea::make('task')->label('Задача')->rows(3),
                            Forms\Components\Textarea::make('solution')->label('Решение')->rows(3),
                            Forms\Components\Textarea::make('result')->label('Результат')->rows(3),
                        ]),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make([
                    Forms\Components\Section::make('Публикация')
                        ->schema([
                            Forms\Components\Toggle::make('is_published')
                                ->label('Опубликован')
                                ->default(true),
                            Forms\Components\Toggle::make('is_concept')
                                ->label('Концепт')
                                ->helperText('Отметка «Концепт» на сайте — для демонстрационных работ.'),
                            Forms\Components\TextInput::make('sort')
                                ->label('Порядок')
                                ->numeric()
                                ->default(0),
                            Forms\Components\TextInput::make('url')
                                ->label('Ссылка на проект')
                                ->url()
                                ->maxLength(255),
                        ]),

                    Forms\Components\Section::make('Обложка')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->hiddenLabel()
                                ->image()
                                ->disk('public')
                                ->directory('projects')
                                ->visibility('public')
                                ->maxSize(4096)
                                ->helperText('Рекомендуемый размер — 1600×1200 (4:3), WebP или JPG.'),
                        ]),

                    Forms\Components\Section::make('Теги')
                        ->schema([
                            Forms\Components\TagsInput::make('tags')->hiddenLabel(),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')
            ->reorderable('sort')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('')
                    ->disk('public')
                    ->width(96)
                    ->height(72),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->description(fn (Project $record): string => $record->category)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_concept')
                    ->label('Концепт')
                    ->boolean(),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Опубликован'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Изменён')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->label('На сайте')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Project $record): string => route('projects.show', $record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
