<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app.css">

    <title>Urenbestand</title>
</head>
<body>
    <ul>
        @auth
        <form method="POST" action="{{ route('session.destroy') }}">
        @csrf
            <button type="submit">Uitloggen</button>
        </form>

        @else

        <li><a href="{{ route('auth.create') }}">Registreren</a></li>
        <li><a href="{{ route('login') }}">Inloggen</a></li>

        @endauth

    </ul>
    
    @yield('content')

</body>
</html>