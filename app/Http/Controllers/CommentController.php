<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
      public function store(Request $request, $produitId)
    {
        $produit = Produit::findOrFail($produitId);

        $produit->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return back();
    }
}