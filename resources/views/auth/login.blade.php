<x-guest-layout>
    <div class="w-full max-w-sm mx-auto bg-white/30 backdrop-blur-sm rounded-2xl shadow-lg px-8 py-12 relative">
        <img src="{{ asset('images/logo-uks.png') }}" alt="UKS Logo" class="w-16 mx-auto mb-2" />

        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Log in</h2>

        {{-- Sosial login --}}
        <div class="flex justify-between gap-4 mb-4">
            <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-black py-2 rounded-lg flex items-center justify-center gap-2">
                <i class="fab fa-google text-red-600"></i> Google
            </button>
            <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-black py-2 rounded-lg flex items-center justify-center gap-2">
                <i class="fab fa-facebook-f text-blue-600"></i> Facebook
            </button>
        </div>

        <p class="text-center text-sm text-gray-700 mb-4">Or</p>

        {{-- Login form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-800">Email Address</label>
                <input type="email" name="email" placeholder="example@gmail.com" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-800">Password</label>
                <input type="password" name="password" placeholder="********" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>

            {{-- Remember + Forgot --}}
            <div class="flex justify-between items-center text-sm mb-6">
                <label class="flex items-center gap-1">
                    <input type="checkbox" name="remember" class="form-checkbox">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Reset Password?</a>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition duration-200">
                Log in
            </button>
        </form>

        {{-- Register link --}}
        <p class="text-center text-sm text-gray-600 mt-6">
            Don’t have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">New Account</a>
        </p>
    </div>
</x-guest-layout>
