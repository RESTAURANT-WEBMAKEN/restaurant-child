<?php

namespace App\Filament\Pages;

use App\Models\Restaurant;
use App\Traits\FilamentCustomPageAuthorization;
use DateTime;
use DateTimeZone;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class RestaurantDetails extends Page
{
    use FilamentCustomPageAuthorization;
    protected static ?string $model = Restaurant::class;
    protected static string $view = 'filament.pages.restaurant-details';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Restaurant Information';
    protected static ?int $navigationSort = 1;
    public ?Restaurant $record;
    public ?array $data = [];
    public ?string $customTitle = '';
    public ?string $tabQuery;

    public function getTitle(): string | Htmlable
    {
        $customTitle = match ($this->tabQuery) {
            '-testimonials-tab' => 'Reviews',
            '-timezone-tab' => 'Timezone (' . date_default_timezone_get() . ")",
            '-meta-details-tab' => 'Meta Details',
            '-social-media-links-tab' => 'Social Media Links',
            '-rolling-message-tab' => 'Rolling Message',

            default => static::$title ?? (string) str(class_basename(static::class))
                ->kebab()
                ->replace('-', ' ')
                ->title(),
        };

        if (Request::query('tab') == '-rolling-message-tab' && Request::query('type') == '-holiday-tab') {
            $customTitle = 'Holiday Message';
        }

        $this->customTitle = empty($this->customTitle) ? $customTitle : $this->customTitle;

        return $this->customTitle;

    }

    public function mount()
    {
        $superAdminApiServiceData = Cache::get('super_admin_api_data');
        $this->record = Restaurant::whereDomain($superAdminApiServiceData->domain)?->first();

        $this->tabQuery = empty($this->record) ? null : Request::query('tab'); // If null, the "Restaurant Details" tab will be shown by default.

        $data = $this->record?->toArray() ?? (array) $superAdminApiServiceData;

        // Convert other_details to array if it's a JSON
        if (isset($data['other_details']) && !is_array($data['other_details'])) {
            $data['other_details'] = json_decode($data['other_details'], true);
        }

        // Set default value for timezone
        if (!isset($data['timezone'])) {
            $data['timezone'] = config('app.timezone');
        }

        // Set default value for testimonials
        if (empty($data['testimonials']) || !is_array($data['testimonials'])) {
            $data['testimonials'] = [
                [
                    'status' => false,
                    'reviews' => [
                        [
                            'name' => 'John Doe',
                            'review' => 'Awesome',
                        ],
                    ],
                ],
            ];
        }

        // Set default value for meta details
        if (empty($data['meta_details']) || !is_array($data['meta_details'])) {
            $data['meta_details'] = [
                [
                    'main_page_status' => false,
                    'reviews_page_status' => false,
                    'reservation_page_status' => false,
                    'restaurant_menu_page_status' => false,
                    'takeaway_menu_page_status' => false,
                    'order_online_page_status' => false,
                ],
            ];
        }

        // Set default value for social media links
        if (empty($data['social_links']) || !is_array($data['social_links'])) {
            $data['social_links'] = [
                [
                    'status' => false,
                    'instagram_link_status' => false,
                    'facebook_link_status' => false,
                    'tripadvisor_link_status' => false,
                    'whatsapp_link_status' => false,
                    'youtube_link_status' => false,
                    'google_review_link_status' => false,
                ],
            ];
        }

        // Set default value for custom social media links
        if (empty($data['custom_social_links']) || !is_array($data['custom_social_links'])) {
            $data['custom_social_links'] = [
                [
                    'custom_link_1_status' => false,
                    'custom_link_2_status' => false,
                    'custom_link_3_status' => false,
                    'custom_link_4_status' => false,
                    'custom_link_5_status' => false,
                ],
            ];
        }

        // Set default value for custom rolling message
        if (empty($data['rolling_messages']) || !is_array($data['rolling_messages'])) {
            $data['rolling_messages'] = [
                [
                    'regular_status' => false,
                    'holiday_status' => false,
                ],
            ];
        }

        $this->data = $data;
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
                ->formId('restaurant_details')
                ->extraAttributes(['type' => 'submit'])
                ->action('save'),
        ];
    }

    public function save()
    {
        $existingRestaurant = Restaurant::where('domain', $this->data['domain'])->first();
        $data = $this->form->getState();

        // Convert other_details to JSON if it's an array
        if (isset($data['other_details']) && is_array($data['other_details'])) {
            $data['other_details'] = json_encode($data['other_details']);
        }

        if ($existingRestaurant) {
            // Update the existing restaurant
            $data['updated_by_user_id'] = auth()->id();
            // Update the existing restaurant
            $existingRestaurant->update($data);

            // Fetch the updated instance
            $this->record = $existingRestaurant->fresh(); // Use fresh() to get the updated model
        } else {
            $data['updated_by_user_id'] = auth()->id();
            $data['created_by_user_id'] = auth()->id();
            $this->record = Restaurant::create($data);
        }

        Notification::make('save_record')
            ->title('Success!')
            ->body('Restaurant Details Saved Successfully!')
            ->success()
            ->send();

        // Check if app name or timezone changes then update in .env file
        if (!empty($data['name']) && $data['name'] != config('app.name')) {
            update_env_value('APP_NAME', $this->record->name, false);
            return redirect()->to(URL::previous());
        }
        if (!empty($data['timezone']) && $data['timezone'] != config('app.timezone')) {
            update_env_value('APP_TIMEZONE', $this->record->timezone, false);
            return redirect()->to(URL::previous());
        }

    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->model(static::getModel())
            ->schema([
                Forms\Components\Tabs::make()
                    ->persistTabInQueryString()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Restaurant Details')
                            ->id('restaurant-details')
                            ->icon('heroicon-o-building-storefront')
                            ->columnSpanFull()
                            ->columns(['lg' => 12])
                            ->visible(fn() => ($this->tabQuery == '-restaurant-details-tab' || empty($this->tabQuery) || $this->tabQuery == 'undefined'))
                            ->schema([
                                Forms\Components\Hidden::make('installation_token'),
                                Forms\Components\Section::make('Restaurant Logo Upload')
                                    ->icon('heroicon-o-photo')
                                    ->description('Upload the logo of the restaurant. This will be displayed in the header and other areas of the application.')
                                    ->compact()
                                    ->collapsible()
                                    ->collapsed()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->columnSpan(['lg' => 6])
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo')
                                            ->inlineLabel()
                                            ->label('Restaurant Logo')
                                            ->extraAttributes(['class' => 'mx-auto'])
                                            ->disk('public')
                                            ->directory('logo')
                                            ->avatar()
                                            ->image()
                                            ->imageEditor()
                                            ->circleCropper()
                                            ->maxSize(1024)
                                            ->downloadable()
                                            ->openable(),
                                    ]),

                                Forms\Components\Section::make('Restaurant Favicon Upload')
                                    ->icon('heroicon-o-bookmark')
                                    ->description('Upload the favicon of the restaurant. This will appear as the website icon in browser tabs.')
                                    ->compact()
                                    ->collapsible()
                                    ->collapsed()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->columnSpan(['lg' => 6])
                                    ->schema([
                                        Forms\Components\FileUpload::make('favicon')
                                            ->inlineLabel()
                                            ->label('Restaurant Favicon')
                                            ->extraAttributes(['class' => 'mx-auto'])
                                            ->disk('public')
                                            ->directory('favicon')
                                            ->avatar()
                                            ->image()
                                            ->imageEditor()
                                            ->circleCropper()
                                            ->maxSize(1024)
                                            ->downloadable()
                                            ->openable(),
                                    ]),

                                Forms\Components\Section::make('')
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->columnSpan(['lg' => 12])
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Restaurant Name')
                                            ->inlineLabel()
                                            ->prefixIcon('heroicon-o-building-storefront')
                                            ->prefixIconColor('primary')
                                            ->placeholder('Restaurant Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Forms\Components\Hidden::make('description'),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Restaurant Description')
                                            ->inlineLabel()
                                            ->required()
                                            ->autosize()
                                            ->columnSpanFull()
                                            ->hidden(),
                                        Forms\Components\Hidden::make('domain'),
                                        Forms\Components\TextInput::make('domain')
                                            ->label('Restaurant Domain')
                                            ->inlineLabel()
                                            ->placeholder('Restaurant Domain Url')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull()
                                            ->hidden(),
                                    ]),
                                Forms\Components\Section::make('')
                                    ->compact()
                                    ->columnSpan(['lg' => 6])
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\Repeater::make('emails')
                                            ->collapsible()
                                            ->reorderableWithButtons()
                                            ->columnSpanFull()
                                            ->label('Restaurant Emails')
                                            ->inlineLabel()
                                            ->maxItems(5)
                                            ->simple(
                                                Forms\Components\TextInput::make('email')
                                                    ->hiddenLabel()
                                                    ->placeholder('Email')
                                                    ->required()
                                                    ->prefixIcon('heroicon-m-at-symbol')
                                                    ->prefixIconColor('primary')
                                                    ->email()
                                                    ->maxLength(255)
                                                    ->columnSpanFull(),
                                            ),
                                    ]),
                                Forms\Components\Section::make('')
                                    ->compact()
                                    ->columnSpan(['lg' => 6])
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\Repeater::make('telephones')
                                            ->collapsible()
                                            ->reorderableWithButtons()
                                            ->columnSpanFull()
                                            ->label('Restaurant Telephones')
                                            ->inlineLabel()
                                            ->maxItems(5)
                                            ->simple(
                                                Forms\Components\TextInput::make('telephone')
                                                    ->hiddenLabel()
                                                    ->placeholder('Phone')
                                                    ->required()
                                                    ->prefixIcon('heroicon-m-phone')
                                                    ->prefixIconColor('primary')
                                                    ->tel()
                                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                                    ->columnSpanFull(),
                                            ),
                                    ]),
                                Forms\Components\Section::make('')
                                    ->compact()
                                    ->columnSpan(['lg' => 12])
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\Repeater::make('addresses')
                                            ->collapsible()
                                            ->reorderableWithButtons()
                                            ->columnSpanFull()
                                            ->label('Restaurant Addresses')
                                            ->inlineLabel()
                                            ->maxItems(6)
                                            ->simple(
                                                Forms\Components\TextInput::make('address')
                                                    ->hiddenLabel()
                                                    ->placeholder('Address')
                                                    ->required()
                                                    ->prefixIcon('heroicon-o-map-pin')
                                                    ->prefixIconColor('primary')
                                                    ->columnSpanFull(),
                                            ),
                                    ]),
                                Forms\Components\Section::make('')
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->columnSpan(['lg' => 12])
                                    ->schema([
                                        Forms\Components\TextInput::make('address')
                                            ->label('Geo Location Link')
                                            ->inlineLabel()
                                            ->placeholder('e.g.; https://g.co/kgs/i9TkqjD')
                                            ->prefixIcon('heroicon-m-link')
                                            ->prefixIconColor('primary')
                                            ->columnSpanFull(),
                                    ]),
                                Forms\Components\Fieldset::make('Restaurant App Installation Status')
                                    ->hidden()
                                    ->columns(['lg' => 3])
                                    ->columnSpan(['lg' => 12])
                                    ->schema([
                                        Forms\Components\Toggle::make('featured')
                                            ->hidden()
                                            ->required(),
                                        Forms\Components\Toggle::make('visible')
                                            ->hidden()
                                            ->required(),
                                        Forms\Components\Toggle::make('verified')
                                            ->default(false)
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->onIcon('heroicon-o-arrow-down-tray')
                                            ->offIcon('heroicon-o-no-symbol')
                                            ->label('Installed')
                                            ->helperText('Toggle to indicate if the Restaurant App is installed. If the installation is incomplete, switch off to enable the installation button in the system check. This option is intended for debugging and processing manual installations.')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Timezone')
                            ->id('timezone')
                            ->icon('heroicon-m-globe-alt')
                            ->visible(fn() => $this->tabQuery == '-timezone-tab')
                            ->schema([
                                Forms\Components\Section::make('')
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->columnSpan(['lg' => 12])
                                    ->schema([
                                        Forms\Components\Select::make('timezone')
                                            ->label('Timezone')
                                            ->prefixIcon('heroicon-o-clock')
                                            ->options(collect(DateTimeZone::listIdentifiers())->mapWithKeys(function ($timezone) {
                                                $dateTimeZone = new DateTimeZone($timezone);
                                                $dateTime = new DateTime('now', $dateTimeZone);
                                                $offset = $dateTimeZone->getOffset($dateTime);
                                                $formattedOffset = sprintf('%+03d:%02d', $offset / 3600, abs($offset % 3600) / 60);

                                                return [$timezone => "(UTC $formattedOffset) $timezone"];
                                            }))
                                            ->placeholder('Select timezone')
                                            ->inlineLabel()
                                            ->searchable()
                                            ->native(false)
                                            ->preload()
                                            ->default(config('app.timezone'))
                                            ->required(),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Reviews')
                            ->id('testimonials')
                            ->icon('heroicon-o-star')
                            ->extraAttributes(['class' => '!p-0'])
                            ->visible(fn() => $this->tabQuery == '-testimonials-tab')
                            ->schema([
                                Forms\Components\Repeater::make('testimonials')
                                    ->extraAttributes(['class' => '[&>ul>div>li]:!ring-0 [&>ul>div>li]:dark:bg-transparent'])
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->hiddenLabel()
                                    ->schema([
                                        Forms\Components\ToggleButtons::make('status')
                                            ->label('Visibility')
                                            ->hiddenLabel()
                                            ->inline()
                                            ->boolean()
                                            ->options([
                                                1 => 'Show Reviews',
                                                0 => 'Hide Reviews',
                                            ])
                                            ->icons([
                                                1 => 'heroicon-m-eye',
                                                0 => 'heroicon-m-eye-slash',
                                            ]),
                                        Forms\Components\Repeater::make('reviews')
                                            ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                                            ->maxItems(10)
                                            ->hiddenLabel()
                                            ->reorderableWithButtons()
                                            ->extraAttributes(['class' => '[&>ul>div>li]:!bg-slate-300/30 [&>ul>div>li]:dark:ring-0 [&>ul>div>li]:dark:!bg-slate-950/30'])
                                            ->collapsible()
                                            ->cloneable()
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Name')
                                                    ->inlineLabel()
                                                    ->prefixIcon('heroicon-m-user')
                                                    ->prefixIconColor('primary')
                                                    ->live(onBlur: true)
                                                    ->required(),
                                                Forms\Components\TextInput::make('review')
                                                    ->label('Review')
                                                    ->inlineLabel()
                                                    ->prefixIcon('heroicon-m-sparkles')
                                                    ->prefixIconColor('primary')
                                                    ->required(),
                                            ]),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Meta Details')
                            ->id('meta-details')
                            ->icon('heroicon-o-code-bracket')
                            ->extraAttributes(['class' => '!p-0'])
                            ->visible(fn() => $this->tabQuery == '-meta-details-tab')
                            ->schema([
                                Forms\Components\Repeater::make('meta_details')
                                    ->extraAttributes(['class' => '[&>ul>div>li]:!ring-0 [&>ul>div>li]:dark:bg-transparent'])
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->hiddenLabel()
                                    ->schema([
                                        Forms\Components\Section::make(Str::upper('Main Page'))
                                            ->id('meta_details-main_page')
                                            ->icon('heroicon-o-document-text')
                                            ->iconColor('primary')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                            ->columnSpan(['lg' => 12])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('main_page_status')
                                                    ->label('Visibility')
                                                    ->inlineLabel()
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\TextInput::make('main_page_title')
                                                    ->label('Title')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta title')
                                                    ->prefixIcon('heroicon-m-h1')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('main_page_status'),
                                                Forms\Components\TextInput::make('main_page_description')
                                                    ->label('Description')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta description')
                                                    ->prefixIcon('heroicon-m-bars-3-bottom-left')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('main_page_status'),
                                                Forms\Components\TagsInput::make('main_page_keywords')
                                                    ->label('Keywords')
                                                    ->separator(',')
                                                    ->splitKeys(['Tab', ','])
                                                    ->reorderable()
                                                    ->inlineLabel()
                                                    ->placeholder('Enter keywords')
                                                    ->prefixIconColor('primary')
                                                    ->helperText('Use commas (,), the Tab key (→), or the Enter key to separate keywords.')
                                                    ->nestedRecursiveRules([
                                                        'min:3',
                                                        'max:255',
                                                    ]),
                                            ]),
                                        Forms\Components\Section::make(Str::upper('Reviews Page'))
                                            ->id('meta_details-reviews_page')
                                            ->icon('heroicon-o-document-text')
                                            ->iconColor('primary')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                            ->columnSpan(['lg' => 12])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('reviews_page_status')
                                                    ->label('Visibility')
                                                    ->inlineLabel()
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\TextInput::make('reviews_page_title')
                                                    ->label('Title')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta title')
                                                    ->prefixIcon('heroicon-m-h1')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('reviews_page_status'),
                                                Forms\Components\TextInput::make('reviews_page_description')
                                                    ->label('Description')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta description')
                                                    ->prefixIcon('heroicon-m-bars-3-bottom-left')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('reviews_page_status'),
                                                Forms\Components\TagsInput::make('reviews_page_keywords')
                                                    ->label('Keywords')
                                                    ->separator(',')
                                                    ->splitKeys(['Tab', ','])
                                                    ->reorderable()
                                                    ->inlineLabel()
                                                    ->placeholder('Enter keywords')
                                                    ->prefixIconColor('primary')
                                                    ->helperText('Use commas (,), the Tab key (→), or the Enter key to separate keywords.')
                                                    ->nestedRecursiveRules([
                                                        'min:3',
                                                        'max:255',
                                                    ]),
                                            ]),
                                        Forms\Components\Section::make(Str::upper('Reservation Page'))
                                            ->id('meta_details-reservation_page')
                                            ->icon('heroicon-o-document-text')
                                            ->iconColor('primary')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                            ->columnSpan(['lg' => 12])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('reservation_page_status')
                                                    ->label('Visibility')
                                                    ->inlineLabel()
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\TextInput::make('reservation_page_title')
                                                    ->label('Title')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta title')
                                                    ->prefixIcon('heroicon-m-h1')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('reservation_page_status'),
                                                Forms\Components\TextInput::make('reservation_page_description')
                                                    ->label('Description')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta description')
                                                    ->prefixIcon('heroicon-m-bars-3-bottom-left')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('reservation_page_status'),
                                                Forms\Components\TagsInput::make('reservation_page_keywords')
                                                    ->label('Keywords')
                                                    ->separator(',')
                                                    ->splitKeys(['Tab', ','])
                                                    ->reorderable()
                                                    ->inlineLabel()
                                                    ->placeholder('Enter keywords')
                                                    ->prefixIconColor('primary')
                                                    ->helperText('Use commas (,), the Tab key (→), or the Enter key to separate keywords.')
                                                    ->nestedRecursiveRules([
                                                        'min:3',
                                                        'max:255',
                                                    ]),
                                            ]),
                                        Forms\Components\Section::make(Str::upper('Restaurant Menu Page'))
                                            ->id('meta_details-restaurant_menu_page')
                                            ->icon('heroicon-o-document-text')
                                            ->iconColor('primary')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                            ->columnSpan(['lg' => 12])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('restaurant_menu_page_status')
                                                    ->label('Visibility')
                                                    ->inlineLabel()
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\TextInput::make('restaurant_menu_page_title')
                                                    ->label('Title')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta title')
                                                    ->prefixIcon('heroicon-m-h1')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('restaurant_menu_page_status'),
                                                Forms\Components\TextInput::make('restaurant_menu_page_description')
                                                    ->label('Description')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta description')
                                                    ->prefixIcon('heroicon-m-bars-3-bottom-left')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('restaurant_menu_page_status'),
                                                Forms\Components\TagsInput::make('restaurant_menu_page_keywords')
                                                    ->label('Keywords')
                                                    ->separator(',')
                                                    ->splitKeys(['Tab', ','])
                                                    ->reorderable()
                                                    ->inlineLabel()
                                                    ->placeholder('Enter keywords')
                                                    ->prefixIconColor('primary')
                                                    ->helperText('Use commas (,), the Tab key (→), or the Enter key to separate keywords.')
                                                    ->nestedRecursiveRules([
                                                        'min:3',
                                                        'max:255',
                                                    ]),
                                            ]),
                                        Forms\Components\Section::make(Str::upper('Takeaway Menu Page'))
                                            ->id('meta_details-takeaway_menu_page')
                                            ->icon('heroicon-o-document-text')
                                            ->iconColor('primary')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                            ->columnSpan(['lg' => 12])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('takeaway_menu_page_status')
                                                    ->label('Visibility')
                                                    ->inlineLabel()
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\TextInput::make('takeaway_menu_page_title')
                                                    ->label('Title')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta title')
                                                    ->prefixIcon('heroicon-m-h1')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('takeaway_menu_page_status'),
                                                Forms\Components\TextInput::make('takeaway_menu_page_description')
                                                    ->label('Description')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta description')
                                                    ->prefixIcon('heroicon-m-bars-3-bottom-left')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('takeaway_menu_page_status'),
                                                Forms\Components\TagsInput::make('takeaway_menu_page_keywords')
                                                    ->label('Keywords')
                                                    ->separator(',')
                                                    ->splitKeys(['Tab', ','])
                                                    ->reorderable()
                                                    ->inlineLabel()
                                                    ->placeholder('Enter keywords')
                                                    ->prefixIconColor('primary')
                                                    ->helperText('Use commas (,), the Tab key (→), or the Enter key to separate keywords.')
                                                    ->nestedRecursiveRules([
                                                        'min:3',
                                                        'max:255',
                                                    ]),
                                            ]),
                                        Forms\Components\Section::make(Str::upper('Order Online Page'))
                                            ->id('meta_details-order_online_page')
                                            ->icon('heroicon-o-document-text')
                                            ->iconColor('primary')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                            ->columnSpan(['lg' => 12])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('order_online_page_status')
                                                    ->label('Visibility')
                                                    ->inlineLabel()
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\TextInput::make('order_online_page_title')
                                                    ->label('Title')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta title')
                                                    ->prefixIcon('heroicon-m-h1')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('order_online_page_status'),
                                                Forms\Components\TextInput::make('order_online_page_description')
                                                    ->label('Description')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter meta description')
                                                    ->prefixIcon('heroicon-m-bars-3-bottom-left')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('order_online_page_status'),
                                                Forms\Components\TagsInput::make('order_online_page_keywords')
                                                    ->label('Keywords')
                                                    ->separator(',')
                                                    ->splitKeys(['Tab', ','])
                                                    ->reorderable()
                                                    ->inlineLabel()
                                                    ->placeholder('Enter keywords')
                                                    ->prefixIconColor('primary')
                                                    ->helperText('Use commas (,), the Tab key (→), or the Enter key to separate keywords.')
                                                    ->nestedRecursiveRules([
                                                        'min:3',
                                                        'max:255',
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Social Media Links')
                            ->id('social-media-links')
                            ->icon('heroicon-o-link')
                            ->extraAttributes(['class' => '!p-0'])
                            ->visible(fn() => $this->tabQuery == '-social-media-links-tab')
                            ->schema([
                                Forms\Components\Repeater::make('social_links')
                                    ->extraAttributes(['class' => '[&>ul>div>li]:!ring-0 [&>ul>div>li]:dark:bg-transparent'])
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->hiddenLabel()
                                    ->schema([
                                        Forms\Components\ToggleButtons::make('status')
                                            ->label('Visibility')
                                            ->hiddenLabel()
                                            ->inline()
                                            ->boolean()
                                            ->options([
                                                1 => 'Show SM Icons',
                                                0 => 'Hide SM Icons',
                                            ])
                                            ->icons([
                                                1 => 'heroicon-m-eye',
                                                0 => 'heroicon-m-eye-slash',
                                            ]),
                                        Forms\Components\Section::make()
                                            ->compact()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->columns(['sm' => 12])
                                            ->schema([
                                                Forms\Components\TextInput::make('instagram_link')
                                                    ->label('Instagram Link')
                                                    ->columnSpan(['sm' => 10, 'md' => 11])
                                                    ->inlineLabel()
                                                    ->placeholder('Enter link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('instagram_link_status'),
                                                Forms\Components\Toggle::make('instagram_link_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 2, 'md' => 1])
                                                    ->onIcon('heroicon-m-eye')
                                                    ->offIcon('heroicon-m-eye-slash')
                                                    ->onColor('success')
                                                    ->offColor('danger'),
                                            ]),
                                        Forms\Components\Section::make()
                                            ->compact()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->columns(['sm' => 12])
                                            ->schema([
                                                Forms\Components\TextInput::make('facebook_link')
                                                    ->label('Facebook Link')
                                                    ->columnSpan(['sm' => 10, 'md' => 11])
                                                    ->inlineLabel()
                                                    ->placeholder('Enter link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('facebook_link_status'),
                                                Forms\Components\Toggle::make('facebook_link_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 2, 'md' => 1])
                                                    ->onIcon('heroicon-m-eye')
                                                    ->offIcon('heroicon-m-eye-slash')
                                                    ->onColor('success')
                                                    ->offColor('danger'),
                                            ]),
                                        Forms\Components\Section::make()
                                            ->compact()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->columns(['sm' => 12])
                                            ->schema([
                                                Forms\Components\TextInput::make('tripadvisor_link')
                                                    ->label('Tripadvisor Link')
                                                    ->columnSpan(['sm' => 10, 'md' => 11])
                                                    ->inlineLabel()
                                                    ->placeholder('Enter link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('tripadvisor_link_status'),
                                                Forms\Components\Toggle::make('tripadvisor_link_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 2, 'md' => 1])
                                                    ->onIcon('heroicon-m-eye')
                                                    ->offIcon('heroicon-m-eye-slash')
                                                    ->onColor('success')
                                                    ->offColor('danger'),
                                            ]),
                                        Forms\Components\Section::make()
                                            ->compact()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->columns(['sm' => 12])
                                            ->schema([
                                                Forms\Components\TextInput::make('whatsapp_link')
                                                    ->label('WhatsApp Link')
                                                    ->columnSpan(['sm' => 10, 'md' => 11])
                                                    ->inlineLabel()
                                                    ->placeholder('Enter link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('whatsapp_link_status'),
                                                Forms\Components\Toggle::make('whatsapp_link_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 2, 'md' => 1])
                                                    ->onIcon('heroicon-m-eye')
                                                    ->offIcon('heroicon-m-eye-slash')
                                                    ->onColor('success')
                                                    ->offColor('danger'),
                                            ]),
                                        Forms\Components\Section::make()
                                            ->compact()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->columns(['sm' => 12])
                                            ->schema([
                                                Forms\Components\TextInput::make('youtube_link')
                                                    ->label('TouTube Link')
                                                    ->columnSpan(['sm' => 10, 'md' => 11])
                                                    ->inlineLabel()
                                                    ->placeholder('Enter link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('youtube_link_status'),
                                                Forms\Components\Toggle::make('youtube_link_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 2, 'md' => 1])
                                                    ->onIcon('heroicon-m-eye')
                                                    ->offIcon('heroicon-m-eye-slash')
                                                    ->onColor('success')
                                                    ->offColor('danger'),
                                            ]),
                                        Forms\Components\Section::make()
                                            ->compact()
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->columns(['sm' => 12])
                                            ->schema([
                                                Forms\Components\TextInput::make('google_review_link')
                                                    ->label('Google Review Link')
                                                    ->columnSpan(['sm' => 10, 'md' => 11])
                                                    ->inlineLabel()
                                                    ->placeholder('Enter link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->requiredIfAccepted('google_review_link_status'),
                                                Forms\Components\Toggle::make('google_review_link_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 2, 'md' => 1])
                                                    ->onIcon('heroicon-m-eye')
                                                    ->offIcon('heroicon-m-eye-slash')
                                                    ->onColor('success')
                                                    ->offColor('danger'),
                                            ]),
                                    ]),
                                Forms\Components\Repeater::make('custom_social_links')
                                    ->extraAttributes(['class' => '[&>ul>div>li]:!ring-0 [&>ul>div>li]:dark:bg-transparent'])
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->hiddenLabel()
                                    ->itemLabel('Upload custom social media icons and links. Use PNG files for the icons with dimensions of 512 x 512 pixels.')
                                    ->schema([
                                        Forms\Components\Section::make('Social Media 1 Link')
                                            ->id('custom_social_links_section_1')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->columns(['sm' => 12])
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('custom_link_1_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 4])
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\FileUpload::make('custom_link_1_img')
                                                    ->hiddenLabel()
                                                    ->label('Image')
                                                    ->disk('public')
                                                    ->directory('custom_social_links')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->columnSpan(['sm' => 8])
                                                    ->imageCropAspectRatio('1:1')
                                                    ->maxSize(1024)
                                                    ->downloadable()
                                                    ->openable()
                                                    ->requiredIfAccepted('custom_link_1_status'),
                                                Forms\Components\TextInput::make('custom_link_1_url')
                                                    ->label('Custom Link 1')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter custom social media link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->columnSpan(['sm' => 12])
                                                    ->requiredIfAccepted('custom_link_1_status'),
                                            ]),
                                        Forms\Components\Section::make('Social Media 2 Link')
                                            ->id('custom_social_links_section_2')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->columns(['sm' => 12])
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('custom_link_2_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 4])
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\FileUpload::make('custom_link_2_img')
                                                    ->hiddenLabel()
                                                    ->label('Image')
                                                    ->disk('public')
                                                    ->directory('custom_social_links')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->columnSpan(['sm' => 8])
                                                    ->imageCropAspectRatio('1:1')
                                                    ->maxSize(1024)
                                                    ->downloadable()
                                                    ->openable()
                                                    ->requiredIfAccepted('custom_link_2_status'),
                                                Forms\Components\TextInput::make('custom_link_2_url')
                                                    ->label('Custom Link 1')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter custom social media link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->columnSpan(['sm' => 12])
                                                    ->requiredIfAccepted('custom_link_2_status'),
                                            ]),
                                        Forms\Components\Section::make('Social Media 3 Link')
                                            ->id('custom_social_links_section_3')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->columns(['sm' => 12])
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('custom_link_3_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 4])
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\FileUpload::make('custom_link_3_img')
                                                    ->hiddenLabel()
                                                    ->label('Image')
                                                    ->disk('public')
                                                    ->directory('custom_social_links')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->columnSpan(['sm' => 8])
                                                    ->imageCropAspectRatio('1:1')
                                                    ->maxSize(1024)
                                                    ->downloadable()
                                                    ->openable()
                                                    ->requiredIfAccepted('custom_link_3_status'),
                                                Forms\Components\TextInput::make('custom_link_3_url')
                                                    ->label('Custom Link 1')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter custom social media link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->columnSpan(['sm' => 12])
                                                    ->requiredIfAccepted('custom_link_3_status'),
                                            ]),
                                        Forms\Components\Section::make('Social Media 4 Link')
                                            ->id('custom_social_links_section_4')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->columns(['sm' => 12])
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('custom_link_4_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 4])
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\FileUpload::make('custom_link_4_img')
                                                    ->hiddenLabel()
                                                    ->label('Image')
                                                    ->disk('public')
                                                    ->directory('custom_social_links')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->columnSpan(['sm' => 8])
                                                    ->imageCropAspectRatio('1:1')
                                                    ->maxSize(1024)
                                                    ->downloadable()
                                                    ->openable()
                                                    ->requiredIfAccepted('custom_link_4_status'),
                                                Forms\Components\TextInput::make('custom_link_4_url')
                                                    ->label('Custom Link 1')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter custom social media link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->columnSpan(['sm' => 12])
                                                    ->requiredIfAccepted('custom_link_4_status'),
                                            ]),
                                        Forms\Components\Section::make('Social Media 5 Link')
                                            ->id('custom_social_links_section_5')
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->columns(['sm' => 12])
                                            ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0 [&>div>div>div]:items-center'])
                                            ->schema([
                                                Forms\Components\ToggleButtons::make('custom_link_5_status')
                                                    ->label('Visibility')
                                                    ->hiddenLabel()
                                                    ->columnSpan(['sm' => 4])
                                                    ->inline()
                                                    ->boolean()
                                                    ->options([
                                                        1 => 'Show',
                                                        0 => 'Hide',
                                                    ])
                                                    ->icons([
                                                        1 => 'heroicon-m-eye',
                                                        0 => 'heroicon-m-eye-slash',
                                                    ]),
                                                Forms\Components\FileUpload::make('custom_link_5_img')
                                                    ->hiddenLabel()
                                                    ->label('Image')
                                                    ->disk('public')
                                                    ->directory('custom_social_links')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->columnSpan(['sm' => 8])
                                                    ->imageCropAspectRatio('1:1')
                                                    ->maxSize(1024)
                                                    ->downloadable()
                                                    ->openable()
                                                    ->requiredIfAccepted('custom_link_5_status'),
                                                Forms\Components\TextInput::make('custom_link_5_url')
                                                    ->label('Custom Link 1')
                                                    ->inlineLabel()
                                                    ->placeholder('Enter custom social media link')
                                                    ->prefixIcon('heroicon-m-link')
                                                    ->prefixIconColor('primary')
                                                    ->columnSpan(['sm' => 12])
                                                    ->requiredIfAccepted('custom_link_5_status'),
                                            ]),
                                    ]),

                            ]),
                        Forms\Components\Tabs\Tab::make('Settings')
                            ->id('settings')
                            ->visible(fn() => ($this->tabQuery == '-restaurant-details-tab' || empty($this->tabQuery) || $this->tabQuery == 'undefined'))
                            ->schema([
                                Forms\Components\Section::make('Close Restaurant')
                                    ->description('Manage the status and message for temporarily closing your restaurant.')
                                    ->compact()
                                    ->aside()
                                    ->schema([
                                        Forms\Components\Toggle::make('status')
                                            ->label(fn(Forms\Get $get): ?string => $get('status') ? 'Closed Now' : 'Open Now')
                                            ->helperText(
                                                fn(Forms\Get $get): ?string => $get('status')
                                                ? 'The service is currently marked as closed. You can also add a custom closing message.'
                                                : 'The restaurant is currently open. You can click the toggle button to mark it as closed.')
                                            ->onIcon('heroicon-o-lock-closed')
                                            ->onColor('danger')
                                            ->offIcon('heroicon-o-lock-open')
                                            ->offColor('success')
                                            ->live(),
                                        Forms\Components\RichEditor::make('status_msg')
                                            ->label('Closure Message')
                                            ->placeholder('Type a message for customers regarding the closure.')
                                            ->visible(fn(Forms\Get $get): bool => $get('status')),
                                    ]),
                                Forms\Components\Section::make('Online Order')
                                    ->description('Set the availability of online orders and communicate any changes.')
                                    ->compact()
                                    ->aside()
                                    ->schema([
                                        Forms\Components\Toggle::make('online_order_status')
                                            ->label(
                                                fn(Forms\Get $get): string => $get('online_order_status') ? 'Open for Online Orders' : 'Closed for Online Orders'
                                            )
                                            ->helperText(
                                                fn(Forms\Get $get): string => $get('online_order_status')
                                                ? 'The restaurant is open for online orders. Click the toggle button to mark it as closed.'
                                                : 'The restaurant is currently closed for online orders. Toggle on to allow orders again. You can also add a custom closing message.'
                                            )
                                            ->onIcon('heroicon-o-shopping-cart')
                                            ->onColor('success')
                                            ->offIcon('heroicon-o-shopping-cart')
                                            ->offColor('danger')
                                            ->live(),
                                        Forms\Components\RichEditor::make('online_order_msg')
                                            ->label('Order Message')
                                            ->placeholder('Type a message for customers regarding closing online orders.')
                                            ->hidden(fn(Forms\Get $get): bool => $get('online_order_status')),
                                    ]),
                                Forms\Components\Section::make('Reservation')
                                    ->description('Control the reservation status and provide necessary information.')
                                    ->compact()
                                    ->aside()
                                    ->schema([
                                        Forms\Components\Toggle::make('reservation_status')
                                            ->label(
                                                fn(Forms\Get $get): string => $get('reservation_status') ? 'Open for Reservations' : 'Closed for Reservations'
                                            )
                                            ->helperText(
                                                fn(Forms\Get $get): string => $get('reservation_status')
                                                ? 'The restaurant is open for reservations. Click the toggle button to mark it as closed for new reservations.'
                                                : 'The restaurant is currently closed for reservations. Toggle off to allow reservations again. You can also add a custom closing message.'
                                            )
                                            ->onIcon('heroicon-o-calendar-days')
                                            ->onColor('success')
                                            ->offIcon('heroicon-o-calendar-days')
                                            ->offColor('danger')
                                            ->live(),
                                        Forms\Components\RichEditor::make('reservation_msg')
                                            ->label('Reservation Closing Message')
                                            ->placeholder('Type a message for customers regarding closing reservations.')
                                            ->hidden(fn(Forms\Get $get): bool => $get('reservation_status')),
                                    ]),
                                Forms\Components\Section::make('Shutdown')
                                    ->description('Manage the restaurant shutdown process and communicate with customers.')
                                    ->compact()
                                    ->aside()
                                    ->schema([
                                        Forms\Components\Toggle::make('shutdown_status')
                                            ->label(
                                                fn(Forms\Get $get): string => $get('shutdown_status') ? 'Shutdown' : 'Operational'
                                            )
                                            ->helperText(
                                                fn(Forms\Get $get): string => $get('shutdown_status')
                                                ? 'The restaurant is currently shut down. Toggle off to resume operations. You can also add a custom shutdown message.'
                                                : 'The restaurant is operational. Click the toggle button to mark it as shut down.'
                                            )
                                            ->onIcon('heroicon-o-power')
                                            ->onColor('danger')
                                            ->offIcon('heroicon-o-check')
                                            ->offColor('success')
                                            ->live(),
                                        Forms\Components\RichEditor::make('shutdown_msg')
                                            ->label('Shutdown Message')
                                            ->placeholder('Type a message for customers regarding the shutdown.')
                                            ->hidden(fn(Forms\Get $get): bool => !$get('shutdown_status')),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Other Details')
                            ->id('other-details')
                            ->visible(fn() => $this->tabQuery == '-other-details-tab')
                            ->schema([
                                Forms\Components\Repeater::make('other_details')
                                    ->hiddenLabel()
                                    ->columnSpanFull()
                                    ->columns(['lg' => 12])
                                    ->collapsible()
                                    ->reorderableWithButtons()
                                    ->schema([
                                        Forms\Components\TextInput::make('key')
                                            ->columnSpan(['lg' => 6]),
                                        Forms\Components\TextInput::make('value')
                                            ->columnSpan(['lg' => 6]),
                                    ]),
                            ]),
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
