<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Customer Engagement';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = "Reservations/Orders";

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Reservation Details')
                    ->collapsible()
                    ->compact()
                    ->icon('heroicon-m-calendar-days')
                    ->iconColor('primary')
                    ->description('Fill in the details of the reservation, including date, time, and number of guests.')
                    ->extraAttributes(['class' => '!bg-blue-300/20 dark:!bg-blue-400/5'])
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->inlineLabel()
                            ->prefixIcon('heroicon-m-user')
                            ->prefixIconColor('primary')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter full name'),
                        Forms\Components\TextInput::make('email')
                            ->inlineLabel()
                            ->prefixIcon('heroicon-m-at-symbol')
                            ->prefixIconColor('primary')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter email address'),
                        Forms\Components\TextInput::make('phone')
                            ->inlineLabel()
                            ->prefixIcon('heroicon-m-phone')
                            ->prefixIconColor('primary')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                            ->required()
                            ->placeholder('Enter phone number with country code'),
                        Forms\Components\DatePicker::make('date')
                            ->inlineLabel()
                            ->label('Reservation Date')
                            ->prefixIcon('heroicon-m-calendar')
                            ->prefixIconColor('primary')
                            ->required()
                            ->native(true)
                            ->minDate(today())
                            ->placeholder('Pick a reservation date'),
                        Forms\Components\TimePicker::make('time')
                            ->inlineLabel()
                            ->label('Reservation Time')
                            ->prefixIcon('heroicon-m-clock')
                            ->prefixIconColor('primary')
                            ->required()
                            ->native(true)
                            ->placeholder('Select reservation time'),
                        Forms\Components\TextInput::make('persons')
                            ->inlineLabel()
                            ->label('Number of Guests')
                            ->prefixIcon('heroicon-m-users')
                            ->prefixIconColor('primary')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxLength(3)
                            ->placeholder('Enter number of guests'),
                    ]),

                Forms\Components\Section::make('Special Instructions')
                    ->collapsible()
                    ->compact()
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->iconColor('secondary')
                    ->description('Add any specific instructions or comments for the reservation.')
                    ->extraAttributes(['class' => '!bg-slate-300/40 dark:!bg-slate-500/10'])
                    ->schema([
                        Forms\Components\Textarea::make('comments')
                            ->inlineLabel()
                            ->label('Additional Comments')
                            ->rows(3)
                            ->placeholder('Enter any special instructions or comments'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('date', 'desc')
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Phone number copied')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('date')
                    ->label('Reservation Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')
                    ->time('h:m a'),
                Tables\Columns\TextColumn::make('persons')
                    ->badge(),
                Tables\Columns\TextColumn::make('comments')
                    ->label('Instructions'),
                Tables\Columns\TextColumn::make('created_at')
                    ->icon('heroicon-m-calendar')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime('M d, Y h:i a'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->icon('heroicon-m-calendar-days')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime('M d, Y h:i a'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button()
                    ->size(ActionSize::ExtraSmall),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->size(ActionSize::ExtraSmall),
                Tables\Actions\RestoreAction::make()
                    ->button()
                    ->size(ActionSize::ExtraSmall),
                Tables\Actions\ForceDeleteAction::make()
                    ->button()
                    ->size(ActionSize::ExtraSmall),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
