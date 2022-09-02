<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray([
            'announcement_id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'active' => $this->active,
        ]);
    }
}
