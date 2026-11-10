<!-- Mobile Sidebar Overlay -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-20"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed md:static z-30 inset-y-0 left-0 w-64 h-dvh
    bg-gray-800 transform -translate-x-full md:translate-x-0
    transition-transform duration-200 ease-in-out flex flex-col">

    <div class="p-6 text-xl font-bold text-white underline shrink-0">
        <a href="/">Visual Novel Collection</a>
    </div>

    <!-- Scrollable Navigation -->
    <nav class="flex-1 px-4 pb-6 space-y-1 overflow-y-auto min-h-0">
        <a href="{{ route('novels.index') }}"
            class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded-lg {{ request()->routeIs('novels.*') ? 'bg-gray-700 text-white' : '' }}">
                <x-icon name="book" />
                <span>Browse</span>
            </a>

            @auth
                <a href="{{ route('profile.favorites') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded-lg {{ request()->routeIs('profile.favorites') ? 'bg-gray-700 text-white' : '' }}">
                    <x-icon name="heart" />
                    <span>Favorites</span>
                </a>

                <a href="{{ route('profile.my-rating') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded-lg {{ request()->routeIs('profile.my-rating') ? 'bg-gray-700 text-white' : '' }}">
                    <x-icon name="star" />
                    <span>My Reviews</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-gray-700 text-white' : '' }}">
                    <x-icon name="user" />
                    <span>Profile</span>
                </a>
            @endauth

        @if (auth()->check() && auth()->user()->isStaff())
            <div class="pt-4 pb-1 px-4 text-xs uppercase tracking-wider text-gray-500">Staff</div>

            <a href="{{ route('staff.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded-lg {{ request()->routeIs('staff.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                <x-icon name="shield" />
                <span>Panel</span>
            </a>

            <a href="{{ route('staff.novels.index') }}"
            class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded-lg {{ request()->routeIs('staff.novels.*') ? 'bg-gray-700 text-white' : '' }}">
                <x-icon name="book" />
                <span>Visual Novels</span>
            </a>

            <a href="{{ route('staff.users.index') }}"
            class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded-lg {{ request()->routeIs('staff.users.*') ? 'bg-gray-700 text-white' : '' }}">
                <x-icon name="users" />
                <span>Users</span>
            </a>

            @if (auth()->user()->isAdmin())
                <a href="{{ route('staff.roles.index') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 rounded-lg {{ request()->routeIs('staff.roles.*') ? 'bg-gray-700 text-white' : '' }}">
                    <x-icon name="settings" />
                    <span>Roles</span>
                </a>
            @endif
        @endif
    </nav>
</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn?.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
});
</script>
