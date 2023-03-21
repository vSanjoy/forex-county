<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->has('debug')) {
            return parent::toArray($request);
        }

        return [
            'id'                => $this->id,
            'full_name'         => $this->full_name ?? '',
            'first_name'        => $this->first_name ?? '',
            'last_name'         => $this->last_name ?? '',
            'full_name'         => $this->full_name ?? '',
            'email'             => $this->email ?? '',
            // 'password'          => $this->password ?? '',
            'address'           => $this->address ?? '',
            'country_id'        => $this->country_id ?? '',
            'country_phone_code'=> $this->countryDetails ? $this->countryDetails->country_code_for_phone : '',
            'country_flag_thumb'=> $this->countryDetails ? ($this->countryDetails->image != null ? asset('images/uploads/country/thumbs/'.$this->countryDetails->image) : asset('images/'.config('global.POST_NO_IMAGE'))) : asset('images/'.config('global.POST_NO_IMAGE')),
            'country_flag'      => $this->countryDetails ? ($this->countryDetails->image != null ? asset('images/uploads/country/'.$this->countryDetails->image) : asset('images/'.config('global.POST_NO_IMAGE'))) : asset('images/'.config('global.POST_NO_IMAGE')),
            'phone_no'          => $this->phone_no ?? '',
            '_authtoken'        => $this->auth_token ?? '',
            'dob'               => $this->userDetail ? ($this->userDetail->date_of_birth != null ? changeDateFormatFromUnixTimestamp(strtotime($this->userDetail->date_of_birth), 'd F Y') : '') : '',
        ];
    }
}
