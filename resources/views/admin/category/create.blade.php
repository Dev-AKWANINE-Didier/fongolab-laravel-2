<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation de la categorie</title>
</head>
<body>
    <h1>Addition d'une categorie</h1>

    <section>
        <form action="{{ route("admin-category-store") }}" method="post">
            @csrf
            <div>
                <label for="name">Nom de la categorie</label><br>
                <input type="text" name="name" id="name">
                @error("name")    
                    <p style="color:red">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit">Enregistrer</button>
            </div>
        </form>
    </section>
</body>
</html>