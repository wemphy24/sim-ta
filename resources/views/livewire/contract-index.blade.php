<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">
    
    @section('title', 'Kontrak')

    @if ($showingMainPage)
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#"><div class="font-medium text-lg text-gray-400">Kontrak</div></a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#"><div class="font-medium text-lg">List Kontrak</div></a>
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
                <button wire:click="" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat Kontrak</span>
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
                            <option value="production_code">KODE KONTRAK</option>
                            <option value="name">NAMA</option>
                            <option value="contract_value">JUMLAH KONTRAK</option>
                            <option value="description">KETERANGAN</option>
                            <option value="finish_date">SELESAI</option>
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
                            <th scope="col" class="py-3 px-2">Kode Kontrak</th>
                            <th scope="col" class="py-3 px-2">Nama</th>
                            <th scope="col" class="py-3 px-2">Jumlah Kontrak</th>
                            <th scope="col" class="py-3 px-2">Selesai</th>
                            <th scope="col" class="py-3 px-2">Status</th>
                            <th scope="col" class="py-3 px-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($contracts as $contract)
                            <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                <td class="py-2 px-2">{{ ($contracts ->currentpage()-1) * $contracts ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-2 px-2 font-bold">{{ $contract->contract_code }}</td>
                                <td class="py-2 px-2">{{ $contract->name }}</td>
                                <td class="font-medium py-2 px-2">RP. {{ number_format($contract->contract_value) }}</td>
                                <td class="py-2 px-2">{{ date('d-m-Y', strtotime($contract->finish_date)) }}</td>
                                <td class="py-2 px-2">
                                    @if ($contract->status['name'] == "Working")
                                        <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $contract->status['name'] }}
                                        </div>
                                    @elseif ($contract->status['name'] == "Complete")
                                        <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $contract->status['name'] }}
                                        </div>
                                    @else
                                        <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $contract->status['name'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-1 px-3">
                                    <div class="flex items-center gap-4">
                                        <button wire:click="detail({{ $contract->id }})" class="bg-blue-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="rounded-lg mt-6">
                {{ $contracts->links() }}
            </div>
        </div>
    @endif

    {{-- DETAIL MODAL --}}
    @if ($showingDetail)
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Kontrak</div>
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
            {{-- SECTION DATA KONTRAK --}}
            <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                <div class="bg-white py-3 px-6">

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kode Kontrak:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="text"
                                wire:model="contract_code"
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
                            <label>Nama Penawaran:</label>
                            <select wire:model="quotations_id" class="w-full border-gray-300/50 rounded-lg text-sm bg-gray-100" disabled>
                                @foreach ($quotations as $quotation)
                                    <option value="{{ $quotation->id }}">{{ $quotation->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:w-1/2">
                            <label>Jumlah Kontrak:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="text" value="{{ number_format($contract_value) }}" disabled/>
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Mulai Kontrak:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="date" disabled
                                wire:model="start_date" 
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Akhir Kontrak:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="date" disabled
                                wire:model="finish_date"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Status:</label>
                                @if ($status_id == "Pending")
                                    <input wire:model="status_id" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-red-200 font-bold" disabled/>
                                @elseif ($status_id == "Working")
                                    <input wire:model="status_id" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-yellow-200 font-bold" disabled/>
                                @else
                                    <input wire:model="status_id" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-green-200 font-bold" disabled/>
                                @endif
                        </div>
                    </div>

                </div>
            </div>
            {{--  --}}

            {{-- BUTTON ACTION--}}
            <div class="py-3 px-6">
                <div class="flex justify-end gap-4">
                    <button wire:click="updateContract" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        Simpan
                    </button>
                </div>
            </div>
            {{--  --}}

            {{-- SECTION DATA BARANG --}}
            <div class="bg-white overflow-x-auto sm:rounded-lg border border-gray-300/50 mt-6">
                <div class="py-3 px-6">
                    <div class="font-medium text-xl mb-3">Daftar Barang</div>
                    <table class="w-full text-sm text-left text-black">
                        <thead class="bg-zinc-200">
                            <tr>
                                <th scope="col" class="py-3 px-6">Barang</th>
                                <th scope="col" class="py-3 px-6">Qty</th>
                                <th scope="col" class="py-3 px-6">Satuan</th>
                                {{-- <th scope="col" class="py-3 px-6">Harga</th> --}}
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($detailrabps as $detailrabp)
                                <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                    <td class="py-2 px-6">{{ $detailrabp->good['name'] }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->qty }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->good->measurement['name'] }}</td>
                                    {{-- <td class="py-2 px-6">RP. {{ number_format($total_price) }}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{--  --}}
        </div>
    @endif
</div>
