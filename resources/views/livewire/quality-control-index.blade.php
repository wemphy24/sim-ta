<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">

    @section('title', 'Quality Control')

    @if ($showingMainPage)

        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Pengelolaan</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">Quality Control</div>
                    </a>
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
                <button wire:click="showMaterialModal" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat QC</span>
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
                            <option value="productions_id">NAMA PRODUKSI</option>
                            <option value="quality_control_code">KODE QC</option>
                            <option value="name">NAMA QUALITY CONTROL</option>
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
                            <th scope="col" class="py-3 px-2">Kode QC</th>
                            <th scope="col" class="py-3 px-2">Nama Produksi</th>
                            <th scope="col" class="py-3 px-2">Nama QC</th>
                            <th scope="col" class="py-3 px-2">Keterangan</th>
                            <th scope="col" class="py-3 px-2">Mulai QC</th>
                            <th scope="col" class="py-3 px-2">Finish QC</th>
                            <th scope="col" class="py-3 px-2">Status</th>
                            <th scope="col" class="py-3 px-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($qualitycontrols as $qc)
                            <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                <td class="py-2 px-4">{{ ($qualitycontrols ->currentpage()-1) * $qualitycontrols ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-2 px-2 font-bold">{{ $qc->quality_control_code }}</td>
                                <td class="py-2 px-2">{{ $qc->production['name'] }}</td>
                                <td class="py-2 px-2">{{ $qc->name }}</td>
                                <td class="py-2 px-2">{{ $qc->description }}</td>
                                <td class="py-2 px-2">{{ date('d-m-Y', strtotime($qc->start_qc)) }}</td>
                                @if ($qc->end_qc == NULL)
                                    <td class="py-2 px-3">Belum Diketahui</td>
                                @else
                                    <td class="py-2 px-3">{{ date('d-m-Y', strtotime($qc->end_qc)) }}</td>
                                @endif
                                <td class="py-2 px-3">
                                @if ($qc->status['name'] == "Working")
                                    <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                        {{ $qc->status['name'] }}
                                    </div>
                                @elseif ($qc->status['name'] == "Complete")
                                    <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                        {{ $qc->status['name'] }}
                                    </div>
                                @else
                                    <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                        {{ $qc->status['name'] }}
                                    </div>
                                @endif
                                </td>
                                <td class="py-2 px-3">
                                    <div class="flex items-center gap-4">
                                        <button wire:click="detail( {{ $qc->id }} )" class="bg-blue-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
                {{ $qualitycontrols->links() }}
            </div>
        </div>

    @endif

    {{-- DETAIL MODAL --}}
    @if ($showingDetail)
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Quality Control</div>
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
            {{-- SECTION DATA QUALITY CONTROL --}}
            <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                <div class="bg-white py-3 px-6">

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kode QC:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="text"
                                wire:model="quality_control_code"
                                disabled
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Nama QC:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="name"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Nama Produksi:</label>
                            <select wire:model="productions_id" class="w-full border-gray-300/50 rounded-lg text-sm bg-gray-100" disabled>
                                @foreach ($productions as $production)
                                    <option value="{{ $production->id }}">{{ $production->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:w-1/2">
                            <label>Keterangan:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="text" disabled
                                wire:model="description"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Mulai QC:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="date" disabled
                                wire:model="start_qc" 
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Finish QC:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="date" disabled
                                wire:model="end_qc" 
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
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-yellow-200 font-bold"
                                    type="text"
                                    wire:model="status_id"
                                    disabled
                                />
                            @else
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-green-200 font-bold"
                                    type="text"
                                    wire:model="status_id"
                                    disabled
                                />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{--  --}}

            {{-- BUTTON ACTION--}}
            <div class="py-3 px-6">
                <div class="flex justify-end gap-4">
                    <button wire:click="updateProduction" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        Simpan
                    </button>
                </div>
            </div>
            {{--  --}}

            {{-- SECTION DAFTAR BARANG --}}
            <div class="bg-white overflow-x-auto sm:rounded-lg border border-gray-300/50 mt-6">
                <div class="py-3 px-6">
                    <div class="font-medium text-xl mb-3">Daftar Barang Yang Di QC</div>
                    <table class="w-full text-sm text-left text-black">
                        <thead class="bg-zinc-200">
                            <tr>
                                <th scope="col" class="py-3 px-6">Barang</th>
                                <th scope="col" class="py-3 px-6">Qty</th>
                                <th scope="col" class="py-3 px-6">Satuan</th>
                                <th scope="col" class="py-3 px-6">Status</th>
                                <th scope="col" class="py-3 px-6">Keterangan</th>
                                <th scope="col" class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($detailrabps as $detailrabp)
                                <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                    <td class="py-2 px-6">{{ $detailrabp->good['name'] }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->qty }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->good->measurement['name'] }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->good->status_production }}</td>
                                    <td class="py-2 px-6 text-green-500">{{ $detailrabp->good->status_qc }}</td>
                                    <td class="py-2 px-6 text-white">
                                        <div class="flex items-center gap-4">
                                            <button wire:click="detailMaterial({{ $detailrabp->goods_id }})" class="bg-blue-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                            </button>
                                            @if ($detailrabp->good->status_production == "Selesai Produksi")
                                                <button wire:click="changeStatus({{ $detailrabp->goods_id }})" class="bg-green-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                    Mulai QC
                                                </button>
                                            @elseif ($detailrabp->good->status_production == "Sedang QC")
                                                <button wire:click="doneRetur({{ $detailrabp->goods_id }})" class="bg-green-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                    Selesai QC
                                                </button>
                                            @elseif ($detailrabp->good->status_production == "Selesai QC")
                                                <button wire:click="" class="bg-red-500 px-2 py-1 rounded-md" disabled>
                                                    QC Selesai
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{--  --}}
        </div>


        {{-- SECTION DETAIL MATERIAl --}}
        @if ($showingDetailMaterial)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">{{ $good_name }}</h1>
                        <button wire:click="closeDetailMaterial">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="border black w-full mt-4"></div>

                    <div class="overflow-y-auto overflow-x-hidden">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Material</th>
                                    <th scope="col" class="py-3 px-6">Qty Rencana</th>
                                    <th scope="col" class="py-3 px-6">Satuan</th>
                                    <th scope="col" class="py-3 px-6">Terima</th>
                                    <th scope="col" class="py-3 px-6">Pasang</th>
                                    <th scope="col" class="py-3 px-6">Sisa</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rabpmaterials as $rm)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">{{ $rm->material['name'] }}</td>
                                        <td class="py-2 px-6">{{ $rm->qty }}</td>
                                        <td class="py-2 px-6">{{ $rm->material->measurement['name'] }}</td>
                                        <td class="py-2 px-6">{{ $rm->qty_received }}</td>
                                        <td class="py-2 px-6">{{ $rm->qty_install }}</td>
                                        <td class="py-2 px-6">{{ $rm->qty_remaining }}</td>
                                        <td class="py-2 px-6">
                                            @if ($rm->status == "Sudah Diambil")
                                                <button class="text-white rounded-md px-2 py-1  bg-green-500" wire:click="printRetur({{ $rm->id }})">Retur</button> 
                                            @elseif ($rm->status == "Sedang Retur")
                                                <button class="text-white rounded-md px-2 py-1 bg-yellow-500" wire:click="" disabled>Sedang Retur</button> 
                                            @elseif ($rm->status == "Sudah Retur")
                                                <button class="text-white rounded-md px-2 py-1 bg-red-500" wire:click="" disabled>Selesai Retur</button> 
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-center items-center gap-2">
                        @if ($status_qc != NULL)
                        
                        @else
                        <label class="font-medium">Kelayakan Barang: </label>
                            <button wire:click="qcOk" class="text-white font-medium bg-green-500 my-2 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                OK
                            </button>
                            <button wire:click="qcOnhold" class="text-white font-medium bg-red-500 my-2 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                On Hold
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endif
    
</div>
