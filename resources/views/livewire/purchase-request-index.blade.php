<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">
    
    @section('title', 'Purhcase Request')

    @if ($showingMainPage)
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#"><div class="font-medium text-lg text-gray-400">Pengadaan</div></a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#"><div class="font-medium text-lg">Purchase Request</div></a>
                </div>
            </div>
        </div>

        {{-- TABLE DATA --}}
        <div class="m-6">
            <div class="flex items-center justify-start gap-4 mb-6 lg:justify-end">
                <button class="py-2 px-4 text-center rounded-lg border hover:bg-zinc-800 hover:text-white">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                        <span>Download CSV</span>
                    </div> 
                </button>
                <button wire:click="showPR" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat PR</span>
                    </div>
                </button> 
            </div> 

            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg border border-gray-300/50">
                <div class="border-b-2 py-3 px-6 flex justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <select wire:model="showPage" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="5">5</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <input wire:model.debounce.500ms="search" class="border-gray-300/50 rounded-lg p-2 text-sm" type="text" placeholder="Search">
                        <select wire:model="searchBy" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="purchase_request_code">KODE PR</option>
                            <option value="name">NAMA</option>
                            <option value="description">KETERANGAN</option>
                            <option value="deadline">DEADLINE</option>
                            <option value="status_id">STATUS</option>
                        </select>
                        <select wire:model="orderAsc" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="1">Ascending</option>
                            <option value="0">Descending</option>
                        </select>
                    </div>      
                </div>
                <table class="w-full text-sm text-left text-black">
                    <thead class="bg-zinc-200 text-zinc-800">
                        <tr>
                            <th scope="col" class="py-3 px-4">#</th>
                            <th scope="col" class="py-3 px-3">Kode PR</th>
                            <th scope="col" class="py-3 px-3">Nama Material</th>
                            <th scope="col" class="py-3 px-3">Nama Barang</th>
                            <th scope="col" class="py-3 px-3">Keterangan</th>
                            <th scope="col" class="py-3 px-3">Deadline</th>
                            <th scope="col" class="py-3 px-3">Status</th>
                            <th scope="col" class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($purchaserequests as $pr)
                            <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                <td class="py-1 px-3">{{ ($purchaserequests ->currentpage()-1) * $purchaserequests ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-1 px-3 font-medium">{{ $pr->purchase_request_code }}</td>
                                <td class="py-1 px-3">{{ $pr->material['name'] }}</td>
                                <td class="py-1 px-3">{{ $pr->production['name'] }}</td>
                                <td class="py-1 px-3">{{ $pr->description }}</td>
                                <td class="py-1 px-3">{{ $pr->deadline }}</td>
                                <td class="py-1 px-3">
                                    @if ($pr->status['name'] == "Working")
                                        <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $pr->status['name'] }}
                                        </div>
                                    @elseif ($pr->status['name'] == "Complete")
                                        <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $pr->status['name'] }}
                                        </div>
                                    @else
                                        <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $pr->status['name'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-1 px-3">
                                    <div class="flex items-center gap-4">
                                        @if ($pr->status['name'] == "Pending")
                                            <button title="Approve" wire:click="approve({{ $pr->id }})" class="text-white bg-green-500 p-2 rounded-lg font-medium">
                                                Sudah Dipesan
                                            </button>
                                        @else
                                            <button title="Selesai" wire:click="" class="text-white bg-red-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150" disabled>
                                                Request Selesai
                                            </button>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="rounded-lg mt-6">
                {{ $purchaserequests->links() }}
            </div>
        </div>

        {{-- PURCHASE REQUEST MODAL --}}
        @if ($showingPR)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Buat PR</h1>
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kode PR</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                type="text"
                                wire:model="purchase_request_code"
                                disabled
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama Produksi</h1>
                            <select wire:model="productions_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                <option value="">Pilih Produksi</option>
                                @foreach ($productions as $production)
                                    <option value="{{ $production->id }}">{{ $production->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama Material</h1>
                            <select wire:model="materials_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                <option value="">Pilih Material</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Qty Beli</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="number"
                                wire:model="qty_ask"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Deadline</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="date"
                                wire:model.lazy="deadline"
                            />
                        </div>
                    
                        <div class="mt-4">
                            <div class="flex justify-end">
                                <button wire:click="store" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @endif

    {{-- DETAIL MODAL --}}
    @if ($showingDetail)
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Purchase Request</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">{{ $name }}</div>
                    </a>
                </div>
                <button 
                    class="text-lg font-medium" 
                    wire:click="back">Kembali
                </button>
            </div>
        </div>

        <div class="m-6 pb-6">
            {{-- SECTION DATA PURCHASE REQUEST --}}
            <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                <div class="bg-white py-3 px-6">

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kode PR:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="text"
                                wire:model="logistic_code"
                                disabled
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Nama:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="name"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Keterangan:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="description"
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Deadline:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="deadline"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Status:</label>
                            @if ($status_id == "Pending")
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-red-200 font-bold"
                                    type="text"
                                    wire:model="status_id"
                                    disabled
                                />
                            @elseif ($status_id == "Working")
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-yellow-200"
                                    type="text"
                                    wire:model="status_id"
                                    disabled
                                />
                            @else
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-green-200"
                                    type="text"
                                    wire:model="status_id"
                                    disabled
                                />
                            @endif
                        </div>
                        <div class="md:w-1/2">
                            <label>User:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-red-200 font-bold" type="text" disabled
                                wire:model="users_id"
                            />
                        </div>
                    </div>

                </div>
            </div>
            {{--  --}}

            {{-- BUTTON ACTION--}}
            <div class="py-3 px-6">
                <div class="flex justify-end gap-4">
                    <button wire:click="" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white">
                        Simpan
                    </button>
                </div>
            </div>
            {{--  --}}
        </div>
    @endif
</div>
