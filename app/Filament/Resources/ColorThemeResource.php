<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ColorThemeResource\Pages;
use App\Models\ColorTheme;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class ColorThemeResource extends Resource
{
    protected static ?string $model = ColorTheme::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'Website Design Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(['sm' => 2])
            ->schema([
                Forms\Components\Section::make('General Information')
                    ->compact()
                    ->collapsible()
                    ->extraAttributes(['class' => '!bg-blue-300/20 dark:!bg-blue-400/5'])
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(['sm' => 2])
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Theme Name')
                                    ->placeholder('Enter theme name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('active')
                                    ->label('Active')
                                    ->inline(false)
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-o-check')
                                    ->offIcon('heroicon-o-x-mark')
                                    ->live()
                                    ->afterStateHydrated(function (?string $state, Forms\Set $set, ?Model $record) {
                                        // Get the currently active theme
                                        $activeTheme = static::getModel()::whereActive(true)->first();
                                        if (static::getModel()::count() === 1 && !$state && $activeTheme->id === $record?->id || $activeTheme === null) {
                                            $set('active', true);
                                        }
                                    })
                                    ->afterStateUpdated(function (?string $old, Forms\Set $set, ?Model $record) {
                                        // Get the currently active theme
                                        $activeTheme = static::getModel()::whereActive(true)->first();

                                        if (static::getModel()::count() === 1 && $old && $activeTheme->id === $record?->id || $activeTheme === null) {
                                            $set('active', true);
                                            Notification::make()
                                                ->title('Action Denied')
                                                ->body('This theme cannot be deactivated because at least one active theme is required.')
                                                ->danger()
                                                ->persistent()
                                                ->send();
                                        }
                                    })
                                    ->helperText('Activate this theme (only one can be active at a time).'),
                            ]),
                    ]),

                // ------------------- Group 1: Theme Colors ----------------------
                Forms\Components\Section::make('Theme Colors')
                    ->description('Warm, appetizing, and energetic colors for themes')
                    ->icon('heroicon-o-pencil')
                    ->iconColor(Color::Orange)
                    ->extraAttributes(['class' => '!bg-orange-300/20 dark:!bg-orange-400/5'])
                    ->collapsible()
                    ->compact()
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(['sm' => 2])
                            ->schema([
                                Forms\Components\ColorPicker::make('theme_1')
                                    ->label('Primary Theme Color')
                                    ->placeholder('Warm orange (hunger, excitement)')
                                    ->default('#FF6F00'),

                                Forms\Components\ColorPicker::make('theme_2')
                                    ->label('Secondary Theme Color')
                                    ->placeholder('Deep red (appetite, energy)')
                                    ->default('#C62828'),

                                Forms\Components\ColorPicker::make('theme_3')
                                    ->label('Tertiary Theme Color')
                                    ->placeholder('Fresh green (natural, healthy)')
                                    ->default('#4CAF50'),

                                Forms\Components\ColorPicker::make('theme_4')
                                    ->label('Quaternary Theme Color')
                                    ->placeholder('Bright yellow (optimism, happiness)')
                                    ->default('#FFD600'),
                            ]),
                    ]),

                // ------------------- Group 2: Light Theme Colors ----------------------
                Forms\Components\Section::make('Light Theme Colors')
                    ->description('Lighter shades for light themes')
                    ->icon('heroicon-o-sun')
                    ->iconColor(Color::Yellow)
                    ->extraAttributes(['class' => '!bg-yellow-300/20 dark:!bg-yellow-400/5'])
                    ->collapsible()
                    ->compact()
                    ->columnSpan(['sm' => 1])
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\ColorPicker::make('light_1')
                                    ->label('Light Primary Theme Color')
                                    ->placeholder('Light orange')
                                    ->default('#FFAB40'),

                                Forms\Components\ColorPicker::make('light_2')
                                    ->label('Light Secondary Theme Color')
                                    ->placeholder('Light red')
                                    ->default('#FF8A80'),

                                Forms\Components\ColorPicker::make('light_3')
                                    ->label('Light Tertiary Theme Color')
                                    ->placeholder('Light green')
                                    ->default('#81C784'),

                                Forms\Components\ColorPicker::make('light_4')
                                    ->label('Light Quaternary Theme Color')
                                    ->placeholder('Light yellow')
                                    ->default('#FFF59D'),
                            ]),
                    ]),

                // ------------------- Group 3: Dark Theme Colors ----------------------
                Forms\Components\Section::make('Dark Theme Colors')
                    ->description('Darker shades for dark themes')
                    ->icon('heroicon-o-moon')
                    ->iconColor(Color::Gray)
                    ->extraAttributes(['class' => '!bg-gray-400/30 dark:!bg-gray-400/5'])
                    ->collapsible()
                    ->compact()
                    ->columnSpan(['sm' => 1])
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\ColorPicker::make('dark_1')
                                    ->label('Dark Primary Theme Color')
                                    ->placeholder('Dark orange')
                                    ->default('#E65100'),

                                Forms\Components\ColorPicker::make('dark_2')
                                    ->label('Dark Secondary Theme Color')
                                    ->placeholder('Dark red')
                                    ->default('#B71C1C'),

                                Forms\Components\ColorPicker::make('dark_3')
                                    ->label('Dark Tertiary Theme Color')
                                    ->placeholder('Dark green')
                                    ->default('#388E3C'),

                                Forms\Components\ColorPicker::make('dark_4')
                                    ->label('Dark Quaternary Theme Color')
                                    ->placeholder('Dark yellow')
                                    ->default('#F9A825'),
                            ]),
                    ]),

                // ------------------- Group 4: Marquee Colors ----------------------
                Forms\Components\Section::make('Marquee Colors')
                    ->description('Vibrant, bold colors to grab attention')
                    ->icon('heroicon-o-exclamation-circle')
                    ->iconColor(Color::Pink)
                    ->extraAttributes(['class' => '!bg-pink-300/20 dark:!bg-pink-400/5'])
                    ->collapsible()
                    ->compact()
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(['sm' => 2])
                            ->schema([
                                Forms\Components\ColorPicker::make('marquee_1')
                                    ->label('Primary Marquee Color')
                                    ->placeholder('Bright pink (playful, bold)')
                                    ->default('#D81B60'),

                                Forms\Components\ColorPicker::make('marquee_2')
                                    ->label('Secondary Marquee Color')
                                    ->placeholder('Rich purple (luxury, creativity)')
                                    ->default('#8E24AA'),
                            ]),
                    ]),

                // ------------------- Group 5: Text Colors ----------------------
                Forms\Components\Section::make('Text Colors')
                    ->description('Contrasting colors for text readability')
                    ->icon('heroicon-o-pencil')
                    ->iconColor(Color::Slate)
                    ->extraAttributes(['class' => '!bg-slate-300/40 dark:!bg-slate-500/10'])
                    ->collapsible()
                    ->compact()
                    ->columnSpan(['sm' => 1])
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(['md' => 2])
                            ->schema([
                                Forms\Components\ColorPicker::make('text_white')
                                    ->label('White Text Color')
                                    ->placeholder('Pure white (clarity, simplicity)')
                                    ->default('#FFFFFF'),

                                Forms\Components\ColorPicker::make('text_black')
                                    ->label('Black Text Color')
                                    ->placeholder('Deep black (formal, strong)')
                                    ->default('#000000'),
                            ]),
                    ]),

                // ------------------- Group 6: Background Colors ----------------------
                Forms\Components\Section::make('Background Colors')
                    ->description('Neutral and clean background colors')
                    ->icon('heroicon-o-computer-desktop')
                    ->iconColor(Color::Green)
                    ->extraAttributes(['class' => '!bg-green-300/20 dark:!bg-green-400/5'])
                    ->collapsible()
                    ->compact()
                    ->columnSpan(['sm' => 1])
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(['md' => 2])
                            ->schema([
                                Forms\Components\ColorPicker::make('bg_white')
                                    ->label('White BG Color')
                                    ->placeholder('Clean white (openness)')
                                    ->default('#FFFFFF'),

                                Forms\Components\ColorPicker::make('bg_black')
                                    ->label('Black BG Color')
                                    ->placeholder('Soft black (modern, professional)')
                                    ->default('#212121'),
                            ]),
                    ]),

                // ------------------- Group 7: Neutral Colors ----------------------
                Forms\Components\Section::make('Neutral Colors')
                    ->description('Subtle, neutral tones for UI elements')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->iconColor(Color::Slate)
                    ->extraAttributes(['class' => '!bg-gray-300/40 dark:!bg-gray-500/10'])
                    ->collapsible()
                    ->compact()
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(['default' => 2, 'lg' => 3])
                            ->schema([
                                Forms\Components\ColorPicker::make('neutral_white')
                                    ->label('Neutral White')
                                    ->placeholder('Clean white')
                                    ->default('#FFFFFF'),

                                Forms\Components\ColorPicker::make('neutral_black')
                                    ->label('Neutral Black')
                                    ->placeholder('Deep black')
                                    ->default('#000000'),

                                Forms\Components\ColorPicker::make('neutral_gray')
                                    ->label('Neutral Gray')
                                    ->placeholder('Neutral gray (balance)')
                                    ->default('#9E9E9E'),

                                Forms\Components\ColorPicker::make('neutral_light_gray')
                                    ->label('Light Gray')
                                    ->placeholder('Light gray (soft, subtle)')
                                    ->default('#F5F5F5'),

                                Forms\Components\ColorPicker::make('neutral_x_light_gray')
                                    ->label('Extra Light Gray')
                                    ->placeholder('Extra light gray')
                                    ->default('#FAFAFA'),

                                Forms\Components\ColorPicker::make('neutral_dark_gray')
                                    ->label('Dark Gray')
                                    ->placeholder('Dark gray (modern, grounded)')
                                    ->default('#616161'),
                            ]),
                    ]),

                // Contribution Log
                Forms\Components\Section::make('Contribution Log')
                    ->hiddenOn('create')
                    ->columns(['lg' => 4])
                    ->collapsible()
                    ->collapsed()
                    ->compact()
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Placeholder::make('Updated By')
                            ->content(fn(ColorTheme $record): string => ucwords($record->updater->name)),
                        Forms\Components\Placeholder::make('Updated At')
                            ->content(fn(ColorTheme $record): string => $record->updated_at->diffForHumans())
                            ->hintIcon('heroicon-o-question-mark-circle')
                            ->hintIconTooltip(fn(ColorTheme $record): string => $record->updated_at->format('M d, Y h:i a')),
                        Forms\Components\Placeholder::make('Created By')
                            ->content(fn(ColorTheme $record): string => ucwords($record->creator->name)),
                        Forms\Components\Placeholder::make('Created At')
                            ->content(fn(ColorTheme $record): string => $record->created_at->toFormattedDateString())
                            ->hintIcon('heroicon-o-information-circle')
                            ->hintIconTooltip(fn(ColorTheme $record): string => $record->created_at->format('M d, Y h:i a')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->deferLoading()
            ->recordClasses(fn(Model $record) => match ($record->active) {
                false => 'opacity-30',
                true => 'border-s-2 border-green-600 dark:border-green-300',
                default => null,
            })
            ->reorderable('order_column')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->formatStateUsing(fn($state) => ucwords($state))
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->disabled(fn($state) => static::getModel()::count() === 1 && $state || $state),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),

                // Group 1: Theme Colors
                Tables\Columns\ColorColumn::make('theme_1')
                    ->label('Primary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('theme_2')
                    ->label('Secondary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('theme_3')
                    ->label('Tertiary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('theme_4')
                    ->label('Quaternary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                // Group 2: Light Theme Colors
                Tables\Columns\ColorColumn::make('light_1')
                    ->label('Light Primary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('light_2')
                    ->label('Light Secondary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('light_3')
                    ->label('Light Tertiary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('light_4')
                    ->label('Light Quaternary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                // Group 3: Dark Theme Colors
                Tables\Columns\ColorColumn::make('dark_1')
                    ->label('Dark Primary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('dark_2')
                    ->label('Dark Secondary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('dark_3')
                    ->label('Dark Tertiary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('dark_4')
                    ->label('Dark Quaternary Theme Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                // Group 4: Marquee Colors
                Tables\Columns\ColorColumn::make('marquee_1')
                    ->label('Primary Marquee Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('marquee_2')
                    ->label('Secondary Marquee Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                // Group 5: Text Colors
                Tables\Columns\ColorColumn::make('text_white')
                    ->label('White Text Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('text_black')
                    ->label('Black Text Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                // Group 6: Background Colors
                Tables\Columns\ColorColumn::make('bg_white')
                    ->label('White BG Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('bg_black')
                    ->label('Black BG Color')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                // Group 7: Neutral Colors
                Tables\Columns\ColorColumn::make('neutral_white')
                    ->label('Neutral White')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('neutral_black')
                    ->label('Neutral Black')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('neutral_gray')
                    ->label('Neutral Gray')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('neutral_light_gray')
                    ->label('Light Gray')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('neutral_x_light_gray')
                    ->label('Extra Light Gray')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\ColorColumn::make('neutral_dark_gray')
                    ->label('Dark Gray')
                    ->tooltip(fn(?string $state) => "Click to copy: {$state}")
                    ->alignCenter()
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('updater.name')
                    ->icon('heroicon-m-user')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('creator.name')
                    ->icon('heroicon-m-user')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\Filter::make('active')
                    ->query(fn(Builder $query) => $query->where('active', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button()
                    ->size(ActionSize::ExtraSmall),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->size(ActionSize::ExtraSmall),
                Tables\Actions\ReplicateAction::make()
                    ->excludeAttributes(['type'])
                    ->beforeReplicaSaved(function (Model $replica): void {
                        // Runs after the replica has been replicated but before it is saved to the database.
                        $replica->name = $replica->name . " Copied-" . date('dmyhims');
                        $replica->active = true;
                        $replica->updated_by_user_id = auth()->id();
                        $replica->created_by_user_id = auth()->id();
                    })
                    ->label('Copy Theme')
                    ->color('warning')
                    ->button()
                    ->requiresConfirmation()
                    ->modalIcon('heroicon-o-swatch')
                    ->modalHeading(function (Model $record) {
                        return new HtmlString("Copy <b>" . ucwords($record->name) . "</b>");
                    })
                    ->successNotification(
                        Notification::make()
                            ->title('Theme Copied!')
                            ->success()
                            ->body('You can now modify the colors and activate the theme to personalize your website.')
                    )
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
            'index' => Pages\ListColorThemes::route('/'),
            'create' => Pages\CreateColorTheme::route('/create'),
            'edit' => Pages\EditColorTheme::route('/{record}/edit'),
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
