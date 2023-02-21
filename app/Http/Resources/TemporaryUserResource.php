<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemporaryUserResource extends JsonResource
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
            'id'            => $this->id,
            'full_name'     => $this->full_name ?? '',
            'first_name'    => $this->first_name ?? '',
            'last_name'     => $this->last_name ?? '',
            'full_name'     => $this->full_name ?? '',
            'email'         => $this->email ?? '',
            'country_id'    => $this->country_id ?? '',
            'phone_no'      => $this->phone_no ?? '',
            'token'         => $this->token ?? '',
        ];
    }
}
