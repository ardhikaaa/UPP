<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Selamat Datang | SMK PESAT ITXPRO</title>
  @vite('resources/css/app.css') 
</head>
<body class="antialiased font-sans">

  <!-- Fullscreen hero, tidak bisa scroll -->
  <main class="min-h-screen w-full overflow-hidden">

    <!-- Background image + gradient overlay -->
    <div
      class="relative min-h-screen w-full bg-center bg-cover"
      style="background-image: url('{{ asset('images/PesatGdng.webp') }}');"
      aria-hidden="true"
    >
      <!-- overlay gradasi: biru (kiri) -> kuning (kanan) -->
      <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 via-transparent backdrop-blur-sm to-yellow-/60"></div>

      <!-- Konten tetap di satu layar, text di kiri -->
      <div class="relative z-10 max-w-7xl mx-auto h-screen flex items-center px-6 md:px-12">
        
        <!-- Kolom teks (left) -->
        <div class="text-left">
          <!-- KOTAK BACKGROUND -->
          <div class="bg-black/40 backdrop-blur-sm p-6 md:p-8 rounded-xl shadow-lg text-white">
            
            <!-- Logo (opsional) -->
            <div class="flex items-center gap-4">
              <img src="{{ asset('images/PesatOri.png') }}" alt="Logo SMK PESAT ITXPRO" class="w-24 h-24 object-contain">
              <div>
                <h2 class="text-lg font-semibold tracking-wide">PESAT</h2>
                <p class="text-sm opacity-90">Unit Kesehatan Sekolah</p>
              </div>
            </div>

            <!-- Judul besar -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight drop-shadow-md mt-4">
              Selamat Datang di Unit Kesehatan Sekolah PESAT
            </h1>

            <!-- Tagline / quote -->
            <p class="mt-4 text-base md:text-lg max-w-xl text-white/90">
              "Sehat, Siap, Berprestasi." Sistem informasi UKS untuk memastikan kesehatan siswa selalu terpantau dan mendapat layanan terbaik.
            </p>

            <!-- Tombol aksi -->
            @if (Route::has('login'))
              <div class="links mt-8 flex flex-wrap gap-4">
                  @auth
                      <a href="{{ url('/kunjungan_uks') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow">
                        Dashboard</a>
                  @else
                      <a href="{{ route('login') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow">
                        Log in</a>
                      @if (Route::has('register'))
                          <a href="{{ route('register') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg shadow">
                            Register</a>
                      @endif
                  @endauth
              </div>
            @endif
          </div>
        </div>

        <!-- Area kosong kanan agar foto tetap terlihat -->
        <div class="hidden md:block md:w-1/2"></div>
      </div>
    </div>

  </main>

</body>
</html>
