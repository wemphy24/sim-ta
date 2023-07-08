<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">
    
    @section('title', 'Logistik')

    @if ($showingMainPage)
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#"><div class="font-medium text-lg text-gray-400">Pengelolaan</div></a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#"><div class="font-medium text-lg">Logistik Material</div></a>
                </div>
            </div>
        </div>

        {{-- TABLE DATA --}}
        <div class="m-6">
            {{-- <div class="flex items-center justify-start gap-4 mb-6 lg:justify-end">
                <button class="py-2 px-4 text-center rounded-lg border hover:bg-zinc-800 hover:text-white">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                        <span>Download CSV</span>
                    </div> 
                </button>
                <button wire:click="" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat Logistik</span>
                    </div>
                </button> 
            </div>  --}}

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
                            <option value="logistic_code">KODE LOGISTIK</option>
                            <option value="name">NAMA</option>
                            <option value="categories_id">KATEGORI</option>
                            <option value="description">KETERANGAN</option>
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
                            <th scope="col" class="py-3 px-3">Kode Logistik</th>
                            <th scope="col" class="py-3 px-3">Nama</th>
                            <th scope="col" class="py-3 px-3">Barang Diproduksi</th>
                            <th scope="col" class="py-3 px-3">Kategori</th>
                            <th scope="col" class="py-3 px-3">Qty Minta</th>
                            <th scope="col" class="py-3 px-3">Qty Stok</th>
                            <th scope="col" class="py-3 px-3">Tipe</th>
                            <th scope="col" class="py-3 px-3">Status</th>
                            <th scope="col" class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($logistics as $logistic)
                            <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                <td class="py-1 px-3">{{ ($logistics ->currentpage()-1) * $logistics ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-1 px-3 font-medium">{{ $logistic->logistic_code }}</td>
                                <td class="py-1 px-3">{{ $logistic->material['name'] }}</td>
                                @if ($logistic->set_goods_id != NULL)
                                    <td class="py-1 px-3">{{ $logistic->set_good['name'] }}</td>
                                @else
                                    <td class="py-1 px-3">-</td>
                                @endif
                                <td class="py-1 px-3">{{ $logistic->category['name'] }}</td>
                                <td class="py-1 px-3">{{ $logistic->qty_ask }}</td>
                                <td class="py-1 px-3">{{ $logistic->qty_stock }}</td>
                                <td class="py-1 px-3 font-medium">{{ $logistic->type }}</td>
                                <td class="py-1 px-3">
                                    @if ($logistic->status['name'] == "Working")
                                        <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $logistic->status['name'] }}
                                        </div>
                                    @elseif ($logistic->status['name'] == "Complete")
                                        <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $logistic->status['name'] }}
                                        </div>
                                    @else
                                        <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $logistic->status['name'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-1 px-3">
                                    <div class="flex items-center gap-4">
                                        @if ($logistic->type == "Barang Keluar" && $logistic->status['name'] == "Complete")
                                            <button title="Sudah Diambil" wire:click="" class="text-white bg-red-500 p-2 rounded-lg font-medium" disabled>
                                                Sudah Diambil
                                            </button>
                                         @elseif ($logistic->type == "Barang Keluar" && $logistic->status['name'] == "Pending")
                                            <button title="Approve" wire:click="approveBarang({{ $logistic->id }})" class="text-white bg-yellow-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Approve
                                            </button>
                                        @elseif($logistic->qty_stock >= $logistic->qty_ask && $logistic->status['name'] == "Pending")
                                            <button title="Approve" wire:click="approve({{ $logistic->id }})" class="text-white bg-green-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Approve
                                            </button>
                                        @elseif ($logistic->status['name'] == "Complete")
                                            <button title="Sudah Diambil" wire:click="" class="text-white bg-red-500 p-2 rounded-lg font-medium" disabled>
                                                Sudah Diambil
                                            </button>
                                        @else
                                            <button title="RequestPR" wire:click="requestPR({{ $logistic->id }})" class="text-white bg-yellow-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Request PR
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
                {{ $logistics->links() }}
            </div>
        </div>
    @endif

    {{-- DETAIL MODAL --}}
    @if ($showingDetail)
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Logistik Material</div>
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
            {{-- SECTION DATA LOGISTIK --}}
            <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                <div class="bg-white py-3 px-6">

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kode Logistik:</label>
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
                                wire:model="materials_id"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kategori:</label>
                            <select wire:model="categories_id" class="w-full border-gray-300/50 rounded-lg text-sm bg-gray-100" disabled>
                                {{-- @foreach ($quotations as $quotation)
                                    <option value="{{ $quotation->id }}">{{ $quotation->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="md:w-1/2">
                            <label>Satuan:</label>
                            <select wire:model="measurements_id" class="w-full border-gray-300/50 rounded-lg text-sm bg-gray-100" disabled>
                                {{-- @foreach ($quotations as $quotation)
                                    <option value="{{ $quotation->id }}">{{ $quotation->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Minta:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="date" disabled
                                wire:model="qty_ask" 
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Stok:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="text" disabled
                                wire:model="qty_stock"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Status:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-red-200 font-bold" type="text" disabled
                                wire:model="status_id"
                            />
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
