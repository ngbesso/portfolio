<?php

namespace App\Presentation\Http\Resources;

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource : Transformation Project pour API
 *
 * Transforme une entité Project en format JSON
 *
 * @package App\Presentation\Http\Resources
 */
class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'description' => $this->getDescription(),
            'image' => $this->getImage()
                ? asset('storage/' . $this->getImage())
                : null,
            'technologies' => $this->getTechnologies(),
            'url' => $this->getUrl()?->getValue(),
            'github_url' => $this->getGithubUrl()?->getValue(),
            'status' => $this->getStatus()->value,
            'featured' => $this->isFeatured(),
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
