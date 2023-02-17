@php
$cmsRoutes          = ['admin.cms.list','admin.cms.create','admin.cms.edit'];
$countryRoutes      = ['admin.country.list','admin.country.create','admin.country.edit'];
$currencyRoutes     = ['admin.currency.list','admin.currency.create','admin.currency.edit','admin.currency.transfer-fees.transfer-fees-list','admin.currency.transfer-fees.transfer-fees-create','admin.currency.transfer-fees.transfer-fees-edit'];
$bankRoutes         = ['admin.bank.list','admin.bank.create','admin.bank.edit'];
$moneyTransferRoutes= ['admin.money-transfer.list'];
$userRoutes          = ['admin.user.list','admin.user.create'];

// Current page route
// $currentPageRoute = explode('admin.', Route::currentRouteName());
// if (count($currentPageRoute) > 0) :
//     $currentPage = $currentPageRoute[1];
// else :
//     $currentPage = Route::currentRouteName();
// endif;

// dd($currentPage, $currencyRoutes);
$currentPage = Route::currentRouteName();

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
        <li class="menu-item @if ($currentPage == 'admin.account.dashboard')active @endif">
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
                <li class="menu-item @if(request()->routeIs('admin.cms.list')) active @endif">
                    <a href="{{ route('admin.cms.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
                <li class="menu-item @if(request()->routeIs('admin.cms.create')) active @endif">
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
                <li class="menu-item @if(request()->routeIs('admin.country.list')) active @endif">
                    <a href="{{ route('admin.country.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
                <li class="menu-item @if(request()->routeIs('admin.country.create')) active @endif">
                    <a href="{{ route('admin.country.create') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ __('custom_admin.label_create') }}</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- / Country -->
        <!-- Currency & Transfer Fees -->
        {{-- <li class="menu-item @if (in_array($currentPage, $currencyRoutes))active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon bx bx-money'></i>
                <div data-i18n="Currency">{{ __('custom_admin.label_currency') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('admin.currency.list') || request()->routeIs('admin.transfer-fees.transfer-fees-list')) active @endif">
                    <a href="{{ route('admin.currency.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
                <li class="menu-item @if(request()->routeIs('admin.currency.create')) active @endif">
                    <a href="{{ route('admin.currency.create') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ __('custom_admin.label_create') }}</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        <!-- / Currency & Transfer Fees -->
        <!-- Bank -->
        {{-- <li class="menu-item @if (in_array($currentPage, $bankRoutes))active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-bank'></i>
                <div data-i18n="Cms">{{ __('custom_admin.label_banks') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('admin.bank.list')) active @endif">
                    <a href="{{ route('admin.bank.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
                <li class="menu-item @if(request()->routeIs('admin.bank.create')) active @endif">
                    <a href="{{ route('admin.bank.create') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ __('custom_admin.label_create') }}</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        <!-- / Bank -->
        <!-- Money Transfer -->
        {{-- <li class="menu-item @if (in_array($currentPage, $moneyTransferRoutes))active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-credit-card'></i>
                <div data-i18n="Cms">{{ __('custom_admin.label_money_transfer') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('admin.money-transfer.list')) active @endif">
                    <a href="{{ route('admin.money-transfer.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        <!-- / Money Transfer -->

        <!-- User Transfer -->
        {{-- <li class="menu-item @if (in_array($currentPage, $userRoutes))active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-user'></i>
                <div data-i18n="Cms">{{ __('custom_admin.label_user') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('admin.user.list')) active @endif">
                    <a href="{{ route('admin.user.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
                <li class="menu-item @if(request()->routeIs('admin.user.create')) active @endif">
                    <a href="{{ route('admin.user.create') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_create') }}</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        <!-- / User Transfer -->

    </ul>
</aside>
