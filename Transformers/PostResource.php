<?php

namespace Modules\Post\Transformers;

use Modules\User\Entities\User;
use Modules\User\Transformers\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'category' => new CategoryResource($this->category),
            'author' => new UserResource(User::find($this->created_by)),
        ]);
    }
}
