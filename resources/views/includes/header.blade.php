<div class="bg-slate-50 flex justify-between px-6 py-4">
    <div class="flex items-center gap-4">
        <a href="#" class="toggleMenu">
            <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16m-7 6h7"
                ></path>
            </svg>
        </a>
        <span class="text-xl font-medium">Wemphy Group</span>
    </div>
    <div class="flex items-center gap-4">
        <img
            class="rounded-full w-12 h-12"
            src="https://images.genius.com/d34114ae0a1dea37d0e4f3f23fb2d0c8.1000x1000x1.png"
            alt=""
        />
        <div class="group">
            <a class="flex items-center gap-4 dropdown" href="#">
                <span class="text-lg">{{ Auth::user()->name }}</span>
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    ></path>
                </svg>
            </a>
            <ul
                class="dropdown-menu absolute hidden text-gray-700 pt-1"
            >
                <li>
                    <a
                        class="rounded-lg bg-gray-200 hover:bg-gray-400 py-2 px-8 block whitespace-no-wrap"
                        href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >
                        <span>Logout</span>
                        <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

