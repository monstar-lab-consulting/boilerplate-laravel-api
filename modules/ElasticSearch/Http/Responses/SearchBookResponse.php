<?php

namespace Modules\ElasticSearch\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchBookResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($request)
    {
        return [
            'id'            => (int) $this->id,
            'title'         => (string) $this->title,
            'limit_date'    => (int) $this->limit_date,
            'status'        => (int) $this->status,
            'price'         => (int) $this->price,
        ];
    }
}
