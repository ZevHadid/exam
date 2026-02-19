<?php

use App\Models\Member;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Transaction;

Route::get("/", function () {
    return Auth::check() ? redirect('/home') : redirect('/login');
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', function(Request $request) {
    $credentials = $request->validate([
        'name'=> 'required|string',
        'password'=> 'required|string',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/home');
    }

    return back()->with('status', 'The provided credentials do not match our records.');
})->middleware('guest');

Route::get('/register', function () {
    return view('register');
})->middleware('guest')->name('register');

Route::post('/register', function(Request $request) {
    $account_data = $request->validate([
        'name'=> 'required|string|unique:users,name',
        'password'=> 'required|string|min:8',
    ]);
    $account_data['password'] = Hash::make($account_data['password']);
    $user = User::create($account_data);

    $member_data = $request->validate([
        'nis'=> 'required|string|unique:members,nis',
        'nama'=> 'required|string',
        'kelas'=> 'required|string',
        'jurusan'=> 'required|string',
    ]);
    $member_data['user_id'] = $user->id;
    Member::create($member_data);

    Auth::login($user);

    return redirect('/home');
})->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();                             
    return redirect('/login');
})->middleware('auth')->name('logout');

Route::get('/borrow-books', function () {
    $books = Book::all();
    return view('borrow-books', compact('books'));
})->middleware('auth')->name('borrow-books');

Route::get('/manage-books', function () {
    $books = Book::all();
    return view('manage-books', compact('books'));
})->middleware('auth')->name('manage-books');

Route::post('/new-book', function (Request $request) {
    $data = $request->validate([
        'judul'=> 'required|string',
        'pengarang'=> 'required|string',
        'penerbit'=> 'required|string',
        'tahun'=> 'required|integer',
    ]);
    Book::create($data);

    return redirect()->back()->with('status', 'Book added successfully!');
})->middleware('auth');

Route::put('/edit-book', function (Request $request) {
    $data = $request->validate([
        'id'=> 'required|exists:books,id',
        'judul' => 'required|string',
        'pengarang' => 'required|string',
        'penerbit' => 'required|string',
        'tahun' => 'required|integer',
    ]);

    $book = Book::findOrFail($request->id);
    $book->update($data);

    return redirect()->back()->with('status', 'Book updated seccessfully!');
})->middleware('auth');

Route::delete('/delete-book', function (Request $request) {
    $book = Book::findOrFail($request->id);
    $book->delete();
    return redirect()->back()->with('status', 'Book deleted successfully!');
})->middleware('auth');

Route::get('/manage-transactions', function () {
    $transactions = Transaction::with(['member', 'book'])->get();
    $members = Member::all();
    $books = Book::all();
    return view('manage-transactions', compact('transactions', 'members', 'books'));
})->middleware('auth')->name('manage-transactions');

Route::post('/new-transaction', function (Request $request) {
    $data = $request->validate([
        'member_id' => 'required|exists:members,id',
        'book_id' => 'required|exists:books,id',
        'tanngal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanngal_pinjam',
    ]);
    
    Transaction::create($data);
    
    return redirect()->back()->with('status', 'Transaction added successfully!');
})->middleware('auth');

Route::put('/edit-transaction', function (Request $request) {
    $data = $request->validate([
        'id' => 'required|exists:transactions,id',
        'member_id' => 'required|exists:members,id',
        'book_id' => 'required|exists:books,id',
        'tanngal_pinjam' => 'required|date',  // Changed to match DB column
        'tanggal_kembali' => 'required|date|after_or_equal:tanngal_pinjam',  // Changed reference
    ]);
    
    $transaction = Transaction::findOrFail($request->id);
    $transaction->update($data);
    
    return redirect()->back()->with('status', 'Transaction updated successfully!');
})->middleware('auth');

Route::delete('/delete-transaction', function (Request $request) {
    $transaction = Transaction::findOrFail($request->id);
    $transaction->delete();
    
    return redirect()->back()->with('status', 'Transaction deleted successfully!');
})->middleware('auth');

Route::get('/manage-members', function () {
    $users = User::all();
    $members = Member::with('user')->get();
    return view('manage-members', compact('users', 'members'));
})->middleware('auth')->name('manage-members');

// Create User
Route::post('/new-user', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'required|string|min:6',
        'role' => 'required|in:admin,user',
    ]);
    
    $data['password'] = Hash::make($data['password']);
    User::create($data);
    
    return redirect()->back()->with('status', 'User added successfully!');
})->middleware('auth');

// Edit User
Route::put('/edit-user', function (Request $request) {
    $data = $request->validate([
        'id' => 'required|exists:users,id',
        'name' => 'required|string|max:255',
        'role' => 'required|in:admin,user',
    ]);
    
    $user = User::findOrFail($request->id);
    $user->update($data);
    
    // Only update password if provided
    if ($request->filled('password')) {
        $request->validate(['password' => 'string|min:6']);
        $user->password = Hash::make($request->password);
        $user->save();
    }
    
    return redirect()->back()->with('status', 'User updated successfully!');
})->middleware('auth');

// Delete User
Route::delete('/delete-user', function (Request $request) {
    $user = User::findOrFail($request->id);
    $user->delete();
    
    return redirect()->back()->with('status', 'User deleted successfully!');
})->middleware('auth');

// ============ MEMBER CRUD ============
// Create Member
Route::post('/new-member', function (Request $request) {
    $data = $request->validate([
        'user_id' => 'nullable|exists:users,id',
        'nis' => 'required|integer|unique:members,nis',
        'nama' => 'required|string',
        'kelas' => 'required|string',
        'jurusan' => 'required|string',
    ]);
    
    Member::create($data);
    
    return redirect()->back()->with('status', 'Member added successfully!');
})->middleware('auth');

// Edit Member
Route::put('/edit-member', function (Request $request) {
    $data = $request->validate([
        'id' => 'required|exists:members,id',
        'user_id' => 'nullable|exists:users,id',
        'nis' => 'required|integer|unique:members,nis,' . $request->id,
        'nama' => 'required|string',
        'kelas' => 'required|string',
        'jurusan' => 'required|string',
    ]);
    
    $member = Member::findOrFail($request->id);
    $member->update($data);
    
    return redirect()->back()->with('status', 'Member updated successfully!');
})->middleware('auth');

// Delete Member
Route::delete('/delete-member', function (Request $request) {
    $member = Member::findOrFail($request->id);
    $member->delete();
    
    return redirect()->back()->with('status', 'Member deleted successfully!');
})->middleware('auth');