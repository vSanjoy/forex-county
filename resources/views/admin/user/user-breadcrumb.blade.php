<h6 class="fw-bold py-1 mb-4">
    <span class="text-muted fw-light">
        <a href="{{ route($routePrefix.'.account.dashboard') }}" class="">{{ __('custom_admin.label_dashboard') }}</a> /
    </span>
    <span class="text-muted fw-light">
        <a href="{{ route($routePrefix.'.'.$listUrl) }}" class="">{{ 'User List'}}</a> /
    </span>
    {{ 'Recipient List '}}
</h6>
