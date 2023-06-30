<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">

    @section('title', 'User')

    @if ($showingMainPage)
        
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#"><div class="font-medium text-lg text-gray-400">User</div></a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#"><div class="font-medium text-lg">List User</div></a>
                </div>
            </div>
        </div>
        
        {{-- TABLE DATA --}}
        <div class="m-6">
            {{-- ACTION BUTTON --}}
            <div class="flex items-center justify-start gap-4 mb-6 lg:justify-end">
                <button class="py-2 px-4 text-center rounded-lg border hover:bg-zinc-800 hover:text-white">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                        <span>Download CSV</span>
                    </div> 
                </button>
                <button wire:click="showUser" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat User</span>
                    </div>
                </button> 
            </div>  

            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg border border-gray-300/50">
                <div class="border-b-2 py-3 px-6 flex justify-between gap-4">
                    {{-- <div class="flex items-center gap-4">
                        <select wire:model="showPage" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="5">5</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <input wire:model.debounce.500ms="search" class="border-gray-300/50 rounded-lg p-2 text-sm" type="text" placeholder="Search">
                        <select wire:model="searchBy" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="quotation_code"></option>
                            <option value="name">NAMA</option>
                            <option value="project">PROYEK</option>
                            <option value="date">TANGGAL</option>
                            <option value="status_id">STATUS</option>
                            <option value="customers_id">CUSTOMER</option>
                        </select>
                        <select wire:model="orderAsc" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="1">Ascending</option>
                            <option value="0">Descending</option>
                        </select>
                    </div>     --}}
                </div>
                <table class="w-full text-sm text-left text-black">
                    <thead class="bg-zinc-200 text-zinc-800">
                        <tr>
                            <th scope="col" class="py-3 px-4">#</th>
                            <th scope="col" class="py-3 px-3">Nama</th>
                            <th scope="col" class="py-3 px-3">Email</th>
                            <th scope="col" class="py-3 px-3">Telepon</th>
                            <th scope="col" class="py-3 px-3">Alamat</th>
                            <th scope="col" class="py-3 px-3">Departemen</th>
                            <th scope="col" class="py-3 px-3">Role</th>
                            <th scope="col" class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($detailusers as $user)
                        <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                            <td class="py-1 px-3">{{ ($detailusers ->currentpage()-1) * $detailusers ->perpage() + $loop->index + 1 }}</td>
                            <td class="py-1 px-3 font-medium">{{ $user->user['name'] }}</td>
                            <td class="py-1 px-3">{{ $user->user['email'] }}</td>
                            <td class="py-1 px-3">{{ $user->phone }}</td>
                            <td class="py-1 px-3">{{ $user->address }}</td>
                            <td class="py-1 px-3">{{ $user->department }}</td>
                            <td class="py-1 px-3">
                                <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                    {{ $user->role['name'] }}
                                </div>
                            </td>
                            <td class="py-1 px-3">
                                <div class="flex items-center gap-4 text-white font-medium">
                                    <button wire:click="showDetail({{ $user->id }})" class="bg-blue-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                    </button>
                                    <button wire:click="edit({{ $user->id }})" class="bg-yellow-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="rounded-lg mt-6">
                {{ $detailusers->links() }}
            </div>
        </div>

        {{-- USER MODAL --}}
        @if ($showingUser)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        @if ($isEdit)
                            <h1 class="font-medium text-xl">Edit User</h1>
                        @else
                            <h1 class="font-medium text-xl">Buat User</h1>
                        @endif
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="text"
                                wire:model="name"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Email</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="text"
                                wire:model="email"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Telepon</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="text"
                                wire:model="phone"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Alamat</h1>
                            <textarea class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" wire:model="address" name="" id="" cols="60" rows="5"></textarea>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Departemen</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="text"
                                wire:model="department"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Role</h1>
                            @if ($isEdit)
                                <select wire:model="roles_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select wire:model="roles_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" disabled>
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            @endif                          
                        </div>
                    
                        <div class="mt-4">
                            <div class="flex justify-end">
                                @if ($isEdit)
                                <button wire:click="update" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                    Update
                                </button>
                                    
                                @else
                                <button wire:click="store" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                    Submit
                                </button>
                                    
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @endif
        
    
        
</div>
