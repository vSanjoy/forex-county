@extends('emails.layouts.front')
    @section('content')

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="color:#141414; font-size:15px;">@lang('custom_admin.label_hello') {{ $userDetails['first_name'] }},</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>@lang('custom.message_reset_password_link')</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="90%" align="left" valign="top" style="line-height:20px;">
                            OTP: {{ $rememberToken }}
                        </td>
                    </tr>
                </table>
            </td>
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
            <td style="color:#141414; font-size:15px; line-height: 20px;">@lang('custom.label_thanks_and_regards'),<br>{!! $siteSettings['website_title'] !!}</td>
        </tr>
    </table>
    
  	@endsection