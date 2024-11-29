<?php

namespace App\Filament\Resources;

use App\Enums\UserRoleEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->collapsible()
                    ->compact()
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('primary')
                    ->description('Provide the basic personal details, such as name, email, and contact information.')
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
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('Enter a valid and unique email'),
                        Forms\Components\TextInput::make('phone')
                            ->inlineLabel()
                            ->prefixIcon('heroicon-m-phone')
                            ->prefixIconColor('primary')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                            ->unique(ignoreRecord: true)
                            // ->formatStateUsing(fn(?string $state, ?string $operation): ?string => $operation === 'create' ? '91' . $state : $state)
                            ->placeholder('Enter a valid phone number with country code'),
                        Forms\Components\Select::make('role')
                            ->inlineLabel()
                            ->prefixIcon('heroicon-m-identification')
                            ->prefixIconColor('primary')
                            ->options(UserRoleEnum::class)
                            ->required()
                            ->default(UserRoleEnum::default())
                            ->enum(UserRoleEnum::class)
                            ->native(false)
                            ->placeholder('Select a user role'),
                    ]),

                Forms\Components\Section::make(fn(string $operation): string => $operation === 'create' ? 'Security Settings' : 'Update Password')
                    ->collapsible()
                    ->compact()
                    ->icon('heroicon-m-lock-closed')
                    ->iconColor('success')
                    ->description(fn(string $operation): string =>
                        $operation === 'create'
                        ? 'Set up a secure password to protect the account.'
                        : 'Change the password to keep the account secure.'
                    )
                    ->extraAttributes(['class' => '!bg-green-300/20 dark:!bg-green-400/5'])
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->inlineLabel()
                            ->label(fn(string $operation): string => $operation === 'create' ? 'Password' : 'New Password')
                            ->prefixIcon('heroicon-m-lock-closed')
                            ->prefixIconColor('success')
                            ->password()
                            ->confirmed()
                            ->revealable()
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->minLength(5)
                            ->maxLength(15)
                            ->placeholder(fn(string $operation): string =>
                                $operation === 'create'
                                ? 'Create a strong password'
                                : 'Enter a new password'
                            ),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->inlineLabel()
                            ->label(fn(string $operation): string => $operation === 'create' ? 'Confirm Password' : 'Confirm New Password')
                            ->prefixIcon('heroicon-m-lock-closed')
                            ->prefixIconColor('success')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->minLength(5)
                            ->maxLength(15)
                            ->placeholder(fn(string $operation): string =>
                                $operation === 'create'
                                ? 'Re-enter the password'
                                : 'Re-enter the new password'
                            ),
                    ]),

                Forms\Components\Section::make('Additional Details')
                    ->collapsible()
                    ->compact()
                    ->icon('heroicon-m-document-text')
                    ->iconColor('secondary')
                    ->description('Provide any additional information, such as address.')
                    ->extraAttributes(['class' => '!bg-slate-300/40 dark:!bg-slate-500/10'])
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->inlineLabel()
                            ->rows(3)
                            ->minLength(5)
                            ->placeholder('Enter full address'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->sortable()
                    ->badge(fn() => UserRoleEnum::class),
                    // ->summarize(Tables\Columns\Summarizers\Summarizer::make()
                    //         ->label('User')
                    //         ->using(fn(QueryBuilder $query) => $query->where('role', 'USER')->count('role')))
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
