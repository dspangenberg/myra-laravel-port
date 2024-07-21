<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookkeepingAccountResource;
use App\Models\BookkeepingAccount;
use Illuminate\Http\Request;

class BookkeepingAccountController extends Controller
{
    public function index()
    {
        return BookkeepingAccountResource::collection(BookkeepingAccount::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'account_number' => ['required', 'integer'],
            'name' => ['required'],
            'type' => ['required'],
        ]);

        return new BookkeepingAccountResource(BookkeepingAccount::create($data));
    }

    public function show(BookkeepingAccount $bookkeepingAccount)
    {
        return new BookkeepingAccountResource($bookkeepingAccount);
    }

    public function update(Request $request, BookkeepingAccount $bookkeepingAccount)
    {
        $data = $request->validate([
            'account_number' => ['required', 'integer'],
            'name' => ['required'],
            'type' => ['required'],
        ]);

        $bookkeepingAccount->update($data);

        return new BookkeepingAccountResource($bookkeepingAccount);
    }

    public function destroy(BookkeepingAccount $bookkeepingAccount)
    {
        $bookkeepingAccount->delete();

        return response()->json();
    }
}
