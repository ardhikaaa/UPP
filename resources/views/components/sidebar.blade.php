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
    <div class="flex-col items-center justify-between mb-10">
    <a href="/kunjungan_uks">
      <div class="flex items-center space-x-3">
        <img src="../../assets/logo-uks.png" alt="Logo" class="w-15 h-10" />
        <h1 class="text-lg font-semibold">UPP</h1>
      </div>
    </a>
      <!-- Close button for mobile -->
      <button id="sidebar-close" class="lg:hidden p-1 rounded-lg hover:bg-gray-100 transition-colors">
        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
      <!-- Supported by text -->
    <div class="mb-6 mt-2">
      <p class="text-xs text-gray-600">Support by SMK Informatika Pesat</p>
    </div>
    </div>
    


    <!-- Menu Items -->
    <nav class="flex flex-col gap-2 ">
      <a href="/kunjungan_uks" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
        {{ request()->is('kunjungan_uks') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600  hover:bg-gray-50' }}">
        <svg class="w-5 h-5 {{ request()->is('kunjungan_uks*') ? 'text-yellow-500' : 'text-gray-600' }}" 
            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        <path d="m16 24h-8v-8h-8v-8h8v-8h8v8h8v8h-8z"/>
        </svg>
        <span class="hidden sm:inline ">Data Kunjungan UKS</span>
        <span class="sm:hidden">Dashboard</span>
      </a>

      <!-- Dropdown Menu for Rombel, Siswa, Kelas, Unit -->
      <div class="relative">
        <button type="button" class="dropdown-toggle flex items-center justify-between w-full gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
          {{ request()->is('rombel*') || request()->is('siswa*') || request()->is('kelas*') || request()->is('unit*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}"
          onclick="toggleDropdown('master-data-dropdown')">
          <div class="flex items-center gap-4">
            <svg id="dropdown-icon" class="w-4 h-4 {{ request()->is('rombel*') || request()->is('siswa*') || request()->is('kelas*') || request()->is('unit*') ? 'text-yellow-600' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
             <path d="m15.5,23c0,.552-.448,1-1,1h-5c-.552,0-1-.448-1-1,0-1.5,1.737-3,3.5-3s3.5,1.5,3.5,3Zm-12.269-4c1.381,0,2.5-1.119,2.5-2.5s-1.119-2.5-2.5-2.5-2.5,1.119-2.5,2.5,1.119,2.5,2.5,2.5Zm8.769,0c1.381,0,2.5-1.119,2.5-2.5s-1.119-2.5-2.5-2.5-2.5,1.119-2.5,2.5,1.119,2.5,2.5,2.5ZM19,0H5C2.239,0,0,2.239,0,5v8.381c.819-.848,1.962-1.381,3.231-1.381,2.143,0,3.934,1.508,4.385,3.517.451-2.009,2.242-3.517,4.385-3.517s3.934,1.508,4.385,3.517c.451-2.009,2.242-3.517,4.385-3.517,1.269,0,2.412.533,3.231,1.381V5c0-2.761-2.239-5-5-5Zm1.769,19c1.381,0,2.5-1.119,2.5-2.5s-1.119-2.5-2.5-2.5-2.5,1.119-2.5,2.5,1.119,2.5,2.5,2.5Zm-.019,1c-1.667,0-3.183,1.539-3.25,3,0,.552.448,1,1,1h4.5c.552,0,1-.448,1-1-.079-1.458-1.585-3-3.25-3Zm-17.5,0c-1.667,0-3.183,1.539-3.25,3,0,.552.448,1,1,1h4.5c.552,0,1-.448,1-1-.079-1.458-1.585-3-3.25-3Z"/>
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
           <a href="/unit" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('unit*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('unit*') ? 'text-yellow-500' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
              <path d="m4.343 11h-4.343a5.006 5.006 0 0 1 5-5h6v-4.364a1.637 1.637 0 0 1 2.33-1.482l3.2 1.5a1 1 0 0 1 0 1.7l-3.53 1.646v1h6a5.006 5.006 0 0 1 5 5h-4.343a3 3 0 0 1 -2.092-.849l-2.736-2.979a4.074 4.074 0 0 0 -5.687.03l-2.678 2.919a3.017 3.017 0 0 1 -2.121.879zm7.657 8a1 1 0 0 0 -1 1v4h2v-4a1 1 0 0 0 -1-1zm7.657-6h4.343v8a3 3 0 0 1 -3 3h-6v-4a3 3 0 0 0 -6 0v4h-6a3 3 0 0 1 -3-3v-8h4.343a4.994 4.994 0 0 0 3.565-1.495l2.678-2.919a2.07 2.07 0 0 1 2.8-.03l2.738 2.979a4.968 4.968 0 0 0 3.533 1.465zm-13.657 8a1 1 0 0 0 -1-1h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 1-1zm0-4a1 1 0 0 0 -1-1h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 1-1zm8-4a2 2 0 1 0 -2 2 2 2 0 0 0 2-2zm7 8a1 1 0 0 0 -1-1h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 1-1zm-1-5h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 0-2z"/>
            </svg>
            <span>Unit</span>
          </a>
          <a href="/siswa" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('siswa*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('siswa*') ? 'text-yellow-500' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
              <path d="m22.004,4.498c.001-.865-.525-1.61-1.34-1.898L14.199.319c-1.388-.491-2.916-.492-4.303-.006L3.353,2.603c-.818.286-1.346,1.03-1.346,1.896,0,.867.529,1.611,1.347,1.896l6.507,2.27c.689.24,1.414.361,2.138.361s1.448-.121,2.137-.361l5.864-2.045v4.379c0,.552.448,1,1,1s1-.448,1-1c0,0,.004-6.493.004-6.502Zm-7.209,6.056l3.205-1.118v.564c0,3.309-2.691,6-6,6s-6-2.691-6-6v-.563l3.203,1.118c1.799.627,3.794.627,5.592,0Zm4.205,13.446H5c-.318,0-.617-.151-.805-.407s-.244-.586-.15-.89c1.044-3.358,4.315-5.703,7.955-5.703s6.911,2.345,7.955,5.703c.094.303.039.634-.15.89s-.487.407-.805.407Z"/>
            </svg>
            <span>Siswa</span>
          </a>
          <a href="/kelas" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('kelas*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('kelas*') ? 'text-yellow-500' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
              <path d="m2,2.5c0-1.381,1.119-2.5,2.5-2.5s2.5,1.119,2.5,2.5-1.119,2.5-2.5,2.5-2.5-1.119-2.5-2.5Zm13,3.5v2h-7v6H0v-5c0-1.654,1.346-3,3-3h12ZM21,0h-12.76c.479.715.76,1.575.76,2.5,0,.526-.092,1.031-.258,1.5h8.258v6h-7v4h8v-2h4v2h2V3c0-1.657-1.343-3-3-3ZM3.5,20c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm8.5,0c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm8.5,0c1.105,0,2-.895,2-2s-.895-2-2-2-2,.895-2,2,.895,2,2,2Zm-13.5,3c0-1.103-.897-2-2-2h-3c-1.103,0-2,.897-2,2v1h7v-1Zm17,0c0-1.103-.897-2-2-2h-3c-1.103,0-2,.897-2,2v1h7v-1Zm-8.5,0c0-1.103-.897-2-2-2h-3c-1.103,0-2,.897-2,2v1h7v-1Z"/>
            </svg>
            <span>Kelas</span>
          </a>
          
          <a href="/rombel" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('rombel*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('rombel*') ? 'text-yellow-500' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
              <path d="m18.5,16c-2.206,0-4-1.794-4-4s1.794-4,4-4,4,1.794,4,4-1.794,4-4,4Zm-6.5-8c-2.206,0-4-1.794-4-4S9.794,0,12,0s4,1.794,4,4-1.794,4-4,4Zm-6.5,8c-2.206,0-4-1.794-4-4s1.794-4,4-4,4,1.794,4,4-1.794,4-4,4Zm5.5,8v-3c0-1.629-1.3-2.947-2.918-2.992l-2.582,2.992-2.621-2.988c-1.6.065-2.879,1.372-2.879,2.988v3m24,0v-3c0-1.629-1.3-2.947-2.918-2.992l-2.582,2.992-2.621-2.988c-1.6.065-2.879,1.372-2.879,2.988v3"/>
            </svg>
            <span>Rombel</span>
          </a>
        </div>
      </div>

       <a href="/guru" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
        {{ request()->is('guru') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
        <svg class="w-5 h-5 {{ request()->is('guru*') ? 'text-yellow-500' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
          <path d="m14,23c0,.552-.448,1-1,1H1c-.552,0-1-.448-1-1,0-3.866,3.134-7,7-7s7,3.134,7,7ZM7,6c-2.209,0-4,1.791-4,4s1.791,4,4,4,4-1.791,4-4-1.791-4-4-4Zm17-1v8c0,2.761-2.239,5-5,5h-4.526c-.945-1.406-2.275-2.533-3.839-3.227,1.437-1.096,2.365-2.826,2.365-4.773,0-3.314-2.686-6-6-6-1.084,0-2.102.288-2.979.791.112-2.658,2.294-4.791,4.979-4.791h10c2.761,0,5,2.239,5,5Zm-4,10c0-.553-.448-1-1-1h-3.5c-.552,0-1,.447-1,1s.448,1,1,1h3.5c.552,0,1-.447,1-1Z"/>
        </svg>
        <span class="hidden sm:inline">Data Guru</span>
        <span class="sm:hidden">Guru</span>
      </a>
      
      <a href="/obat" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
        {{ request()->is('obat') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
        <svg class="w-5 h-5 {{ request()->is('obat*') ? 'text-yellow-500' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
          <path d="m0,11v-5C0,2.692,2.692,0,6,0s6,2.692,6,6v5H0Zm12.258,10.328c-.787-1.075-1.258-2.396-1.258-3.828,0-3.584,2.916-6.5,6.5-6.5,1.432,0,2.752.471,3.828,1.258l-9.069,9.069Zm1.414,1.414c1.075.787,2.396,1.258,3.828,1.258,3.584,0,6.5-2.916,6.5-6.5,0-1.432-.471-2.752-1.258-3.828l-9.069,9.069Zm-4.672-5.242c0-1.655.48-3.194,1.298-4.5H0v5c0,3.308,2.692,6,6,6,1.719,0,3.268-.731,4.363-1.894-.859-1.328-1.363-2.907-1.363-4.606Z"/>
        </svg>
        <span class="hidden sm:inline">Data Obat</span>
        <span class="sm:hidden">Obat</span>
      </a>

      <!-- Dropdown Menu for Report -->
      <div class="relative">
        <button type="button" class="dropdown-toggle flex items-center justify-between w-full gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
          {{ request()->is('report/obat*') || request()->is('report/siswa*') || request()->is('report/kunjungan*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}"
          onclick="toggleDropdown('master-report-dropdown')">
          <div class="flex items-center gap-4">
            <svg id="dropdown-icon" class="w-4 h-4 {{ request()->is('report/obat*') || request()->is('report/siswa*') || request()->is('report/kunjungan*') ? 'text-yellow-600' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
             <path d="m14,7V.46c.913.346,1.753.879,2.465,1.59l3.484,3.486c.712.711,1.245,1.551,1.591,2.464h-6.54c-.552,0-1-.449-1-1Zm7.976,3h-6.976c-1.654,0-3-1.346-3-3V.024c-.161-.011-.322-.024-.485-.024h-4.515C4.243,0,2,2.243,2,5v9h3.965l1.703-2.555c.197-.296.542-.473.894-.443.356.022.673.232.833.551l2.229,4.459,1.044-1.566c.186-.278.498-.445.832-.445h4.5c.552,0,1,.448,1,1s-.448,1-1,1h-3.965l-1.703,2.555c-.186.279-.499.445-.832.445-.021,0-.042,0-.062-.002-.356-.022-.673-.232-.833-.551l-2.229-4.459-1.044,1.566c-.186.278-.498.445-.832.445H2v3c0,2.757,2.243,5,5,5h10c2.757,0,5-2.243,5-5v-8.515c0-.163-.013-.324-.024-.485Z"/>
          </svg>
            <span class="hidden sm:inline">Laporan</span>
            <span class="sm:hidden">Laporan</span>
          </div>
          <svg id="dropdown-icon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        
          <div id="master-report-dropdown" 
          class="dropdown-menu mt-1 ml-4 space-y-1 
          {{ request()->is('report/obat*') || request()->is('report/siswa*') || request()->is('report/kunjungan*') ? '' : 'hidden' }}">
           <a href="/report/kunjungan" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('report/kunjungan*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('report/kunjungan*') ? 'text-yellow-500' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
              <path d="m16 24h-8v-8h-8v-8h8v-8h8v8h8v8h-8z"/>
            </svg>
            <span>Laporan Kunjungan</span>
          </a>
          <a href="/report/siswa" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('report/siswa*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('report/siswa*') ? 'text-yellow-500' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
              <path d="m22.004,4.498c.001-.865-.525-1.61-1.34-1.898L14.199.319c-1.388-.491-2.916-.492-4.303-.006L3.353,2.603c-.818.286-1.346,1.03-1.346,1.896,0,.867.529,1.611,1.347,1.896l6.507,2.27c.689.24,1.414.361,2.138.361s1.448-.121,2.137-.361l5.864-2.045v4.379c0,.552.448,1,1,1s1-.448,1-1c0,0,.004-6.493.004-6.502Zm-7.209,6.056l3.205-1.118v.564c0,3.309-2.691,6-6,6s-6-2.691-6-6v-.563l3.203,1.118c1.799.627,3.794.627,5.592,0Zm4.205,13.446H5c-.318,0-.617-.151-.805-.407s-.244-.586-.15-.89c1.044-3.358,4.315-5.703,7.955-5.703s6.911,2.345,7.955,5.703c.094.303.039.634-.15.89s-.487.407-.805.407Z"/>
            </svg>
            <span>Laporan siswa</span>
          </a>
          <a href="/report/obat" class="flex items-center gap-3 text-sm font-medium px-3 py-2 rounded-lg transition-colors
            {{ request()->is('report/obat*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 {{ request()->is('report/obat*') ? 'text-yellow-500' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
              <path d="m0,11v-5C0,2.692,2.692,0,6,0s6,2.692,6,6v5H0Zm12.258,10.328c-.787-1.075-1.258-2.396-1.258-3.828,0-3.584,2.916-6.5,6.5-6.5,1.432,0,2.752.471,3.828,1.258l-9.069,9.069Zm1.414,1.414c1.075.787,2.396,1.258,3.828,1.258,3.584,0,6.5-2.916,6.5-6.5,0-1.432-.471-2.752-1.258-3.828l-9.069,9.069Zm-4.672-5.242c0-1.655.48-3.194,1.298-4.5H0v5c0,3.308,2.692,6,6,6,1.719,0,3.268-.731,4.363-1.894-.859-1.328-1.363-2.907-1.363-4.606Z"/>
            </svg>
            <span>Laporan Obat</span>
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
        <img src="../../assets/user.png" alt="User" class="w-10 h-10 rounded-full flex-shrink-0" />
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
          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
    } else {
      dropdown.classList.add('hidden');
    }
  }
</script>
