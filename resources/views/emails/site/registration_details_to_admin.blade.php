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
            <td>@lang('custom.message_new_account_created_to_admin')</td>
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
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom.label_first_name')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{{ $user['first_name'] }}</td>
                    </tr>
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom.label_last_name')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{{ $user['last_name'] }}</td>
                    </tr>
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom.label_email')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{{ $user['email'] }}</td>
                    </tr>
                    @if ($user['phone_no'])
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">@lang('custom.label_your_phone_number')</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{{ $user['phone_no'] }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Gender</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">
                            @if ($user['gender'] == 'M')Male @elseif ($user['gender'] == 'F')Female @else Prefer not to answer @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Date of Birth</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{!! date('m/d/Y', strtotime($user['dob'])) !!}</td>
                    </tr>
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Player Rating</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">
                            {{ formatToTwoDecimalPlaces($user['player_rating'])}} @if ($user['player_rating'] == 5.50)+ @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Preferred Home Court</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{!! $playingDetails['home_court'] !!}</td>
                    </tr>
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Address Line 1</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{!! $playingDetails['address_line_1'] !!}</td>
                    </tr>

                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Address Line 2</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{!! $playingDetails['address_line_2'] !!}</td>
                    </tr>
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">City</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{!! $playingDetails['city'] !!}</td>
                    </tr>
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">State</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{!! $playingDetails['state'] !!}</td>
                    </tr>
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Zip</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{!! $playingDetails['zip'] !!}</td>
                    </tr>
                    @if ($playingDetails['how_did_you_find_us'])
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">How Did You Hear About Us?</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{!! $playingDetails['how_did_you_find_us'] !!}</td>
                    </tr>
                    @endif
                    <tr>
                        <td width="40%" align="left" valign="top" style="color:#141414; font-weight:bold; line-height:20px;">Availablity</td>
                        <td width="2%" align="left" valign="top" style="line-height:20px;">:</td>
                        <td width="58%" align="left" valign="top" style="line-height:20px;">{!! $playingDetails['availability'] !!}</td>
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