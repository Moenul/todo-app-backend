<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PriorityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'is_completed' => (bool) $this->is_completed,
            'created_at' => $this->created_at->timestamp * 1000,
            'priority' => PriorityResource::make($this->whenLoaded('priority')),
        ];
    }
}
