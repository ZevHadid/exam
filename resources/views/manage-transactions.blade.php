<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>

    <nav class="navbar bg-dark text-white justify-content-center fs-1">
        <a class="text-decoration-none text-reset" href="/">Home Page</a>
    </nav>
    
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container bg-dark text-white" style="margin-top: 80px; padding: 20px; border-radius: 10px;">
        <div class="table-responsive">
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>NIS</th>
                        <th>Member Name</th>
                        <th>Class</th>
                        <th>Jurusan</th>
                        <th>Book ID</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <form method="POST" action="/edit-transaction" id="edit-form-{{ $transaction->id }}">
                                @csrf
                                @method('PUT')
                                <td>
                                    <input type="hidden" name="id" value="{{ $transaction->id }}">
                                    <span class="form-control-plaintext text-white">{{ $transaction->id }}</span>
                                </td>
                                <td>
                                    <select name="member_id" class="form-control" form="edit-form-{{ $transaction->id }}" required>
                                        <option value="">Select Member</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ $transaction->member_id == $member->id ? 'selected' : '' }}>
                                                {{ $member->nis ?? $member->id }} - {{ $member->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>{{ $transaction->member->nama }}</td>
                                <td>{{ $transaction->member->kelas }}</td>
                                <td>{{ $transaction->member->jurusan }}</td>
                                <td>
                                    <select name="book_id" class="form-control" form="edit-form-{{ $transaction->id }}" required>
                                        <option value="">Select Book</option>
                                        @foreach($books as $book)
                                            <option value="{{ $book->id }}" {{ $transaction->book_id == $book->id ? 'selected' : '' }}>
                                                ID: {{ $book->id }} - {{ $book->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input 
                                        type="date" 
                                        name="tanngal_pinjam" 
                                        value="{{ $transaction->tanngal_pinjam instanceof \Carbon\Carbon ? $transaction->tanngal_pinjam->format('Y-m-d') : date('Y-m-d', strtotime($transaction->tanngal_pinjam)) }}"
                                        class="form-control"
                                        form="edit-form-{{ $transaction->id }}"
                                        required
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="date" 
                                        name="tanggal_kembali" 
                                        value="{{ $transaction->tanggal_kembali instanceof \Carbon\Carbon ? $transaction->tanggal_kembali->format('Y-m-d') : date('Y-m-d', strtotime($transaction->tanggal_kembali)) }}"
                                        class="form-control"
                                        form="edit-form-{{ $transaction->id }}"
                                        required
                                    >
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm w-100" type="submit" form="edit-form-{{ $transaction->id }}">
                                        Edit
                                    </button>
                            </form>
                                    <form method="POST" action="/delete-transaction" class="d-inline" id="delete-form-{{ $transaction->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $transaction->id }}">
                                        <button class="btn btn-danger btn-sm w-100" type="submit" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No transactions found.</td>
                        </tr>
                    @endforelse

                    <!-- New Transaction Form -->
                    <tr>
                        <form method="POST" action="/new-transaction" id="new-transaction-form">
                            @csrf
                            <td><span class="text-white">New</span></td>
                            
                            <td>
                                <select name="member_id" class="form-control" form="new-transaction-form" required>
                                    <option value="">Select NIS - Name</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}">
                                            {{ $member->nis ?? $member->id }} - {{ $member->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            
                            <td colspan="3">
                                <small class="text-muted">Member details will auto-fill</small>
                            </td>
                            
                            <td>
                                <select name="book_id" class="form-control" form="new-transaction-form" required>
                                    <option value="">Select Book ID - Title</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}">
                                            ID: {{ $book->id }} - {{ $book->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            
                            <td>
                                <input 
                                    type="date" 
                                    name="tanngal_pinjam" 
                                    class="form-control"
                                    form="new-transaction-form"
                                    value="{{ date('Y-m-d') }}"
                                    required
                                >
                            </td>
                            
                            <td>
                                <input 
                                    type="date" 
                                    name="tanggal_kembali" 
                                    class="form-control"
                                    form="new-transaction-form"
                                    value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                    required
                                >
                            </td>
                            
                            <td>
                                <button class="btn btn-success w-100" type="submit" form="new-transaction-form">
                                    Add
                                </button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>