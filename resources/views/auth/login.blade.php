<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-md">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 shadow-lg">
        <h1 class="text-2xl font-bold text-white mb-1">Welcome back</h1>
        <p class="text-sm text-gray-400 mb-6">Log in to your account to continue.</p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-900/40 border border-red-700 px-4 py-3 text-sm text-red-200">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                <input id="username" name="username" type="text"
                       value="{{ old('username') }}" required autofocus autocomplete="username"
                       class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 placeholder-gray-500 focus:border-blue-400 focus:ring-blue-400">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100 focus:border-blue-400 focus:ring-blue-400">
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-400">
                <input type="checkbox" name="remember" value="1"
                       class="rounded bg-gray-900 border-gray-700 text-blue-400 focus:ring-blue-400">
                Remember me
            </label>

            <button type="submit"
                    class="w-full rounded-lg bg-blue-400 px-4 py-2.5 text-sm font-semibold text-black hover:bg-blue-300 transition">
                Log in
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium">Sign up</a>
        </p>
    </div>

    <p class="mt-4 text-center text-sm">
        <a href="/" class="text-gray-500 hover:text-gray-300">&larr; Back to dashboard</a>
    </p>
</div>

</body>
</html>
