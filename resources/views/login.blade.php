<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head
    <body>
        <nav class="navbar bg-dark text-white justify-content-center fs-1">Login Page</nav>

        <div class="container bg-dark rounded text-white" style="margin-top: 100px; padding: 80px 80px 20px 80px; max-width: 800px;">
            <form method="POST" action="/login">
                @csrf
                <input class="form-control" placeholder="Username" name="name">
                <br>
                <input class="form-control" placeholder="Password" name="password" type="password">
                <button class="btn btn-primary mt-3" type="submit">Login</button>

                <p class="mt-5">Don't have an account yet? Register <a href="/register">here!</a></p>
            </form>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>