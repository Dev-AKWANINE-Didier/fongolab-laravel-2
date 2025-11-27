<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de categorie</title>
</head>
<body>
    <h1>Les categories</h1>
    <a href="{{ route("admin-category-create") }}">Ajouter une categories</a>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category )  
            <tr>
                <td>{{ $category->name }}</td>
                <td>
                    <a href="">Voir</a>
                    <a href="">Modifier</a>
                    <a href="">Effacer</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>