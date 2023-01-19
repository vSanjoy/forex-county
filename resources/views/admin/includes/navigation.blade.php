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
        <li class="menu-item active">
            <a href="{{ route('admin.account.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">{{ __('custom_admin.label_dashboard') }}</div>
            </a>
        </li>

        <!-- Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-coin-stack'></i>
                <div data-i18n="Cms">{{ __('custom_admin.label_cms') }}</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.cms.list') }}" class="menu-link">
                        <div data-i18n="Without menu">{{ __('custom_admin.label_list') }}</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.cms.create') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ __('custom_admin.label_create') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        
    </ul>
</aside>
