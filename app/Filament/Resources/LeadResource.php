<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $modelLabel = 'заявка';

    protected static ?string $pluralModelLabel = 'заявки';

    protected static ?string $navigationLabel = 'Заявки';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = Lead::where('status', 'new')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Заявка')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Имя')
                            ->required()
                            ->maxLength(120),
                        Forms\Components\TextInput::make('contact')
                            ->label('Контакт')
                            ->required()
                            ->maxLength(190),
                        Forms\Components\Select::make('project_type')
                            ->label('Тип проекта')
                            ->options(config('studio.project_types')),
                        Forms\Components\Textarea::make('message')
                            ->label('Описание задачи')
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Section::make('Обработка')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Статус')
                            ->options(Lead::STATUSES)
                            ->required()
                            ->native(false),
                        Forms\Components\Textarea::make('note')
                            ->label('Комментарий менеджера')
                            ->rows(4),
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Получена')
                            ->content(fn (?Lead $record): string => $record?->created_at?->format('d.m.Y H:i') ?? '—'),
                        Forms\Components\Placeholder::make('source')
                            ->label('Страница')
                            ->content(fn (?Lead $record): string => $record?->source ?: '—'),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact')
                    ->label('Контакт')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('project_type')
                    ->label('Тип проекта')
                    ->formatStateUsing(fn (string $state): string => config("studio.project_types.{$state}", $state))
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('message')
                    ->label('Задача')
                    ->limit(60)
                    ->toggleable(),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Статус')
                    ->options(Lead::STATUSES)
                    ->selectablePlaceholder(false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(Lead::STATUSES),
                Tables\Filters\SelectFilter::make('project_type')
                    ->label('Тип проекта')
                    ->options(config('studio.project_types')),
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
            'index' => Pages\ListLeads::route('/'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
