@extends('emails.layouts.app')
@section('content')
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="color:#141414; font-size:15px;">@lang('custom_api.label_hello') @lang('custom_api.label_administrator'),</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>@lang('custom_api.message_support_to_super_admin')</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td width="25%" align="left" valign="top"
                            style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom_api.label_full_name')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="73%" align="left" valign="top" style="line-height:20px;">{{ $user['full_name'] }}
                        </td>
                    </tr>
                    <tr>
                        <td width="25%" align="left" valign="top"
                            style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom_api.label_issue_type')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="73%" align="left" valign="top" style="line-height:20px;">
                            {{ $inputDetails['issue_type'] }}</td>
                    </tr>
                    <tr>
                        <td width="25%" align="left" valign="top"
                            style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom_api.label_question_or_issue')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="73%" align="left" valign="top" style="line-height:20px;">
                            {{ $inputDetails['question'] }}</td>
                    </tr>
                    <tr>
                        <td width="25%" align="left" valign="top"
                            style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom_api.label_email_for_replies')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="73%" align="left" valign="top" style="line-height:20px;">
                            {{ $inputDetails['email_for_replies'] }}</td>
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
            <td style="color:#141414; font-size:15px; line-height: 20px;">
                @lang('custom_api.label_thanks_and_regards'),<br>{!! $siteSetting->website_title !!}<br>{!! $siteSetting->tag_line !!}</td>
        </tr>
    </table>
@endsection
