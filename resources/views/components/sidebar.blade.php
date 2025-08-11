<!-- Mobile Menu Button -->
<div class="lg:hidden fixed top-4 left-4 z-50">
    <button id="sidebar-toggle" class="p-2 bg-yellow-50 rounded-lg shadow-lg border border-yellow-200 hover:bg-yellow-100 transition-colors">
        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
</div>

<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 h-screen bg-white border-r flex flex-col justify-between px-4 py-6 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg lg:shadow-none">
  <!-- Top Logo + App Name -->
  <div>
    <div class="flex items-center justify-between mb-10">
    <a href="/kunjungan_uks">
      <div class="flex items-center space-x-3">
        <img src="assets/logo-uks.png" alt="Logo" class="w-15 h-10" />
        <h1 class="text-lg font-semibold">UPP</h1>
      </div>
    </a>
      <!-- Close button for mobile -->
      <button id="sidebar-close" class="lg:hidden p-1 rounded-lg hover:bg-gray-100 transition-colors">
        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Menu Items -->
    <nav class="flex flex-col gap-2 ">
      <a href="/kunjungan_uks" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
    {{ request()->is('kunjungan_uks') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600  hover:bg-gray-50' }}">
        <svg class="w-5 h-5 {{ request()->is('kunjungan_uks*') ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
          <path d="M3 3h14a1 1 0 011 1v3H2V4a1 1 0 011-1zM2 8h16v2H2V8zm0 4h16v2H2v-2zm0 4h16v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-1z" />
        </svg>
        <span class="hidden sm:inline ">Data Kunjungan UKS</span>
        <span class="sm:hidden">Dashboard</span>
      </a>
      <a href="/obat" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
    {{ request()->is('obat') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
        <svg class="w-5 h-5 {{ request()->is('obat*') ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
          <path d="M3 3h14a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4a1 1 0 011-1zm2 3v2h10V6H5zm0 4v2h10v-2H5z" />
        </svg>
        <span class="hidden sm:inline">Data Obat</span>
        <span class="sm:hidden">Obat</span>
      </a>
      <a href="/guru" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
    {{ request()->is('guru') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
        <svg class="w-5 h-5 {{ request()->is('guru*') ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
          <path d="M3 3h14a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4a1 1 0 011-1zm2 3v2h10V6H5zm0 4v2h10v-2H5z" />
        </svg>
        <span class="hidden sm:inline">Data Guru</span>
        <span class="sm:hidden">Guru</span>
      </a>

      <!-- Dropdown Menu for Rombel, Siswa, Kelas, Unit -->
      <div class="relative">
        <button type="button" class="dropdown-toggle flex items-center justify-between w-full gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
          {{ request()->is('rombel*') || request()->is('siswa*') || request()->is('kelas*') || request()->is('unit*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-400 hover:text-yellow-600 hover:bg-gray-50' }}"
          onclick="toggleDropdown('master-data-dropdown')">
          <div class="flex items-center gap-3">
            <svg id="dropdown-icon" class="w-4 h-4 transition-transform {{ request()->is('rombel*') || request()->is('siswa*') || request()->is('kelas*') || request()->is('unit*') ? 'text-yellow-600 rotate-180' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 3h14a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4a1 1 0 011-1zm2 3v2h10V6H5zm0 4v2h10v-2H5z" />
          </svg>
            <span class="hidden sm:inline">Data Siswa</span>
            <span class="sm:hidden">Data</span>
          </div>
          <svg id="dropdown-icon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        
          <div id="master-data-dropdown" 
          class="dropdown-menu mt-1 ml-4 space-y-1 
          {{ request()->is('rombel*') || request()->is('siswa*') || request()->is('kelas*') || request()->is('unit*') ? '' : 'hidden' }}">
          <a href="/rombel" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('rombel*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('rombel*') ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 3h14a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4a1 1 0 011-1zm2 3v2h10V6H5zm0 4v2h10v-2H5z" />
            </svg>
            <span>Rombel</span>
          </a>
          <a href="/siswa" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('siswa*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('siswa*') ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 3h14a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4a1 1 0 011-1zm2 3v2h10V6H5zm0 4v2h10v-2H5z" />
            </svg>
            <span>Siswa</span>
          </a>
          <a href="/kelas" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('kelas*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('kelas*') ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 3h14a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4a1 1 0 011-1zm2 3v2h10V6H5zm0 4v2h10v-2H5z" />
            </svg>
            <span>Kelas</span>
          </a>
          <a href="/unit" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('unit*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('unit*') ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 3h14a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4a1 1 0 011-1zm2 3v2h10V6H5zm0 4v2h10v-2H5z" />
            </svg>
            <span>Unit</span>
          </a>
        </div>
      </div>
    </nav>
  </div>

  <!-- Bottom section -->
  <div class="flex flex-col items-center">
    <!-- User Profile Section -->
    <div class="w-full">
      <!-- User Info -->
      <div class="flex items-center gap-3 w-full p-3 rounded-lg bg-gray-50 mb-3">
        <img src="assets/user.png" alt="User" class="w-10 h-10 rounded-full flex-shrink-0" />
        <div class="hidden sm:block flex-1 min-w-0">
          <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
          <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
        </div>
        <div class="sm:hidden">
          <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
        </div>
      </div>
      
      <!-- Profile & Logout Buttons -->
      <div class="flex flex-col gap-2">
        <!-- Profile Button -->
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors text-gray-600 hover:text-yellow-600 hover:bg-gray-50">
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <span class="hidden sm:inline">Profile</span>
          <span class="sm:hidden">Profil</span>
        </a>
        
        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="w-full">
          @csrf
          <button type="submit" class="w-full flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors text-red-600 hover:text-red-700 hover:bg-red-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span class="hidden sm:inline">Logout</span>
            <span class="sm:hidden">Keluar</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</aside>

<script>
  function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const icon = document.getElementById('dropdown-icon');
    if (dropdown.classList.contains('hidden')) {
      dropdown.classList.remove('hidden');
      icon.classList.add('rotate-180');
    } else {
      dropdown.classList.add('hidden');
      icon.classList.remove('rotate-180');
    }
  }
</script>
