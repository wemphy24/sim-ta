<div>
    @extends('layouts.front')

    @section('title', 'Login')

    @section('content')
    <div class="grid grid-cols-12 bg-slate-50">
        <!-- LOGIN -->
        <div class="flex h-screen col-span-12 lg:col-span-5">
            <div class="m-auto w-96">
                <h1 class="font-bold text-4xl">Selamat datang</h1>
                <p class="font-medium text-slate-400 mt-2">Silahkan login untuk menggunakan sistem</p>
                <div class="mt-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="email">
                            <span class="font-medium text-sm text-slate-700">Email</span>
                            <input
                                name="email"
                                id="email"
                                type="email"
                                class="border border-gray-300/50 rounded-lg w-full p-2.5 bg-gray-100 shadow-sm mt-1 text-sm"
                                placeholder="Email"
                                required
                                autofocus
                            />
                            @if ($errors->has('email'))
                                <p class="text-red-400 text-sm mb-2">{{ $errors->first('email') }}</p>                                
                            @endif
                        </div>
                        <div class="password mt-2">
                            <span class="font-medium text-sm text-slate-700">Password</span>
                            <input
                                name="password"
                                id="password"
                                type="password"
                                class="border border-gray-300/50 rounded-lg w-full p-2.5 bg-gray-100 shadow-sm mt-1 text-sm"
                                placeholder="Password"
                                required
                                autocomplete="current-password"
                            />
                            @if ($errors->has('password'))
                                <p class="text-red-400 text-sm mb-2">{{ $errors->first('password') }}</p>                                
                            @endif
                        </div>
                        <div class="text-center mt-2">
                            <a href="#" class="text-zinc-800 font-medium">Lupa Password ?</a>
                            <button class="bg-zinc-800 text-white py-2.5 rounded-lg mt-4 hover:scale-105 hover:-translate-x-0 hover:duration-150 w-96" type="submit">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- BACKGROUND --}}
        <div class="hidden col-span-7 rounded-3xl lg:block m-2"
            style="
                background: url('https://images.unsplash.com/photo-1521111756787-d2f69136cedf?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1326&q=80');
                background-size: cover;
                background-repeat: no-repeat;
            "
        ></div>
    </div>
    @endsection
</div>
