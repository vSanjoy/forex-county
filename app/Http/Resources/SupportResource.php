<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
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
            'customer'              => $this->userDetails ? $this->userDetails->full_name : '',
            'issue_type'            => $this->issue_type ?? '',
            'question'              => $this->question ?? '',
            'email_for_replies'     => $this->email_for_replies ?? '',
            'posted_on'             => $this->created_at != null ? changeDateFormatFromUnixTimestamp(strtotime($this->created_at), 'd F Y H:i') : '',
        ];
    }
}
