<x-guest-layout>
    <div class="w-full max-w-sm mx-auto bg-white/30 backdrop-blur-sm rounded-2xl shadow-2xl ml-6  px-8 py-12 relative">
        <img src="{{ asset('images/logo-uks.png') }}" alt="UKS Logo" class="w-16 mx-auto mb-2" />

        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Log in</h2>

        {{-- Login form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email or Username --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-800">Email or Username</label>
                <input type="text" name="login" value="{{ old('login') }}" placeholder="example@gmail.com or username" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('login') border-red-500 @enderror"/>
                @error('login')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-800">Password</label>
                <input type="password" name="password" placeholder="********" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"/>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
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
            Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">New Account</a>
        </p>
    </div>
</x-guest-layout>
