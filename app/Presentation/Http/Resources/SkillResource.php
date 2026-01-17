<?php

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource : Transformation Skill pour API
 *
 * @package App\Presentation\Http\Resources
 */
class SkillResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'slug' => $this->getSlug(),
            'category' => $this->getCategory(),
            'level' => $this->getLevel()->value,
            'level_label' => $this->getLevel()->label(),
            'level_percentage' => $this->getLevel()->percentage(),
            'icon' => $this->getIcon(),
        ];
    }
}
