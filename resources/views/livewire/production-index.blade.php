<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">

    @section('title', 'Produksi')

    @if ($showingMainPage)

        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Produksi</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">List Produksi</div>
                    </a>
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
                <button wire:click="showMaterialModal" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat Produksi</span>
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
                            <option value="production_code">KODE PRODUKSI</option>
                            <option value="name">NAMA PRODUKSI</option>
                            <option value="rabps_id">NAMA RABP</option>
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
                            <th scope="col" class="py-3 px-6">#</th>
                            <th scope="col" class="py-3 px-3">Kode Produksi</th>
                            <th scope="col" class="py-3 px-3">Nama Produksi</th>
                            <th scope="col" class="py-3 px-6">Nama RABP</th>
                            <th scope="col" class="py-3 px-3">Keterangan</th>
                            <th scope="col" class="py-3 px-3">Deadline</th>
                            <th scope="col" class="py-3 px-3">Status</th>
                            <th scope="col" class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productions as $production)
                            <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                <td class="py-1 px-6">{{ ($productions ->currentpage()-1) * $productions ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-1 px-6 font-medium">{{ $production->production_code }}</td>
                                <td class="py-1 px-6">{{ $production->name }}</td>
                                <td class="py-1 px-6">{{ $production->rabp['name'] }}</td>
                                <td class="py-1 px-6">{{ $production->description }}</td>
                                <td class="py-1 px-6">{{ $production->deadline }}</td>
                                <td class="py-1 px-3">
                                    @if ($production->status['name'] == "Working")
                                        <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $production->status['name'] }}
                                        </div>
                                    @elseif ($production->status['name'] == "Complete")
                                        <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $production->status['name'] }}
                                        </div>
                                    @else
                                        <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $production->status['name'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-1 px-6">
                                    <div class="flex items-center gap-4">
                                        <button wire:click="detail( {{ $production->id }} )" class="bg-blue-500 px-2 py-1 rounded-md">
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
                {{ $productions->links() }}
            </div>
        </div>

    @endif

    {{-- DETAIL MODAL --}}
    @if ($showingDetail)
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Produksi</div>
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
            {{-- SECTION DATA PRODUKSI --}}
            <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                <div class="bg-white py-3 px-6">

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kode Produksi:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="text"
                                wire:model="production_code"
                                disabled
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Nama Produksi:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="name"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Nama RABP:</label>
                            <select wire:model="rabps_id" class="w-full border-gray-300/50 rounded-lg text-sm bg-gray-100" disabled>
                                @foreach ($rabps as $rabp)
                                    <option value="{{ $rabp->id }}">{{ $rabp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:w-1/2">
                            <label>Keterangan:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm" type="text"
                                wire:model="description"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Deadline:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="text" disabled
                                wire:model="deadline" 
                            />
                        </div>
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
                    </div>

                </div>
            </div>
            {{--  --}}

            {{-- BUTTON ACTION--}}
            <div class="py-3 px-6">
                <div class="flex justify-end gap-4">
                    <button wire:click="updateProduction" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white">
                        Simpan
                    </button>
                </div>
            </div>
            {{--  --}}

            {{-- SECTION DAFTAR BARANG --}}
            <div class="bg-white overflow-x-auto sm:rounded-lg border border-gray-300/50 mt-6">
                <div class="py-3 px-6">
                    <div class="font-medium text-xl mb-3">Daftar Barang</div>
                    <table class="w-full text-sm text-left text-black">
                        <thead class="bg-zinc-200">
                            <tr>
                                <th scope="col" class="py-3 px-6">Barang</th>
                                <th scope="col" class="py-3 px-6">Qty</th>
                                <th scope="col" class="py-3 px-6">Satuan</th>
                                <th scope="col" class="py-3 px-6">Status</th>
                                <th scope="col" class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($detailrabps as $detailrabp)
                                <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                    <td class="py-2 px-6">{{ $detailrabp->set_good['name'] }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->qty }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->set_good->measurement['name'] }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->set_good->status }}</td>
                                    <td class="py-2 px-6 text-white">
                                        <div class="flex items-center gap-4">
                                            <button wire:click="detailMaterial({{ $detailrabp->set_goods_id }})" class="bg-blue-500 px-2 py-1 rounded-md">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                            </button>
                                            @if ($detailrabp->set_good->status == "Siap Dirakit")
                                                <button wire:click="changeProgress({{ $detailrabp->set_goods_id }})" class="bg-green-500 px-2 py-1 rounded-md">
                                                    Mulai Produksi
                                                </button>
                                            @elseif ($detailrabp->set_good->status == "Sedang Dirakit")
                                                <button wire:click="" class="bg-yellow-500 px-2 py-1 rounded-md" disabled>
                                                    Sedang Dirakit
                                                </button>
                                            @else
                                                <button wire:click="" class="bg-red-500 px-2 py-1 rounded-md" disabled>
                                                    Selesai Dirakit
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
                                    <th scope="col" class="py-3 px-6">Qty</th>
                                    <th scope="col" class="py-3 px-6">Satuan</th>
                                    <th scope="col" class="py-3 px-6">Terima</th>
                                    <th scope="col" class="py-3 px-6">Pasang</th>
                                    <th scope="col" class="py-3 px-6">Sisa</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($setbillmaterials as $sbm)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">{{ $sbm->material['name'] }}</td>
                                        <td class="py-2 px-6">{{ $sbm->qty * $count_material }}</td>
                                        <td class="py-2 px-6">{{ $sbm->material->measurement['name'] }}</td>
                                        <td class="py-2 px-6">{{ $sbm->qty_received }}</td>
                                        <td class="py-2 px-6">{{ $sbm->qty_install }}</td>
                                        <td class="py-2 px-6">{{ $sbm->qty_remaining }}</td>
                                        <td class="py-2 px-6">
                                            <div class="flex items-center gap-4">
                                                <button class="text-white rounded-md px-2 py-1  bg-blue-500" wire:click="editProgress({{ $sbm->id }})">Edit</button>
                                                @if ($sbm->status == "Belum Diambil")
                                                    <button class="text-white rounded-md px-2 py-1 bg-green-500" wire:click="printMaterial({{ $sbm->materials_id }})">Ambil</button>  
                                                @else
                                                    <button class="text-white rounded-md px-2 py-1 bg-red-500" wire:click="" disabled>Sudah Diambil</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- SECTION EDIT DETAIL MATERIAL --}}
        @if ($showingEditDetailMaterial)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">{{ $good_name }}</h1>
                        <button wire:click="closeEditProgress">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="border black w-full mt-4"></div>

                    <div class="overflow-y-auto overflow-x-hidden">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Material</th>
                                    <th scope="col" class="py-3 px-6">Qty</th>
                                    <th scope="col" class="py-3 px-6">Satuan</th>
                                    <th scope="col" class="py-3 px-6">Terima</th>
                                    <th scope="col" class="py-3 px-6">Pasang</th>
                                    <th scope="col" class="py-3 px-6">Sisa</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($editsetbillmaterials as $esbm)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">{{ $esbm->material['name'] }}</td>
                                        <td class="py-2 px-6">{{ $esbm->qty * $count_material }}</td>
                                        <td class="py-2 px-6">{{ $esbm->material->measurement['name'] }}</td>
                                        <td class="py-2 px-6">
                                            <input wire:model="qty_received" type="number" class="w-24 border-gray-300/50  rounded-lg text-sm text-center bg-gray-100" disabled/>
                                        </td>
                                        <td class="py-2 px-6">
                                            <input wire:model="qty_install" type="number" class="w-24 border-gray-300/50  rounded-lg text-sm text-center"/>
                                        </td>
                                        <td class="py-2 px-6">
                                            <input wire:model="qty_remaining" type="number" class="w-24 border-gray-300/50  rounded-lg text-sm text-center"/>
                                        </td>
                                        <td class="py-2 px-6">
                                            <button wire:click="storeEditProgress" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white">
                                                Simpan
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @endif
    
</div>
