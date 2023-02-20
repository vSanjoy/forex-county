<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'id'                    => $this->id,
            'countryname'           => $this->countryname ?? '',
            'countrycode'           => $this->countrycode ?? '',
            'code'                  => $this->code ?? '',
            'country_code_for_phone'=> $this->country_code_for_phone ?? '',
            'thumb_image'           => $this->image != null ? asset('images/uploads/country/thumbs/'.$this->image) : asset('images/'.config('global.POST_NO_IMAGE')),
            'image'                 => $this->image != null ? asset('images/uploads/country/'.$this->image) : asset('images/'.config('global.POST_NO_IMAGE')),
        ];
    }
}
