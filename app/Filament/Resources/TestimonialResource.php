<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $modelLabel = 'отзыв';

    protected static ?string $pluralModelLabel = 'отзывы';

    protected static ?string $navigationLabel = 'Отзывы';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Отзыв')
                    ->schema([
                        Forms\Components\TextInput::make('author')
                            ->label('Имя клиента')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('position')
                            ->label('Должность')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('company')
                            ->label('Компания')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('project')
                            ->label('Проект')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('body')
                            ->label('Текст отзыва')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Section::make('Публикация')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Опубликован')
                            ->default(true),
                        Forms\Components\Toggle::make('is_placeholder')
                            ->label('Заглушка')
                            ->helperText('Показывается как «Место для отзыва». Снимите, когда добавите настоящий отзыв.'),
                        Forms\Components\TextInput::make('sort')
                            ->label('Порядок')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')
            ->reorderable('sort')
            ->columns([
                Tables\Columns\TextColumn::make('author')
                    ->label('Клиент')
                    ->description(fn (Testimonial $record): string => $record->role())
                    ->searchable(),
                Tables\Columns\TextColumn::make('body')
                    ->label('Отзыв')
                    ->limit(70),
                Tables\Columns\IconColumn::make('is_placeholder')
                    ->label('Заглушка')
                    ->boolean(),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Опубликован'),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
