<?php

namespace App\Filament\Pages;

use App\Models\PageEdit;
use App\Traits\FilamentCustomPageAuthorization;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class HomePageEdit extends Page
{
    use FilamentCustomPageAuthorization;
    protected static string $resource = PageEdit::class;
    protected static ?string $model = PageEdit::class;
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationGroup = 'Website Content Management';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.home-page-edit';
    private static string $key = 'home_page';
    public ?PageEdit $record;
    public ?array $data = [];

    public function mount()
    {
        $this->record = PageEdit::where(['key' => static::$key])?->first();

        $this->data = $this->record?->toArray();

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
                ->authorize(fn() => empty($this->record) ? static::canCreate(): static::canEdit($this->record))
                ->formId('homepage_edit_details')
                ->extraAttributes(['type' => 'submit'])
                ->action('save'),
        ];
    }

    public function save()
    {
        $existingValue = PageEdit::where('key', static::$key)->first();
        $data = $this->form->getState();
        dd($data);

        // Convert value to JSON if it's an array
        if (isset($data['value']) && is_array($data['value'])) {
            $data['value'] = json_encode($data['value']);
        }

        if ($existingValue) {
            // Update the existing restaurant
            $data['updated_by_user_id'] = auth()->id();
            // Update the existing restaurant
            $existingValue->update($data);

            // Fetch the updated instance
            $this->record = $existingValue->fresh(); // Use fresh() to get the updated model
        } else {
            $data['updated_by_user_id'] = auth()->id();
            $data['created_by_user_id'] = auth()->id();
            $this->record = PageEdit::create($data);
        }

        Notification::make('save_record')
            ->title('Success!')
            ->body('Restaurant Details Saved Successfully!')
            ->success()
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->model(PageEdit::class)
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Header Section')
                            ->schema([
                                // Header Section Title
                                Forms\Components\Section::make()
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\TextInput::make('header_section_title')
                                            ->label('Title')
                                            ->inlineLabel()
                                            ->prefixIcon('heroicon-o-h1')
                                            ->prefixIconColor('primary')
                                            ->placeholder('Enter the title for the header section')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                // Header Section Description
                                Forms\Components\Section::make()
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\RichEditor::make('header_section_description')
                                            ->label('Description')
                                            ->inlineLabel()
                                            ->placeholder('Enter a detailed description for the header section')
                                            ->required(),
                                    ]),

                                // Header Section Caption
                                Forms\Components\Section::make()
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\TextInput::make('header_section_caption')
                                            ->label('Caption')
                                            ->inlineLabel()
                                            ->prefixIcon('heroicon-o-tag')
                                            ->prefixIconColor('primary')
                                            ->placeholder('Enter a short caption for the header section')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                // Header Section Background Image Upload
                                Forms\Components\Section::make('Background Image')
                                    ->icon('heroicon-o-photo')
                                    ->description('Upload a high-quality image for the header background. This image will enhance the visual appeal of your page header.')
                                    ->compact()
                                    ->collapsible()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\FileUpload::make('header_section_background_img')
                                            ->label('Background Image')
                                            ->inlineLabel()
                                            ->required()
                                            ->disk('public')
                                            ->directory('page_customization')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(1024 * 5)
                                            ->downloadable()
                                            ->openable(),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('About Section')
                            ->schema([
                                // About Section Title
                                Forms\Components\Section::make()
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\TextInput::make('about_section_title')
                                            ->label('Title')
                                            ->inlineLabel()
                                            ->prefixIcon('heroicon-o-h1')
                                            ->prefixIconColor('primary')
                                            ->placeholder('Enter the title for the about section')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                // About Section Description
                                Forms\Components\Section::make()
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\RichEditor::make('about_section_description')
                                            ->label('Description')
                                            ->inlineLabel()
                                            ->placeholder('Enter a detailed description for the about section')
                                            ->required(),
                                    ]),

                                // About Section Front Image Upload
                                Forms\Components\Section::make('Front Image')
                                    ->icon('heroicon-o-photo')
                                    ->description('Upload a high-quality image to enhance the visual appeal of the front image in the About section.')
                                    ->compact()
                                    ->collapsible()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\FileUpload::make('about_section_front_img')
                                            ->label('Front Image')
                                            ->inlineLabel()
                                            ->required()
                                            ->disk('public')
                                            ->directory('page_customization')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(1024)
                                            ->downloadable()
                                            ->openable(),
                                    ]),

                                // About Section Background Image Upload
                                Forms\Components\Section::make('Background Image')
                                    ->icon('heroicon-o-photo')
                                    ->description('Upload a high-quality image to enhance the visual appeal of the background for the About section on the page.')
                                    ->compact()
                                    ->collapsible()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\FileUpload::make('about_section_background_img')
                                            ->label('Background Image')
                                            ->inlineLabel()
                                            ->required()
                                            ->disk('public')
                                            ->directory('page_customization')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(1024)
                                            ->downloadable()
                                            ->openable(),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Center Section')
                            ->schema([
                                // Center Section Title
                                Forms\Components\Section::make()
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\TextInput::make('center_section_title')
                                            ->label('Title')
                                            ->inlineLabel()
                                            ->prefixIcon('heroicon-o-h1')
                                            ->prefixIconColor('primary')
                                            ->placeholder('Enter the title for the center section')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                // Center Section Description
                                Forms\Components\Section::make()
                                    ->compact()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\RichEditor::make('center_section_description')
                                            ->label('Description')
                                            ->inlineLabel()
                                            ->placeholder('Enter a detailed description for the center section')
                                            ->required(),
                                    ]),

                                // Center Section Front Image Upload
                                Forms\Components\Section::make('Front Image')
                                    ->icon('heroicon-o-photo')
                                    ->description('Upload a high-quality image to enhance the visual appeal of the center section on the page.')
                                    ->compact()
                                    ->collapsible()
                                    ->extraAttributes(['class' => '!bg-slate-300/30 dark:!bg-slate-950/30 ring-0 dark:ring-0'])
                                    ->schema([
                                        Forms\Components\FileUpload::make('center_section_front_img')
                                            ->label('Image')
                                            ->inlineLabel()
                                            ->required()
                                            ->disk('public')
                                            ->directory('page_customization')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(1024)
                                            ->downloadable()
                                            ->openable(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString(),

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
