<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum UserRoleEnum: string implements HasLabel, HasColor, HasIcon {
    case ADMIN = 'ADMIN';
    // case EDITOR = 'EDITOR';
    // case CONTRIBUTOR = 'CONTRIBUTOR';
    case USER = 'USER';

    /**
     * This function will return default role for
     * any user that will use in migration running.
     * It can be changed from here.
     */
    public static function default(): UserRoleEnum
    {
        return self::USER;
    }

    /**
     * This function will check that if a user is
     * admin.
     * Use: {$user}->role->isAdmin();
     */
    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    /**
     * This function will check that if a user is
     * editor.
     * Use: {$user}->role->isEditor();
     */
    public function isEditor(): bool
    {
        // return $this === self::EDITOR;
        return false;
    }

    /**
     * This function will check that if a user is
     * contributor.
     * Use: {$user}->role->isContributor();
     */
    public function isContributor(): bool
    {
        // return $this === self::CONTRIBUTOR;
        return false;
    }

    /**
     * This function will return label text
     * for role defined for specific role.
     * Use: {$model}->role->getLabel();
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            // self::EDITOR => 'Editor',
            // self::CONTRIBUTOR => 'Contributor',
            self::USER => 'User',
        };
    }

    /**
     * This function will return color for different
     * role specified for a user.
     * Use: {$model}->role->getColor();
     */
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ADMIN => 'success',
            // self::EDITOR => 'info',
            // self::CONTRIBUTOR => 'warning',
            self::USER => 'gray',
        };
    }

    /**
     * This function will return icon name for
     * different role. Useful in filament v3
     * auto detect feature.
     * Use: {$model}->role->getIcon()
     */
    public function getIcon(): ?string
    {
        return match ($this) {
            self::ADMIN => 'heroicon-m-shield-check',
            // self::EDITOR => 'heroicon-o-users',
            // self::CONTsRIBUTOR => 'heroicon-o-user-group',
            self::USER => 'heroicon-m-user',
        };
    }

    /**
     * This function will return role html badge
     * in html. Esay to use in dropdown or page.
     * Use: {$model}->role->getHTML();
     */
    public function getHTML(): ?string
    {
        return sprintf('<span class="%s">%s</span>',
            $this->getColor(), $this->getLabel(),
        );
    }
}
