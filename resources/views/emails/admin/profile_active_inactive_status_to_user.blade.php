@extends('emails.layouts.app')
    @section('content')
    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="color:#141414; font-size:15px;">@lang('custom_admin.label_hello') {{ $user['first_name'] }},</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{!! trans('custom_admin.message_account_active_inactive_to_user', [ 'profileStatus' => $userStatus ]) !!}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="color:#141414; font-size:15px; line-height: 20px;">@lang('custom_admin.label_thanks_and_regards'),<br>{!! $siteSettings['tag_line'] !!}</td>
        </tr>
    </table>
    
  	@endsection