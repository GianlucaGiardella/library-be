<?php

namespace App\Http\Controllers\api;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    private $validations = [
        'title'         => 'required|string|min:2|max:80',
        'author'        => 'required|string|min:2|max:50',
        'isbn_code'     => 'required|digit:13|unique',
        'plot'          => 'required|text|min:2',
        'readings'      => 'required|integer|min:0',
    ];

    private $messages = [
        'required'      => 'Field required',
        'exists'        => 'Does not exist.',
        'size'          => 'The :attribute must be exactly :size numbers.',
        'min'           => 'At least :min characters.',
        'max'           => 'Must not exceed :max characters.',
    ];

    private function formatISBN(string $isbn)
    {
        return str_replace('-', '', $isbn);
    }

    public function index()
    {
        $user = User::find(1);
        $books = $user->books()->get();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $this->formatISBN($request->input('isbn_code'));
        $request->validate($this->validations, $this->messages);

        $book = new Book;
        $book->title        = $request->title;
        $book->author       = $request->author;
        $book->isbn_code    = $request->isbn_code;
        $book->plot         = $request->plot;

        if ($book->save()) {
            $book->users()->attach(2, [
                'readings'      => $request->readings,
                'added_at'      => date('Y-m-d H:i:s'),
                'deleted_at'    => null,
            ]);
        }

        return response()->json(['message' => 'Book added'], 201);
    }

    public function show(string $id)
    {
        $book = Book::find($id);

        if (!empty($book) && User::find(2)->books()->wherePivot('deleted_at', null)) {
            return response()->json($book);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        $this->formatISBN($request->input('isbn_code'));
        $request->validate($this->validations, $this->messages);

        if (Book::where('id', $id)->exists()) {
            $book = Book::find($id);
            $book->title        = is_null($request->title) ? $book->title : $request->title;
            $book->author       = is_null($request->author) ? $book->author : $request->author;
            $book->isbn_code    = is_null($request->isbn_code) ? $book->isbn_code : $request->isbn_code;
            $book->plot         = is_null($request->plot) ? $book->plot : $request->plot;
            $book->save();

            if ($book->save()) {
                $book->updatePivot(['readings' => $request->readings]);
            }

            return response()->json(['message' => 'Book updated'], 200);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }

    public function destroy(string $id)
    {
        if (Book::where('id', $id)->exists()) {
            $user = User::find(1);
            $book = Book::find($id);
            $book->updatePivot(['deleted_at' => date('Y-m-d H:i:s')]);

            return response()->json(['message' => 'Book deleted'], 200);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }
}
