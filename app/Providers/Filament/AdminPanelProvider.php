<?php

namespace App\Providers\Filament;

use App\CentralLogics\Helpers;
use App\Filament\Pages\RestaurantDetails;
use App\Models\Restaurant;
use App\Services\SuperAdminApiService;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Cache;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->id('admin')
            ->path('admin')

            // Using bootUsing to handle cache and database checks globally
            ->bootUsing(function (Panel $panel) {
                $superAdminApiServiceData = Cache::get('super_admin_api_data');

                $restaurantData = Restaurant::whereDomain($superAdminApiServiceData->domain)?->first() ?? $superAdminApiServiceData;
            
                // Set up the brand data
                $panel->brandName(fn() => $restaurantData->name ?? config('app.name'))
                    ->favicon(fn() => Helpers::get_img_full_url(null, $restaurantData->favicon_full_url ?? null, 'public', 'favicon'))
                    ->brandLogo(fn() => Helpers::get_img_full_url(null, $restaurantData->logo_full_url ?? null, 'public', 'logo'))
                    ->brandLogoHeight('2rem');
            })

            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->profile()

            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class, // commented because using custom dashboard page
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->navigationGroups([
                'Restaurant Information', // Primary details about the restaurant should be readily accessible for editing or updates.
                'User Management', // User-related tasks, such as managing admin or customer accounts, are generally a priority.
                'Customer Engagement', // Focuses on customer interactions, reviews, reservations, and orders.
                'Website Content Management', // Manages dynamic content like homepage edits, categories, and menus.
                'Website Design Settings', // Design elements are secondary but necessary for customization.
                'Technical Settings', // These are less frequently updated but critical for technical configurations.
            ])
            ->navigationItems([
                NavigationItem::make('Reservation Settings')
                    ->url(
                        fn (): string => RestaurantDetails::getUrl([
                            'tab' => '-reservation-settings-tab'
                        ])
                    )
                    ->icon('heroicon-o-wrench')
                    ->group('Customer Engagement')
                    ->sort(1),
                NavigationItem::make('Testimonials')
                    ->url(
                        fn (): string => RestaurantDetails::getUrl([
                            'tab' => '-testimonials-tab'
                        ])
                    )
                    ->icon('heroicon-o-star')
                    ->group('Website Content Management')
                    ->sort(2),
                NavigationItem::make('Meta Details')
                    ->url(
                        fn (): string => RestaurantDetails::getUrl([
                            'tab' => '-meta-details-tab'
                        ])
                    )
                    ->icon('heroicon-o-code-bracket')
                    ->group('Website Content Management')
                    ->sort(3),
                NavigationItem::make('Social Media Icons')
                    ->url(
                        fn (): string => RestaurantDetails::getUrl([
                            'tab' => '-social-media-links-tab'
                        ])
                    )
                    ->icon('heroicon-o-squares-2x2')
                    ->group('Website Content Management')
                    ->sort(6),
                NavigationItem::make('Color Themes')
                    ->url(
                        fn (): string => RestaurantDetails::getUrl([
                            'tab' => '-color-themes-tab'
                        ])
                    )
                    ->icon('heroicon-o-swatch')
                    ->group('Website Design Settings')
                    ->sort(1),
                NavigationItem::make('Designs')
                    ->url(
                        fn (): string => RestaurantDetails::getUrl([
                            'tab' => '-designs-tab'
                        ])
                    )
                    ->icon('heroicon-o-sparkles')
                    ->group('Website Design Settings')
                    ->sort(2),
                NavigationItem::make('Scripts')
                    ->url(
                        fn (): string => RestaurantDetails::getUrl([
                            'tab' => '-scripts-tab'
                        ])
                    )
                    ->icon('heroicon-o-code-bracket-square')
                    ->group('Technical Settings')
                    ->sort(2),
                NavigationItem::make('Timezone')
                    ->url(
                        fn (): string => RestaurantDetails::getUrl([
                            'tab' => '-timezone-tab'
                        ])
                    )
                    ->icon('heroicon-o-globe-alt')
                    ->group('Technical Settings')
                    ->sort(3),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->spa()
            ->spaUrlExceptions([
                // '*/admin/posts/*',
            ])
            ->unsavedChangesAlerts()
            ->sidebarCollapsibleOnDesktop()
            ->defaultThemeMode(ThemeMode::Dark);
    }
}
