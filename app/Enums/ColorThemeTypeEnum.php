<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ColorThemeTypeEnum: int implements HasLabel, HasColor, HasIcon
{
    case DEFAULT = 0;
    case CUSTOM = 1;

    /**
     * This function returns the default color theme type.
     */
    public static function default(): ColorThemeTypeEnum
    {
        return self::CUSTOM;
    }

    /**
     * Checks if the theme is the default theme.
     */
    public function isDefaultTheme(): bool
    {
        return $this === self::DEFAULT;
    }

    /**
     * Checks if the theme is a manual (custom) theme.
     */
    public function isManualTheme(): bool
    {
        return $this === self::CUSTOM;
    }

    /**
     * Returns the label for the color theme type.
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::DEFAULT => 'Default',
            self::CUSTOM => 'Custom',
        };
    }

    /**
     * Returns the color associated with the color theme type.
     */
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::DEFAULT => 'gray',
            self::CUSTOM => 'warning',
        };
    }

    /**
     * Returns the icon associated with the color theme type.
     */
    public function getIcon(): ?string
    {
        return match ($this) {
            self::DEFAULT => 'heroicon-m-paint-brush',
            self::CUSTOM => 'heroicon-m-swatch',
        };
    }

    /**
     * Returns the HTML representation of the color theme type.
     */
    public function getHTML(): ?string
    {
        return sprintf(
            '<span class="text-%s">%s</span>',
            $this->getColor(),
            $this->getLabel()
        );
    }
}
