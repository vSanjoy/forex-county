@extends('emails.layouts.app')
    @section('content')
    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="color:#141414; font-size:15px;">@lang('custom_admin.label_hello'),</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>@lang('custom_admin.message_registration_email')</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td width="20%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom_admin.label_email')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="78%" align="left" valign="top" style="line-height:20px;">{{$user['email']}}</td>
                    </tr>
                    <tr>
                        <td width="20%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom_admin.label_password')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="78%" align="left" valign="top" style="line-height:20px;">{{$password}}</td>
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
            <td style="color:#141414; font-size:15px; line-height: 20px;">@lang('custom_admin.label_thanks_and_regards'),<br>{!! $siteSetting->website_title !!}<br>{!! $siteSetting->tag_line !!}</td>
        </tr>
    </table>
    
  	@endsection