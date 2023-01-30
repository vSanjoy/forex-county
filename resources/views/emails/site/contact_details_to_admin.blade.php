@extends('emails.layouts.front')
    @section('content')
    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="color:#141414; font-size:15px;">@lang('custom_admin.label_hello') @lang('custom.label_administrator'),</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>@lang('custom.message_contact_success_submit')</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td width="20%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom.label_name')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="78%" align="left" valign="top" style="line-height:20px;">{!! $contactDetails['name'] !!}</td>
                    </tr>
                    <tr>
                        <td width="20%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom.label_email')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="78%" align="left" valign="top" style="line-height:20px;">{!! $contactDetails['email'] !!}</td>
                    </tr>
                    <tr>
                        <td width="20%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom.label_message')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="78%" align="left" valign="top" style="line-height:20px;">{!! $contactDetails['message'] !!}</td>
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
            <td style="color:#141414; font-size:15px; line-height: 20px;">@lang('custom.label_thanks_and_regards'),<br>{!! $siteSettings['tag_line'] !!}</td>
        </tr>
    </table>
    
  	@endsection