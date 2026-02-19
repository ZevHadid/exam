<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Manage Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>

    <nav class="navbar bg-dark text-white justify-content-center fs-1 mb-4">
        <a class="text-decoration-none text-reset" href="/">Home Page</a>
    </nav>
    
    @if (session('status'))
        <div class="alert alert-success alert-dismissable fade show d-flex justify-content-between container" role="alert">
            <div>
                <strong>Hey!</strong>
                <br>
                {{ session('status') }}
            </div>
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger container">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <!-- ============ USERS TABLE ============ -->
        <div class="bg-dark text-white p-3 mb-5" style="border-radius: 10px;">
            <h2 class="text-center mb-4">Manage Users</h2>
            <div class="table-responsive">
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Password</th>
                            <th>Created At</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <form method="POST" action="/edit-user" id="edit-user-{{ $user->id }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <span class="form-control-plaintext text-white">{{ $user->id }}</span>
                                    </form>
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        value="{{ $user->name }}"
                                        class="form-control"
                                        form="edit-user-{{ $user->id }}"
                                        required
                                    >
                                </td>
                                <td>
                                    <select name="role" class="form-control" form="edit-user-{{ $user->id }}" required>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                </td>
                                <td>
                                    <input 
                                        type="password" 
                                        name="password" 
                                        class="form-control"
                                        form="edit-user-{{ $user->id }}"
                                        placeholder="Leave blank to keep current"
                                    >
                                    <small class="text-muted">Min 6 chars</small>
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="submit" form="edit-user-{{ $user->id }}">
                                        Edit
                                    </button>
                                </td>
                                <td>
                                    <form method="POST" action="/delete-user" id="delete-user-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Delete this user?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No users found</td>
                            </tr>
                        @endforelse

                        <!-- New User Form -->
                        <tr>
                            <form method="POST" action="/new-user" id="new-user-form">
                                @csrf
                                <td><span class="text-white">New</span></td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        placeholder="Name"
                                        class="form-control"
                                        form="new-user-form"
                                        required
                                    >
                                </td>
                                <td>
                                    <select name="role" class="form-control" form="new-user-form" required>
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </td>
                                <td>
                                    <input 
                                        type="password" 
                                        name="password" 
                                        placeholder="Password"
                                        class="form-control"
                                        form="new-user-form"
                                        required
                                    >
                                    <small class="text-muted">Min 6 chars</small>
                                </td>
                                <td><span class="text-muted">Auto</span></td>
                                <td colspan="2">
                                    <button class="btn btn-success w-100" type="submit" form="new-user-form">
                                        Add User
                                    </button>
                                </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ============ MEMBERS TABLE ============ -->
        <div class="bg-dark text-white p-3 mb-5" style="border-radius: 10px;">
            <h2 class="text-center mb-4">Manage Members</h2>
            <div class="table-responsive">
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            <tr>
                                <td>
                                    <form method="POST" action="/edit-member" id="edit-member-{{ $member->id }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $member->id }}">
                                        <span class="form-control-plaintext text-white">{{ $member->id }}</span>
                                    </form>
                                </td>
                                <td>
                                    <select name="user_id" class="form-control" form="edit-member-{{ $member->id }}">
                                        <option value="">No User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $member->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->id }} - {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input 
                                        type="number" 
                                        name="nis" 
                                        value="{{ $member->nis }}"
                                        class="form-control"
                                        form="edit-member-{{ $member->id }}"
                                        required
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="nama" 
                                        value="{{ $member->nama }}"
                                        class="form-control"
                                        form="edit-member-{{ $member->id }}"
                                        required
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="kelas" 
                                        value="{{ $member->kelas }}"
                                        class="form-control"
                                        form="edit-member-{{ $member->id }}"
                                        required
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="jurusan" 
                                        value="{{ $member->jurusan }}"
                                        class="form-control"
                                        form="edit-member-{{ $member->id }}"
                                        required
                                    >
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="submit" form="edit-member-{{ $member->id }}">
                                        Edit
                                    </button>
                                </td>
                                <td>
                                    <form method="POST" action="/delete-member" id="delete-member-{{ $member->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $member->id }}">
                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Delete this member?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No members found</td>
                            </tr>
                        @endforelse

                        <!-- New Member Form -->
                        <tr>
                            <form method="POST" action="/new-member" id="new-member-form">
                                @csrf
                                <td><span class="text-white">New</span></td>
                                <td>
                                    <select name="user_id" class="form-control" form="new-member-form">
                                        <option value="">No User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->id }} - {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input 
                                        type="number" 
                                        name="nis" 
                                        placeholder="NIS"
                                        class="form-control"
                                        form="new-member-form"
                                        required
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="nama" 
                                        placeholder="Full Name"
                                        class="form-control"
                                        form="new-member-form"
                                        required
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="kelas" 
                                        placeholder="Class"
                                        class="form-control"
                                        form="new-member-form"
                                        required
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="jurusan" 
                                        placeholder="Major"
                                        class="form-control"
                                        form="new-member-form"
                                        required
                                    >
                                </td>
                                <td colspan="2">
                                    <button class="btn btn-success w-100" type="submit" form="new-member-form">
                                        Add Member
                                    </button>
                                </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>