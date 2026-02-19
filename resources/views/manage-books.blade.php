<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>

        <nav class="navbar bg-dark text-white justify-content-center fs-1"><a class="text-decoration-none text-reset" href="/">Home Page</a></nav>

        @if (session('status'))
            <div class="alert alert-success alert-dismissable fade show d-flex justify-content-between" role="alert">
                <div>
                    <strong>Hey!</strong>
                    <br>
                    {{ session('status') }}
                </div>
                <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>
        @endif
        
        <div class="container d-flex justify-content-center bg-dark text-white" style="margin-top: 80px;">
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>book id</th>
                        <th>title</th>
                        <th>writer</th>
                        <th>publisher</th>
                        <th>published year</th>
                        <th>edit</th>
                        <th>delete</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <form method="POST" action="/edit-book" id="edit-form-{{ $book->id }}">
                                @csrf
                                @method('PUT')
                                <td>
                                    <input 
                                        name="id"
                                        value="{{ $book->id }}"
                                        placeholder="{{ $book->id }}"
                                        class="form-control"
                                        form="edit-form-{{ $book->id }}"
                                    >
                                </td>
                                <td>
                                    <input 
                                        name="judul"
                                        value="{{ $book->judul }}"
                                        placeholder="{{ $book->judul }}"
                                        class="form-control"
                                        form="edit-form-{{ $book->id }}"
                                    >
                                </td>
                                <td>
                                    <input 
                                        name="pengarang"
                                        value="{{ $book->pengarang }}"
                                        placeholder="{{ $book->pengarang }}"
                                        class="form-control"
                                        form="edit-form-{{ $book->id }}"
                                    >
                                </td>
                                <td>
                                    <input 
                                        name="penerbit"
                                        value="{{ $book->penerbit }}"
                                        placeholder="{{ $book->penerbit }}"
                                        class="form-control"
                                        form="edit-form-{{ $book->id }}"
                                    >
                                </td>
                                <td>
                                    <input 
                                        name="tahun"
                                        value="{{ $book->tahun }}"
                                        placeholder="{{ $book->tahun }}"
                                        class="form-control"
                                        form="edit-form-{{ $book->id }}"
                                    >
                                </td>
                                <td>
                                    <button class="btn btn-primary" type="submit" form="edit-form-{{ $book->id }}">
                                        edit
                                    </button>
                                </td>
                            </form>
                            <td>
                                <form method="POST" action="/delete-book" id="delete-form-{{ $book->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $book->id }}">
                                    <button class="btn btn-danger" type="submit">
                                        delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No books available</td>
                        </tr>
                    @endforelse
                    
                    <tr>
                        <form method="POST" action="/new-book" id="new-book-form">
                            @csrf
                            <td><span class="text-white">New</span></td>
                            <td>
                                <input 
                                    name="judul"
                                    placeholder="Title"
                                    class="form-control"
                                    form="new-book-form"
                                    required
                                >
                            </td>
                            <td>
                                <input 
                                    name="pengarang"
                                    placeholder="Writer"
                                    class="form-control"
                                    form="new-book-form"
                                    required
                                >
                            </td>
                            <td>
                                <input 
                                    name="penerbit"
                                    placeholder="Publisher"
                                    class="form-control"
                                    form="new-book-form"
                                    required
                                >
                            </td>
                            <td>
                                <input 
                                    name="tahun"
                                    type="number"
                                    placeholder="Published Year"
                                    class="form-control"
                                    form="new-book-form"
                                    required
                                >
                            </td>
                            <td colspan="2">
                                <button class="btn btn-success w-100" type="submit" form="new-book-form">
                                    Add New Book
                                </button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>