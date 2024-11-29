<?php

namespace App\Filament\Pages;

use App\Models\RollingMessage;
use App\Traits\FilamentCustomPageAuthorization;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class HolidayMessagePage extends Page
{
    use FilamentCustomPageAuthorization;
    protected static ?string $model = RollingMessage::class;
    protected static string $view = 'filament.pages.holiday-message-page';
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'Restaurant Information';
    protected static ?int $navigationSort = 4;
    protected static ?string $slug = 'holiday-message';
    protected static ?string $title = 'Holiday Message';
    public ?RollingMessage $record;
    public ?array $data = [];

    public function getSubheading(): string
    {
        return __('Manage and set holiday messages to be displayed on the website, such as special announcements or holiday hours.');
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
                ->formId('holiday_message')
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
            ->body('Holiday Message Saved Successfully!')
            ->success()
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->model(static::getModel())
            ->schema([
                Forms\Components\Section::make()
                    ->compact()
                    ->columns(['sm' => 2])
                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-blue-950/20 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                    ->schema([
                        Forms\Components\ToggleButtons::make('holiday_marquee_status')
                            ->label('Visibility')
                            ->inlineLabel()
                            ->columnSpanFull()
                            ->inline()
                            ->boolean()
                            ->required()
                            ->options([
                                1 => 'Show Holiday Message',
                                0 => 'Hide Holiday Message',
                            ])
                            ->icons([
                                1 => 'heroicon-m-eye',
                                0 => 'heroicon-m-eye-slash',
                            ]),
                        Forms\Components\TextInput::make('holiday_marquee')
                            ->label('Message')
                            ->inlineLabel()
                            ->placeholder('Enter holiday message')
                            ->prefixIcon('heroicon-m-link')
                            ->prefixIconColor('primary')
                            ->columnSpanFull()
                            ->requiredIfAccepted('holiday_marquee_status'),
                        Forms\Components\Group::make()
                            ->columns(['sm' => 2])
                            ->schema([
                                Forms\Components\DatePicker::make('holiday_marquee_start_date')
                                    ->label('Start Date')
                                    ->inlineLabel()
                                    ->placeholder('Pick Start Date')
                                    ->prefixIcon('heroicon-m-calendar')
                                    ->prefixIconColor('primary')
                                    ->columnSpanFull()
                                    ->minDate(Carbon::today())
                                    ->requiredIfAccepted('holiday_marquee_status'),
                                Forms\Components\TimePicker::make('holiday_marquee_start_time')
                                    ->label('Start Time')
                                    ->inlineLabel()
                                    ->placeholder('Pick Start Time')
                                    ->prefixIcon('heroicon-m-clock')
                                    ->prefixIconColor('primary')
                                    ->columnSpanFull()
                                    ->minDate(Carbon::today())
                                    ->requiredIfAccepted('holiday_marquee_status'),
                            ]),
                        Forms\Components\Group::make()
                            ->columns(['sm' => 2])
                            ->schema([
                                Forms\Components\DatePicker::make('holiday_marquee_end_date')
                                    ->label('End Date')
                                    ->inlineLabel()
                                    ->placeholder('Pick End Date')
                                    ->prefixIcon('heroicon-m-calendar')
                                    ->prefixIconColor('primary')
                                    ->columnSpanFull()
                                    ->minDate(Carbon::today())
                                    ->requiredIfAccepted('holiday_marquee_status'),
                                Forms\Components\TimePicker::make('holiday_marquee_end_time')
                                    ->label('End Time')
                                    ->inlineLabel()
                                    ->placeholder('Pick End Time')
                                    ->prefixIcon('heroicon-m-clock')
                                    ->prefixIconColor('primary')
                                    ->columnSpanFull()
                                    ->minDate(Carbon::today())
                                    ->requiredIfAccepted('holiday_marquee_status'),
                            ]),
                    ]),

                // Contribution Log
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
