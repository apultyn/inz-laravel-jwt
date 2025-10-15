<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookService
{
    public function getAllBooks(): Collection
    {
        return Book::All();
    }

    public function createBook(array $data): Book
    {
        return Book::create($data);
    }

    public function updateBook(Book $book, array $data): Book
    {
        $book->update($data);
        return $book;
    }

    public function deleteBook(Book $book) : Bool
    {
        $book->delete();
        return true;
    }
}