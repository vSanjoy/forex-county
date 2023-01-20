@php
$cmsRoutes      = ['cms.list','cms.create','cms.edit'];
$countryRoutes  = ['country.list','country.create','country.edit'];
$currencyRoutes = ['currency.list','currency.create','currency.edit'];

// Current page route
$currentPageRoute = explode('admin.', Route::currentRouteName());
if (count($currentPageRoute) > 0) :
    $currentPage = $currentPageRoute[1];
else :
    $currentPage = Route::currentRouteName();
endif;
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.account.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                @include('admin.includes.logo')
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item @if ($currentPage == 'dashboard')active @endif">
            <a href="{{ route('admin.account.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">{{ __('custom_admin.label_dashboard') }}</div>
            </a>
        </li>

        <!-- Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('custom_admin.label_modules') }}</span>
        </li>
        <!-- CMS -->
        <li class="menu-item @if (in_array($currentPage, $cmsRoutes))active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon bx bxs-coin-stack'></i>
                <div data-i18n="Cms">{{ __('custom_admin.label_cms') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if ($currentPage === 'cms.list')active @endif">
                    <a href="{{ route('admin.cms.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
                <li class="menu-item @if ($currentPage === 'cms.create')active @endif">
                    <a href="{{ route('admin.cms.create') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ __('custom_admin.label_create') }}</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- / CMS -->
        <!-- Country -->
        <li class="menu-item @if (in_array($currentPage, $countryRoutes))active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon bx bx-globe'></i>
                <div data-i18n="Country">{{ __('custom_admin.label_country') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if ($currentPage === 'country.list')active @endif">
                    <a href="{{ route('admin.country.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
                <li class="menu-item @if ($currentPage === 'country.create')active @endif">
                    <a href="{{ route('admin.country.create') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ __('custom_admin.label_create') }}</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- / Country -->
        <!-- Currency -->
        <li class="menu-item @if (in_array($currentPage, $currencyRoutes))active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon bx bx-money'></i>
                <div data-i18n="Currency">{{ __('custom_admin.label_currency') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if ($currentPage === 'currency.list')active @endif">
                    <a href="{{ route('admin.currency.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
                <li class="menu-item @if ($currentPage === 'currency.create')active @endif">
                    <a href="{{ route('admin.currency.create') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ __('custom_admin.label_create') }}</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- / Currency -->


    </ul>
</aside>
