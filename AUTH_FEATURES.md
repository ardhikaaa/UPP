# Fitur Register dan Login - Dokumentasi

## Fitur yang Telah Ditambahkan

### 1. **Register (Pendaftaran)**
- **Form Fields**: Nama lengkap, username, email, password, konfirmasi password
- **Validasi**: Validasi lengkap dengan pesan error dalam bahasa Indonesia
- **Username**: Harus unik dan hanya boleh berisi huruf, angka, dan underscore
- **Password**: Menggunakan Laravel Password Rules dengan konfirmasi
- **Terms**: Checkbox persetujuan terms of use dan privacy policy
- **Auto Login**: Setelah register berhasil, user langsung login

### 2. **Login (Masuk)**
- **Flexible Login**: Bisa login dengan email atau username
- **Remember Me**: Fitur "Remember me" untuk tetap login
- **Rate Limiting**: Pembatasan percobaan login (5x dalam 1 menit)
- **Error Handling**: Pesan error yang informatif dalam bahasa Indonesia
- **Redirect**: Redirect ke halaman yang dimaksud setelah login

### 3. **Logout (Keluar)**
- **Secure Logout**: Logout yang aman dengan invalidate session
- **CSRF Protection**: Perlindungan CSRF untuk semua form
- **Redirect**: Redirect ke halaman utama setelah logout

### 4. **Database & Model**
- **User Model**: Model User dengan field name, username, email, password
- **Migration**: Migration untuk menambahkan field username
- **Fillable**: Field yang bisa diisi secara massal

## Struktur Database

### Tabel Users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## Form Register

### Fields
1. **Nama Lengkap** (`name`)
   - Required
   - String, max 255 karakter

2. **Username** (`username`)
   - Required
   - String, max 255 karakter
   - Unique
   - Regex: hanya huruf, angka, dan underscore

3. **Email** (`email`)
   - Required
   - Email format
   - Unique
   - Lowercase

4. **Password** (`password`)
   - Required
   - Laravel Password Rules
   - Minimal 8 karakter
   - Harus dikonfirmasi

5. **Konfirmasi Password** (`password_confirmation`)
   - Required
   - Harus sama dengan password

6. **Terms** (`terms`)
   - Required
   - Checkbox untuk persetujuan

### Validasi Register
```php
$request->validate([
    'name' => ['required', 'string', 'max:255'],
    'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    'terms' => ['required', 'accepted'],
]);
```

## Form Login

### Fields
1. **Email atau Username** (`login`)
   - Required
   - String
   - Bisa email atau username

2. **Password** (`password`)
   - Required
   - String

3. **Remember Me** (`remember`)
   - Optional
   - Boolean

### Validasi Login
```php
$request->validate([
    'login' => ['required', 'string'],
    'password' => ['required', 'string'],
]);
```

### Authentication Logic
```php
$login = $this->input('login');
$password = $this->input('password');
$remember = $this->boolean('remember');

// Try to authenticate with email or username
if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
    $credentials = ['email' => $login, 'password' => $password];
} else {
    $credentials = ['username' => $login, 'password' => $password];
}

Auth::attempt($credentials, $remember);
```

## Rate Limiting

### Login Attempts
- **Max Attempts**: 5 kali dalam 1 menit
- **Lockout**: User diblokir sementara jika terlalu banyak percobaan
- **Throttle Key**: Berdasarkan email/username + IP address

### Implementation
```php
public function ensureIsNotRateLimited(): void
{
    if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
        return;
    }

    event(new Lockout($this));
    
    $seconds = RateLimiter::availableIn($this->throttleKey());
    
    throw ValidationException::withMessages([
        'login' => trans('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]),
    ]);
}
```

## Error Messages (Bahasa Indonesia)

### Auth Messages (`lang/id/auth.php`)
```php
return [
    'failed' => 'Email/username atau password salah.',
    'password' => 'Password yang diberikan salah.',
    'throttle' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam :seconds detik.',
];
```

### Validation Messages (`lang/id/validation.php`)
```php
'attributes' => [
    'name' => 'nama',
    'username' => 'username',
    'email' => 'email',
    'password' => 'password',
    'password_confirmation' => 'konfirmasi password',
    'login' => 'email atau username',
    'terms' => 'persyaratan',
],
```

## Routes

### Authentication Routes
```php
// Guest routes
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Auth routes
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
```

## Controllers

### RegisteredUserController
- **create()**: Menampilkan form register
- **store()**: Memproses pendaftaran user baru

### AuthenticatedSessionController
- **create()**: Menampilkan form login
- **store()**: Memproses login
- **destroy()**: Memproses logout

## Security Features

### 1. **CSRF Protection**
- Semua form dilindungi dengan CSRF token
- `@csrf` directive di semua form

### 2. **Password Hashing**
- Password di-hash menggunakan `Hash::make()`
- Menggunakan Laravel's default password hashing

### 3. **Session Security**
- Session regeneration setelah login
- Session invalidation setelah logout
- Remember token untuk "Remember me"

### 4. **Input Validation**
- Validasi server-side yang ketat
- Sanitasi input
- Protection terhadap SQL injection

## Customization

### Mengubah Password Rules
Edit di `RegisteredUserController`:
```php
'password' => ['required', 'confirmed', Rules\Password::defaults()],
```

### Mengubah Username Rules
Edit regex pattern:
```php
'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
```

### Mengubah Rate Limiting
Edit di `LoginRequest`:
```php
RateLimiter::tooManyAttempts($this->throttleKey(), 5) // Ganti 5 dengan angka yang diinginkan
```

### Mengubah Redirect After Login
Edit di `AuthenticatedSessionController`:
```php
return redirect()->intended(route('dashboard', absolute: false));
```

## Troubleshooting

### Register Tidak Berfungsi
1. Pastikan migration sudah dijalankan
2. Periksa field `username` sudah ada di database
3. Pastikan validasi tidak ada error
4. Periksa log Laravel untuk error detail

### Login Tidak Berfungsi
1. Pastikan user sudah terdaftar
2. Periksa email/username dan password benar
3. Pastikan tidak ada rate limiting
4. Periksa session configuration

### Error Messages Tidak Muncul
1. Pastikan file bahasa Indonesia sudah dibuat
2. Periksa konfigurasi locale di `config/app.php`
3. Clear cache: `php artisan config:clear`

### Username Tidak Unik
1. Pastikan field `username` di database memiliki constraint `UNIQUE`
2. Periksa apakah ada user dengan username yang sama
3. Jalankan migration ulang jika perlu

## Testing

### Manual Testing
1. **Register Test**:
   - Coba register dengan data valid
   - Coba register dengan username yang sudah ada
   - Coba register dengan email yang sudah ada
   - Coba register tanpa mengisi field required

2. **Login Test**:
   - Coba login dengan email
   - Coba login dengan username
   - Coba login dengan password salah
   - Coba login terlalu banyak kali (rate limiting)

3. **Logout Test**:
   - Login kemudian logout
   - Pastikan tidak bisa akses halaman yang memerlukan auth

### Automated Testing
Buat test cases untuk:
- Validasi register
- Validasi login
- Rate limiting
- Session management
- Error handling

## Performance

- **Database Indexing**: Field `email` dan `username` sudah di-index sebagai UNIQUE
- **Rate Limiting**: Mencegah brute force attack
- **Session Management**: Efficient session handling
- **Password Hashing**: Secure dan fast password hashing

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Dependencies

- Laravel 11.x
- PHP 8.2+
- MySQL/PostgreSQL/SQLite
- Tailwind CSS (untuk styling) 