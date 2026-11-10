<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen flex items-center justify-center px-4 py-10">

<div class="w-full max-w-md">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 shadow-lg">
        <h1 class="text-2xl font-bold text-white mb-1">Create an account</h1>
        <p class="text-sm text-gray-400 mb-6">Join to rate, review, and bookmark visual novels.</p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-900/40 border border-red-700 px-4 py-3 text-sm text-red-200">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="nickname" class="block text-sm font-medium text-gray-300 mb-1">Display name</label>
                <input id="nickname" name="nickname" type="text"
                       value="{{ old('nickname') }}" required autofocus autocomplete="nickname"
                       class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 placeholder-gray-500 focus:border-blue-400 focus:ring-blue-400">
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                <input id="username" name="username" type="text"
                       value="{{ old('username') }}" required autocomplete="username"
                       class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 placeholder-gray-500 focus:border-blue-400 focus:ring-blue-400">
                <p class="mt-1 text-xs text-gray-500">Letters, numbers, dashes and underscores only.</p>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                       class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">
            </div>

            <button type="submit"
                    class="w-full rounded-lg bg-blue-400 px-4 py-2.5 text-sm font-semibold text-black hover:bg-blue-300 transition">
                Sign up
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium">Log in</a>
        </p>
    </div>
</div>

</body>
</html>
