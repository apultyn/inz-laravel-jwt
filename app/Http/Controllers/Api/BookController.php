<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\BookService;
use App\Http\Requests\SaveBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function __construct(private BookService $bookService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $searchString = $request->query('searchstring');
        $books = $this->bookService->getBooks($searchString);
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveBookRequest $req): JsonResponse
    {
        $book = $this->bookService->createBook($req->validated());
        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book): Book
    {
        return $book;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $req, Book $book)
    {
        $updatedBook = $this->bookService->updateBook($book, $req->validated());
        return response()->json($updatedBook);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $this->bookService->deleteBook($book);
    }
}
