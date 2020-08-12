<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the User resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\User $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'phones' => $this->phones,
            'emails' => $this->emails,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
