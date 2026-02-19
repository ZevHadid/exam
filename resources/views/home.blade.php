<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head
    <body>

        <nav class="navbar bg-dark text-white justify-content-center fs-1">Home Page</nav>
        
        <div class="container d-flex justify-content-center justify-content-evenly" style="margin-top: 80px;">
            @if (auth()->user()->role == 'user')
                <a class="btn btn-primary" href="/borrow-books">Borrow Books</a>
                <a class="btn btn-primary" href="/return-books">Return Books</a>
            @else
                <a class="btn btn-primary" href="/manage-books">Manage Books</a>
                <a class="btn btn-primary" href="/manage-transactions">Manage Transactions</a>
                <a class="btn btn-primary" href="/manage-members">Manage Members</a>
            @endif

            <form method="POST" action="/logout">
                @csrf
                <button class="btn btn-danger" type="submit">Logout</button>
            </form>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
