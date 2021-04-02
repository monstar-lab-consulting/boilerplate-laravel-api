<?php

namespace Modules\ElasticSearch\Http\Controllers;

use Core\Http\Controllers\Controller;
use Modules\ElasticSearch\Repositories\BookRepository;
use Modules\ElasticSearch\Http\Requests\SearchBookRequest;
use Modules\ElasticSearch\Http\Responses\SearchBookResponse;
use Modules\ElasticSearch\Models\Book;

class BookController extends Controller
{
    private $bookRepo;

    /**
     * Construct function
     *
     * @param BookRepository $bookRepo BookRepository
     */
    public function __construct(BookRepository $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    /**
     * Search function
     *
     * @param SearchBookRequest $request SearchBookRequest
     *
     * @return void
     */
    public function search(SearchBookRequest $request)
    {
        $data = $this->bookRepo->search();
        $responses = SearchBookResponse::collection($data);
        return $this->successResponse($responses);
    }

    /**
     * SearchView function
     *
     * @return void
     */
    public function searchView()
    {
        $books = Book::paginate(4);
        return view('ElasticSearch::search', compact('books'));
    }
}
