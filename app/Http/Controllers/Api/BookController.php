<?php

namespace App\Http\Controllers\api;

use App\Models\Book;
use App\Models\User;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        $user = User::find(1);
        $books = $user->books()->whereNull('deleted_at')->get();

        $booksFiltered = $books->map(function ($book) use ($user) {
            return [
                'title' => $book->title,
                'author' => $book->author,
                'isbn_code' => $book->isbn_code,
                'plot' => $book->plot,
                'readings' => $user->books->find($book->id)->pivot->readings,
            ];
        });

        return response()->json($booksFiltered);
    }

    public function show(string $id)
    {
        $user = User::find(1);
        $book = Book::find($id);

        if (!$book || !$user->books()->where('books.id', $book->id)->whereNull('deleted_at')->exists()) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $bookFiltered = [
            'title' => $book->title,
            'author' => $book->author,
            'isbn_code' => $book->isbn_code,
            'plot' => $book->plot,
            'readings' => $user->books->find($book->id)->pivot->readings,
        ];

        return response()->json($bookFiltered);
    }

    public function store(BookRequest $request)
    {
        $user = User::find(1);

        $book = new Book;
        $book->title        = $request->title;
        $book->author       = $request->author;
        $book->isbn_code    = $request->isbn_code;
        $book->plot         = $request->plot;
        $book->save();

        if ($book->save()) {
            $book->users()->attach($user->id, [
                'readings'      => $request->readings,
                'added_at'      => date('Y-m-d H:i:s'),
                'deleted_at'    => null,
            ]);
        }

        return response()->json(['message' => 'Book created'], 201);
    }

    public function update(BookRequest $request, string $id)
    {
        $user = User::find(1);
        $book = Book::find($id);

        if (!$book || !$user->books()->where('books.id', $book->id)->whereNull('deleted_at')->exists()) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->title        = is_null($request->title) ? $book->title : $request->title;
        $book->author       = is_null($request->author) ? $book->author : $request->author;
        $book->isbn_code    = is_null($request->isbn_code) ? $book->isbn_code : $request->isbn_code;
        $book->plot         = is_null($request->plot) ? $book->plot : $request->plot;
        $book->save();

        if ($book->save()) {
            $book->users()->updateExistingPivot($user->id, ['readings' => $request->readings]);
        }

        return response()->json(['message' => 'Book updated'], 200);
    }

    public function destroy(string $id)
    {
        $user = User::find(1);
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        } else if ($user->books()->where('books.id', $book->id)->whereNotNull('deleted_at')->exists()) {
            return response()->json(['message' => 'Book already deleted'], 404);
        }

        $book->users()->updateExistingPivot($user->id, ['deleted_at' => date('Y-m-d H:i:s')]);

        return response()->json(['message' => 'Book deleted'], 200);
    }

    public function add(BookRequest $request, string $id)
    {
        $user = User::find(1);
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        } else if ($user->books()->where('books.id', $book->id)->whereNull('deleted_at')->exists()) {
            return response()->json(['message' => 'Book already added'], 409);
        }

        if ($user->books()->where('books.id', $book->id)->whereNotNull('deleted_at')->exists()) {
            // update
            $book->users()->updateExistingPivot($user->id, [
                'readings'      => $request->readings,
                'added_at'      => date('Y-m-d H:i:s'),
                'deleted_at'      => null,
            ]);
        } else {
            // store
            $book->users()->attach($user->id, [
                'readings'      => $request->readings,
                'added_at'      => date('Y-m-d H:i:s'),
                'deleted_at'    => null,
            ]);
        }

        return response()->json(['message' => 'Book added'], 201);
    }
}
