<x-guest-layout>
    <div class="w-full max-w-sm mx-auto bg-white/30 backdrop-blur-sm rounded-2xl shadow-2xl ml-6 px-8 py-8 relative">
        <img src="{{ asset('images/logo-uks.png') }}" alt="UKS Logo" class="w-16 mx-auto mb-2" />

        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Sign Up</h2>

        {{-- Register form --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Full Name --}}
            <div class="mb-2">
                <label class="block text-sm text-gray-800">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Doni Sulaiman" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"/>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

             {{-- Username --}}
            <div class="mb-2">
                <label class="block text-sm text-gray-800">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Doni12643" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror"/>
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Email --}}
            <div class="mb-2">
                <label class="block text-sm text-gray-800">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"/>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>


            {{-- Password --}}
            <div class="mb-2">
                <label class="block text-sm text-gray-800">Password</label>
                <input type="password" name="password" placeholder="********" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"/>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-800">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="********" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>

            {{-- Terms --}}
            <div class="flex items-start gap-2 text-sm mb-6">
                <input type="checkbox" name="terms" required class="mt-1 form-checkbox">
                <label class="text-gray-700">
                    By creating an account you agree to the <a href="#" class="text-blue-600 hover:underline">terms of use</a> and our <a href="#" class="text-blue-600 hover:underline">privacy policy</a>.
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition duration-200">
                Create account
            </button>
        </form>

        {{-- Login link --}}
        <p class="text-center text-sm text-gray-600 mt-6">
            Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Log In</a>
        </p>
    </div>
</x-guest-layout>
