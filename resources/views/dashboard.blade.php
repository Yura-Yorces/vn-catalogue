<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-gray-200">
  <div class="flex h-screen">


@include('partials.navbar')
<div class="flex-1 flex flex-col">

    <header class="flex items-center px-4 md:px-6 py-4 bg-gray-800 border-b border-gray-700">

        {{-- Left --}}
        <div class="shrink-0">
            @include('components.burger')
        </div>

        {{-- Right --}}
        <div class="flex items-center gap-3 md:gap-4 ml-auto shrink-0">
            @auth
                <p class="text-white">{{ auth()->user()->nickname }}</p>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-500">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                class="rounded-md px-3 py-1.5 text-sm font-medium text-zinc-300 hover:bg-zinc-800 hover:text-white">
                    Log in
                </a>
                <a href="{{ route('register') }}"
                class="rounded-md bg-blue-400 px-3 py-1.5 text-sm font-semibold text-black hover:bg-blue-300">
                    Sign up
                </a>
            @endauth
        </div>

    </header>
    @yield('main')
</div>
</div>

</body>
</html>
