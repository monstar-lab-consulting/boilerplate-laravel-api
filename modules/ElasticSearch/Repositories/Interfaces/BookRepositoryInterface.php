<?php

namespace Modules\ElasticSearch\Repositories\Interfaces;

interface BookRepositoryInterface
{
    /**
     * Search function
     *
     * @return JsonResource
     */
    public function search();
}
