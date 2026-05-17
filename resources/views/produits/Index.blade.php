<h2>Liste des Produits</h2>

@foreach ($p as $a)

<div class="produit">

    <h3>{{ $a->nom }}</h3>

    <form action="{{ route('comments.store', $a->id) }}" method="POST">
        @csrf

        <textarea name="body" placeholder="Votre commentaire"></textarea>

        <button type="submit">Commenter</button>
    </form>

</div>

@endforeach