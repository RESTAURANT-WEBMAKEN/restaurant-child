<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\HolidayMessagePage;
use App\Filament\Pages\HomePageEdit;
use App\Filament\Pages\RestaurantDetails;
use App\Filament\Pages\RollingMessagePage;
use App\Filament\Resources\ColorThemeResource;
use App\Filament\Resources\ReservationResource;
use App\Filament\Resources\UserResource;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\HtmlString;

class MenuStatsOverview extends BaseWidget
{
    private function getHtmlLabel($label)
    {
        return new HtmlString("<span class='text-defaultWhite'>$label</span>");
    }

    private function getStatsDetails()
    {
        return [
            // Rows of 3, alternating between design 1 and design 2
            ['label' => 'Users', 'icon' => 'user-group', 'design' => 'bg-gradient-cursor-design-1', 'url' => UserResource::getUrl()],
            ['label' => 'Restaurant Details', 'icon' => 'building-storefront', 'design' => 'bg-gradient-cursor-design-1', 'url' => RestaurantDetails::getUrl()],
            ['label' => 'Homepage Edits', 'icon' => 'pencil-square', 'design' => 'bg-gradient-cursor-design-1', 'url' => HomePageEdit::getUrl()],

            ['label' => 'Rolling Message', 'icon' => 'tv', 'design' => 'bg-gradient-cursor-design-2', 'url' => RollingMessagePage::getUrl()],
            ['label' => 'Reviews', 'icon' => 'star', 'design' => 'bg-gradient-cursor-design-2', 'url' => RestaurantDetails::getUrl(['tab' => '-testimonials-tab'])],
            ['label' => 'Opening Hours', 'icon' => 'clock', 'design' => 'bg-gradient-cursor-design-2', 'url' => null],

            ['label' => 'Meta Details', 'icon' => 'code-bracket', 'design' => 'bg-gradient-cursor-design-1', 'url' => RestaurantDetails::getUrl(['tab' => '-meta-details-tab'])],
            ['label' => 'Create Categories', 'icon' => 'squares-plus', 'design' => 'bg-gradient-cursor-design-1', 'url' => null],
            ['label' => 'Menu Special Options', 'icon' => 'list-bullet', 'design' => 'bg-gradient-cursor-design-1', 'url' => null],

            ['label' => 'Create Menu', 'icon' => 'table-cells', 'design' => 'bg-gradient-cursor-design-2', 'url' => null],
            ['label' => 'Reservation Settings', 'icon' => 'wrench', 'design' => 'bg-gradient-cursor-design-2', 'url' => null],
            ['label' => 'Social Media Icons', 'icon' => 'squares-2x2', 'design' => 'bg-gradient-cursor-design-2', 'url' => RestaurantDetails::getUrl(['tab' => '-social-media-links-tab'])],

            ['label' => 'Color Themes', 'icon' => 'swatch', 'design' => 'bg-gradient-cursor-design-1', 'url' => ColorThemeResource::getUrl()],
            ['label' => 'Designs', 'icon' => 'sparkles', 'design' => 'bg-gradient-cursor-design-1', 'url' => null],
            ['label' => 'Holiday Message', 'icon' => 'bell', 'design' => 'bg-gradient-cursor-design-1', 'url' => HolidayMessagePage::getUrl()],

            ['label' => 'Scripts', 'icon' => 'code-bracket-square', 'design' => 'bg-gradient-cursor-design-2', 'url' => null],
            ['label' => 'Time Zone', 'icon' => 'globe-alt', 'design' => 'bg-gradient-cursor-design-2', 'url' => RestaurantDetails::getUrl(['tab' => '-timezone-tab'])],
            ['label' => 'Reservations & Orders', 'icon' => 'shopping-cart', 'design' => 'bg-gradient-cursor-design-2', 'url' => ReservationResource::getUrl()],
        ];

    }

    protected function getStats(): array
    {
        return collect($this->getStatsDetails())
            ->map(function ($item) {
                return Stat::make('', $this->getHtmlLabel($item['label']))
                    ->icon("heroicon-s-{$item['icon']}")
                    ->url($item['url'])
                    ->extraAttributes(['class' => $item['design'] . " px-2 py-2"]);
            })->all();

    }
}
