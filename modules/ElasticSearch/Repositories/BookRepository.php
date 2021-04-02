<?php

namespace Modules\ElasticSearch\Repositories;

use Core\Repositories\Repository;
use Modules\ElasticSearch\Models\Book;
use Modules\ElasticSearch\Repositories\Interfaces\BookRepositoryInterface;

class BookRepository extends Repository implements BookRepositoryInterface
{
    /**
     * GetModel function
     *
     * @return void
     */
    public function getModel()
    {
        return Book::class;
    }

    /**
     * Search function
     *
     * @return JsonResource
     */
    public function search()
    {
        $books = Book::all();
        return $books;
    }
}
