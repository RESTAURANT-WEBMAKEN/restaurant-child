<?php

namespace App\Filament\Pages;

use App\Models\RollingMessage;
use App\Traits\FilamentCustomPageAuthorization;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;

class RollingMessagePage extends Page
{
    use FilamentCustomPageAuthorization;
    protected static ?string $model = RollingMessage::class;
    protected static string $view = 'filament.pages.rolling-message-page';
    protected static ?string $navigationIcon = 'heroicon-o-tv';
    protected static ?string $navigationGroup = 'Restaurant Information';
    protected static ?int $navigationSort = 3;
    protected static ?string $slug = 'rolling-message';
    protected static ?string $title = 'Rolling Message';
    public ?RollingMessage $record;
    public ?array $data = [];

    public function getSubheading(): string
    {
        return __('Set dynamic messages to display on the website, such as announcements or opening hours.');
    }

    public function mount()
    {
        $this->record = RollingMessage::first();
        $this->data = $this->record?->toArray();

        if ($this->record && $this->record->active_marquee_no > 0) {
            $this->data['marquee_1_status'] = $this->record->active_marquee_no == 1;
            $this->data['marquee_2_status'] = $this->record->active_marquee_no == 2;
            $this->data['marquee_3_status'] = $this->record->active_marquee_no == 3;

            $activeMarqueeColName = "marquee_{$this->record->active_marquee_no}";
            $this->data['active_marquee'] = $this->record->$activeMarqueeColName;
        }

        $this->form->fill($this->data);
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->getFormActions()['store'],
        ];

    }

    protected function getFormActions(): array
    {
        return [
            'store' => Actions\Action::make('saveRecord')
                ->label('Save Changes')
                ->authorize(empty($this->record) ? static::canCreate(): static::canEdit($this->record))
                ->formId('rolling_message')
                ->extraAttributes(['type' => 'submit'])
                ->action('save'),
        ];
    }

    public function save()
    {
        $existingData = RollingMessage::first();
        $data = $this->form->getState();

        if ($existingData) {
            $data['updated_by_user_id'] = auth()->id();

            $existingData->update($data);

            // Fetch the updated instance
            $this->record = $existingData->fresh();
        } else {
            $data['updated_by_user_id'] = auth()->id();
            $data['created_by_user_id'] = auth()->id();
            $this->record = RollingMessage::create($data);
        }

        Notification::make('save_record')
            ->title('Success!')
            ->body('Rolling Message Saved Successfully!')
            ->success()
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->model(static::getModel())
            ->schema([
                Forms\Components\ToggleButtons::make('marquee_status')
                    ->label('Visibility')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->inline()
                    ->default(false)
                    ->boolean()
                    ->required()
                    ->options([
                        1 => 'Show Rolling Message',
                        0 => 'Hide Rolling Message',
                    ])
                    ->icons([
                        1 => 'heroicon-m-eye',
                        0 => 'heroicon-m-eye-slash',
                    ]),
                Forms\Components\Hidden::make('active_marquee_no')
                    ->default(0),
                Forms\Components\Section::make()
                    ->compact()
                    ->columns(['sm' => 12])
                    ->extraAttributes(['class' => '!bg-green-300/20 dark:!bg-green-400/5 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                    ->schema([
                        Forms\Components\TextInput::make('active_marquee')
                            ->label('Active Rolling Message')
                            ->inlineLabel()
                            ->placeholder('No active rolling message. Click the toggle button to activate one.')
                            ->prefixIcon('heroicon-m-sparkles')
                            ->prefixIconColor('success')
                            ->columnSpanFull()
                            ->requiredIfAccepted('marquee_status')
                            ->readOnly()
                            ->dehydrated(false),
                    ]),
                Forms\Components\Section::make()
                    ->compact()
                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-blue-950/20 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                    ->columns(['sm' => 12])
                    ->schema([
                        Forms\Components\TextInput::make('marquee_1')
                            ->label('Rolling Message 1')
                            ->columnSpan(['sm' => 9, 'md' => 10])
                            ->inlineLabel()
                            ->placeholder('Enter message')
                            ->prefixIcon('heroicon-m-chat-bubble-bottom-center-text')
                            ->helperText(new HtmlString('This is the <b>DEFAULT ROLLING MESSAGE</b>'))
                            ->prefixIconColor('primary')
                            ->live(onBlur: true)
                            ->requiredIfAccepted('marquee_1_status'),
                        Forms\Components\Toggle::make('marquee_1_status')
                            ->label('Active')
                            ->inlineLabel()
                            ->columnSpan(['sm' => 3, 'md' => 2])
                            ->onIcon('heroicon-m-eye')
                            ->offIcon('heroicon-m-eye-slash')
                            ->onColor('success')
                            ->offColor('danger')
                            ->disabled(fn(Forms\Get $get): bool => empty($get('marquee_1')))
                            ->dehydrated(false)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $state) {
                                if ($state == 1) {
                                    $set('marquee_2_status', false);
                                    $set('marquee_3_status', false);
                                    $set('active_marquee', $get('marquee_1'));
                                    $set('active_marquee_no', 1);
                                }

                                $allMessagesInactive = !$get('marquee_1_status')
                                && !$get('marquee_2_status')
                                && !$get('marquee_3_status');

                                if ($allMessagesInactive) {
                                    $set('active_marquee', null);
                                    $set('active_marquee_no', 0);
                                }
                            }),
                        Forms\Components\TextInput::make('marquee_2')
                            ->label('Rolling Message 2')
                            ->columnSpan(['sm' => 9, 'md' => 10])
                            ->inlineLabel()
                            ->placeholder('Enter message')
                            ->prefixIcon('heroicon-m-chat-bubble-bottom-center-text')
                            ->prefixIconColor('primary')
                            ->live(onBlur: true)
                            ->requiredIfAccepted('marquee_2_status'),
                        Forms\Components\Toggle::make('marquee_2_status')
                            ->label('Active')
                            ->inlineLabel()
                            ->columnSpan(['sm' => 3, 'md' => 2])
                            ->onIcon('heroicon-m-eye')
                            ->offIcon('heroicon-m-eye-slash')
                            ->onColor('success')
                            ->offColor('danger')
                            ->disabled(fn(Forms\Get $get): bool => empty($get('marquee_2')))
                            ->dehydrated(true)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $state) {
                                if ($state == 1) {
                                    $set('marquee_1_status', false);
                                    $set('marquee_3_status', false);
                                    $set('active_marquee', $get('marquee_2'));
                                    $set('active_marquee_no', 2);
                                }

                                $allMessagesInactive = !$get('marquee_1_status')
                                && !$get('marquee_2_status')
                                && !$get('marquee_3_status');

                                if ($allMessagesInactive) {
                                    $set('active_marquee', null);
                                    $set('active_marquee_no', 0);

                                }
                            }),
                        Forms\Components\TextInput::make('marquee_3')
                            ->label('Rolling Message 3')
                            ->columnSpan(['sm' => 9, 'md' => 10])
                            ->inlineLabel()
                            ->placeholder('Enter message')
                            ->prefixIcon('heroicon-m-chat-bubble-bottom-center-text')
                            ->prefixIconColor('primary')
                            ->live(onBlur: true)
                            ->requiredIfAccepted('marquee_3_status'),
                        Forms\Components\Toggle::make('marquee_3_status')
                            ->label('Active')
                            ->inlineLabel()
                            ->columnSpan(['sm' => 3, 'md' => 2])
                            ->onIcon('heroicon-m-eye')
                            ->offIcon('heroicon-m-eye-slash')
                            ->onColor('success')
                            ->offColor('danger')
                            ->disabled(fn(Forms\Get $get): bool => empty($get('marquee_3')))
                            ->dehydrated(false)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $state) {
                                if ($state == 1) {
                                    $set('marquee_1_status', false);
                                    $set('marquee_2_status', false);
                                    $set('active_marquee', $get('marquee_3'));
                                    $set('active_marquee_no', 3);
                                }

                                $allMessagesInactive = !$get('marquee_1_status')
                                && !$get('marquee_2_status')
                                && !$get('marquee_3_status');

                                if ($allMessagesInactive) {
                                    $set('active_marquee', null);
                                    $set('active_marquee_no', 0);
                                }
                            }),
                    ]),
                Forms\Components\Section::make('Contribution Log')
                    ->hidden(fn() => empty($this->record))
                    ->columns(['lg' => 4])
                    ->collapsible()
                    ->collapsed()
                    ->compact()
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Placeholder::make('Updated By')
                            ->content(fn(): ?string => $this->record?->updater?->name),
                        Forms\Components\Placeholder::make('Updated At')
                            ->content(fn(): ?string => $this->record?->updated_at?->diffForHumans()),
                        Forms\Components\Placeholder::make('Created By')
                            ->content(fn(): ?string => $this->record?->creator?->name),
                        Forms\Components\Placeholder::make('Created At')
                            ->content(fn(): ?string => $this->record?->created_at?->toFormattedDateString()),
                    ]),
            ]);
    }
}
