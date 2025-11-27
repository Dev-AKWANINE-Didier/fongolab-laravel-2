<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Utilisateur 
    @auth
        {{ auth()->user()->name }}
    @endauth
    <a href="{{ route("user-category-index") }}">Visiter les categories</a>
</h1>
</body>
</html>
