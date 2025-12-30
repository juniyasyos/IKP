<?php

namespace App\Providers\Filament;

use Andreia\FilamentNordTheme\FilamentNordThemePlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Resma\FilamentAwinTheme\FilamentAwinTheme;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $ssoEnabled = config('iam.enabled', false) || env('USE_SSO', false);

        $panel = $panel
            ->default()
            ->id('')
            ->path('')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->sidebarCollapsibleOnDesktop(true)
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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
            ->plugins([
                FilamentAwinTheme::make(),
                FilamentShieldPlugin::make()
                    ->navigationLabel('Label')                  // string|Closure|null
                    ->navigationIcon('heroicon-o-home')         // string|Closure|null
                    ->activeNavigationIcon('heroicon-s-home')   // string|Closure|null
                    ->navigationGroup('Group')                  // string|Closure|null
                    ->navigationSort(10)                        // int|Closure|null
                    ->navigationBadge('5')                      // string|Closure|null
                    ->navigationBadgeColor('success')           // string|array|Closure|null
                    ->navigationParentItem('parent.item')       // string|Closure|null
                    ->registerNavigation(true)                  // bool|Closure
                    ->modelLabel('Model')                       // string|Closure|null
                    ->pluralModelLabel('Models')                // string|Closure|null
                    ->recordTitleAttribute('name')              // string|Closure|null
                    ->titleCaseModelLabel(false)               // bool|Closure
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

        if (!$ssoEnabled) {
            $panel->login(\App\Filament\Pages\Auth\Login::class);
        }

        return $panel;
    }
}
