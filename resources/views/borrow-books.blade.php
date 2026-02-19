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
        
        <div class="container d-flex justify-content-center bg-dark text-white" style="margin-top: 80px;">
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>book id</th>
                        <th>title</th>
                        <th>writer</th>
                        <th>publisher</th>
                        <th>year published</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->judul }}</td>
                            <td>{{ $book->pengarang }}</td>
                            <td>{{ $book->penerbit }}</td>
                            <td>{{ $book->tahun }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No books available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
