<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head
    <body>

        <nav class="navbar bg-dark text-white justify-content-center fs-1">Register Page</nav>

        <div class="container bg-dark rounded text-white" style="margin-top: 100px; padding: 80px 80px 20px 80px; max-width: 800px;">
            <form method="POST" action="/register">
                @csrf
                <input class="form-control" placeholder="Username" name="name">
                <br>
                <input class="form-control" placeholder="Password" name="password" type="password">
                <br>
                <br>
                <input class="form-control" placeholder="full name" name="nama">
                <br>
                <input class="form-control" placeholder="nis" name="nis">
                <br>
                <input class="form-control" placeholder="class" name="kelas">
                <br>
                <select class="form-select" placeholder="field" name="jurusan">
                    <option value="RPL">RPL</option>
                    <option value="TKJ">TKJ</option>
                    <option value="MM">MM</option>
                    <option value="BC">BC</option>
                    <option value="TEI">TEI</option>
                    <option value="AKL">AKL</option>
                    <option value="OTKP">OTKP</option>
                    <option value="BDP">BDP</option>
                    <option value="HOTEI">HOTEI</option>
                    <option value="HTL">HTL</option>
                </select>

                <button class="btn btn-primary mt-3" type="submit">Register</button>

                <p class="mt-5">Already have an account? Log in <a href="/login">here!</a></p>
            </form>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
