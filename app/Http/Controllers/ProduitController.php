<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\User;
use Log;
use App\Http\Requests\StoreproduitRequest;
use App\Http\Requests\UpdateproduitRequest;

class ProduitController extends Controller
{
  /*  public function index()
    {
        $p = Produit::all();
        return view('produits.index', compact('p'));
    }*/
    public function index()
    {
        $users=User::get();
        foreach($users as $user){
            Log::info($user->reserver->nom);
    }
    }
    public function index2(){
        $user = User::find(1);
        foreach($user->d as $v){
            log::info($v->name);
        }
    }
    public function create()
    {
        return view('produits.create');
    }

    public function store(StoreproduitRequest $request)
    {
        Produit::create($request->validated());

        return redirect()->route('produits.index')
            ->with('success', 'Produit ajouté.');
    }

    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(UpdateproduitRequest $request, Produit $produit)
    {
        $produit->update($request->validated());

        return redirect()->back()
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();

        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé.');
    }
}
