<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felhasználó hozzáadása</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { padding: 15px; border: 1px solid #ddd; width: 400px; }
        form input { display: block; margin: 10px 0; padding: 8px; width: 100%; }
        form button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        form button:hover { background-color: #45a049; }
        a { color: #4CAF50; text-decoration: none; margin-top: 10px; display: inline-block; }
    </style>
</head>
<body>
    <h2>Új felhasználó hozzáadása</h2>
    <form action="/felhasznalo/add" method="POST">
        @csrf
        <input type="text" name="nev" placeholder="Név" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Jelszó" required>
        <button type="submit">Hozzáadás</button>
    </form>
    
</body>
</html>