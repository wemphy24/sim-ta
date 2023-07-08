<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">
    
    @section('title', 'GRN PO')

    @if ($showingMainPage)
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#"><div class="font-medium text-lg text-gray-400">Pengadaan</div></a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#"><div class="font-medium text-lg">GRN PO</div></a>
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
                <button wire:click="showPO" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat GRN PO</span>
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
                            <option value="good_receive_code">KODE GRN</option>
                            <option value="materials_id">NAMA</option>
                            <option value="print_date">TANGGAL CETAK</option>
                            <option value="suppliers_id">SUPPLIER</option>
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
                            <th scope="col" class="py-3 px-3">Kode GRN</th>
                            <th scope="col" class="py-3 px-3">Nama</th>
                            <th scope="col" class="py-3 px-3">Qty</th>
                            <th scope="col" class="py-3 px-3">Supplier</th>
                            <th scope="col" class="py-3 px-3">Tanggal Cetak</th>
                            <th scope="col" class="py-3 px-3">Status</th>
                            <th scope="col" class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($goodreceives as $gr)
                            <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                <td class="py-1 px-3">{{ ($goodreceives ->currentpage()-1) * $goodreceives ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-1 px-3 font-medium">{{ $gr->good_receive_code }}</td>
                                <td class="py-1 px-3">{{ $gr->material['name'] }}</td>
                                <td class="py-1 px-3">{{ $gr->qty }}</td>
                                <td class="py-1 px-3">{{ $gr->supplier['name'] }}</td>
                                <td class="py-1 px-3">{{ $gr->print_date }}</td>
                                <td class="py-1 px-3">
                                    @if ($gr->status['name'] == "Pending")
                                        <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $gr->status['name'] }}
                                        </div>
                                    @elseif ($gr->status['name'] == "Complete")
                                        <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $gr->status['name'] }}
                                        </div>
                                    @else
                                        <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $gr->status['name'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-1 px-3">
                                    <div class="flex items-center gap-4">
                                        @if ($gr->qty == 0 && $gr->status['name'] == "Working")
                                            <button title="Selesai" wire:click="completeGR({{ $gr->id }})" class="text-white bg-green-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Selesai
                                            </button>
                                        @elseif ($gr->qty == 0)
                                            <button title="Sudah Diambil" wire:click="" class="text-white bg-red-500 p-2 rounded-lg font-medium" disabled>
                                                Sudah Diambil
                                            </button>
                                        @else
                                            <button title="Approve" wire:click="showApprove({{ $gr->id }})" class="text-white bg-green-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Approve
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
                {{ $goodreceives->links() }}
            </div>
        </div>

        {{-- INPUT TERIMA MODAL --}}
        @if ($showingReceived)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Material Diterima</h1>
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                        <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            type="number"
                            wire:model="qty_received"
                            max="{{ $getMaxReceive }}"
                        />
                    </div>
                    {{-- <p class="text-red-500">Material diterima telah melebihi jumlah maksimal</p> --}}
                    {{-- @error('qty_received') <p class="error text-red-500">Material diterima melebihi jumlah maksimal</p> @enderror --}}
                    <div class="mt-4">
                        <div class="flex justify-end">
                            <button wire:click="store" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
