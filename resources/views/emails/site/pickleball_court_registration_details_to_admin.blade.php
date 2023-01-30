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
            <td>@lang('custom.message_new_pickleball_court_created_to_admin')</td>
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
                        <td width="30%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Court Name</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="68%" align="left" valign="top" style="line-height:20px;">{{ $newPickleballCourt['title'] }}</td>
                    </tr>
                    <tr>
                        <td width="30%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">State</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="68%" align="left" valign="top" style="line-height:20px;">{{ $stateName }}</td>
                    </tr>
                    <tr>
                        <td width="30%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">City</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="68%" align="left" valign="top" style="line-height:20px;">{{ $newPickleballCourt['city'] }}</td>
                    </tr>
                    <tr>
                        <td width="30%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Address</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="68%" align="left" valign="top" style="line-height:20px;">{{ $newPickleballCourt['address'] }}</td>
                    </tr>
                    <tr>
                        <td width="30%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Zip</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="68%" align="left" valign="top" style="line-height:20px;">{!! $newPickleballCourt['zip'] !!}</td>
                    </tr>
                    <tr>
                        <td width="30%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Number of Courts</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="68%" align="left" valign="top" style="line-height:20px;">{!! $newPickleballCourt['number_of_courts'] !!}</td>
                    </tr>
                    <tr>
                        <td width="30%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Accessibility</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="68%" align="left" valign="top" style="line-height:20px;">
                            @if ($newPickleballCourt['accessibility'] == 'PL')Public @else Private @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Outdoor/Indoor</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="68%" align="left" valign="top" style="line-height:20px;">
                            @if ($newPickleballCourt['indoor_outdoor'] == 'OD')Outdoor @elseif ($newPickleballCourt['indoor_outdoor'] == 'ID')Indoor @else Both @endif
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
            <td style="color:#141414; font-size:15px; line-height: 20px;">@lang('custom.label_thanks_and_regards'),<br>{!! $siteSettings['tag_line'] !!}</td>
        </tr>
    </table>
    
  	@endsection