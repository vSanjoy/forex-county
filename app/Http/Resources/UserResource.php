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
            'password'          => $this->password ?? '',
            'country_id'        => $this->country_id ?? '',
            'country_phone_code'=> $this->countryDetails ? $this->countryDetails->country_code_for_phone : '',
            'phone_no'          => $this->phone_no ?? '',
            'auth_token'        => $this->auth_token ?? '',
        ];
    }
}
