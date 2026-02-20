<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar bg-dark text-white justify-content-center fs-1">Home Page</nav>
    
    @if(session('status'))
        <div class="alert alert-success container mt-3">{{ session('status') }}</div>
    @endif
    
    <div class="container mt-4">
        @if (auth()->user()->role == 'user')
            <!-- User Section - All in one place -->
            <div class="row">
                <!-- Left Side: Borrow Form -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5>Borrow a Book</h5>
                        </div>
                        <div class="card-body">
                            <p>Welcome, <strong>{{ $member->nama }}</strong> ({{ $member->nis }})</p>
                            
                            <form method="POST" action="/borrow">
                                @csrf
                                <div class="mb-3">
                                    <label>Available Books</label>
                                    <select name="book_id" class="form-control" required>
                                        <option value="">Select a book...</option>
                                        @foreach($availableBooks as $book)
                                            <option value="{{ $book->id }}">
                                                {{ $book->judul }} - {{ $book->pengarang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Borrow Date</label>
                                        <input type="date" name="tanngal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Return Date</label>
                                        <input type="date" name="tanggal_kembali" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-success w-100" {{ $availableBooks->isEmpty() ? 'disabled' : '' }}>
                                    Borrow Book
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side: My Books -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5>My Books ({{ $myBooks->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($myBooks->isEmpty())
                                <p class="text-muted">You haven't borrowed any books yet.</p>
                            @else
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Book</th>
                                            <th>Borrowed</th>
                                            <th>Due</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($myBooks as $t)
                                        <tr>
                                            <td>{{ $t->book->judul }}</td>
                                            <td>{{ date('d/m/Y', strtotime($t->tanngal_pinjam)) }}</td>
                                            <td>
                                                {{ date('d/m/Y', strtotime($t->tanggal_kembali)) }}
                                                @if(now() > $t->tanggal_kembali)
                                                    <span class="badge bg-danger">Overdue</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form method="POST" action="/return/{{ $t->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-warning btn-sm">Return</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Logout Button -->
            <div class="mt-3 text-end">
                <form method="POST" action="/logout">
                    @csrf
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </div>
            
        @else
            <!-- Admin Section -->
            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-primary" href="/manage-books">Manage Books</a>
                <a class="btn btn-primary" href="/manage-transactions">Manage Transactions</a>
                <a class="btn btn-primary" href="/manage-members">Manage Members</a>
                
                <form method="POST" action="/logout">
                    @csrf
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>