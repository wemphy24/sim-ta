<div class="main-content bg-gray-50 flex-1">

    @section('title', 'Perencanaan Anggaran')

    {{-- PAGE TITLE --}}
    <div class="m-6">
        <div class="m-6">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Penawaran</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">Perencanaan Anggaran</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE DATA --}}
    <div class="m-6">
        <div class="overflow-x-auto sm:rounded-xl border border-gray-300/50">
            <div class="bg-white border-b-2 py-3 px-6 flex justify-between gap-4">
                <div class="flex items-center gap-4">
                    <select wire:model="showPage" class="border-gray-300/50 rounded-xl text-sm">
                        <option value="5">5</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                    <input wire:model="search" class="w-96 border-gray-300/50 rounded-xl p-2 text-sm" type="text" placeholder="Search">
                </div>
                <div class="flex items-center gap-4">
                    <button class="py-2 px-4 text-center rounded-xl border hover:bg-purple-900 hover:text-white">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                            <span>Download CSV</span>
                        </div> 
                    </button>
                    <button wire:click="showPlanningModal" class="py-2 px-4 text-center text-white rounded-lg border bg-purple-900">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Buat RABP</span>
                        </div>
                    </button>  
                </div>        
            </div>
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">#</th>
                        <th scope="col" class="py-3 px-6">Kode RABP</th>
                        <th scope="col" class="py-3 px-6">Nama RABP</th>
                        <th scope="col" class="py-3 px-6">Nama Penawaran</th>
                        <th scope="col" class="py-3 px-6">Keterangan</th>
                        <th scope="col" class="py-3 px-6">Tanggal</th>
                        <th scope="col" class="py-3 px-6">Status</th>
                        <th scope="col" class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planning_costs as $planning_cost)
                    <tr
                        class="bg-white border-b hover:bg-gray-50 hover:text-black font-medium"
                    >
                        <td class="py-4 px-6">{{ ($planning_costs ->currentpage()-1) * $planning_costs ->perpage() + $loop->index + 1 }}</td>
                        <td class="py-4 px-6">{{ $planning_cost->rabp_code }}</td>
                        <td class="py-4 px-6">{{ $planning_cost->name }}</td>
                        <td class="py-4 px-6">{{ $planning_cost->quotation['name'] }}</td>
                        <td class="py-4 px-6">{{ $planning_cost->description }}</td>
                        <td class="py-4 px-6">{{ $planning_cost->date }}</td>
                        <td class="py-4 px-6">
                            <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                {{ $planning_cost->status['name'] }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <button title="Approve" wire:click="approvePlanning({{ $planning_cost->id }})">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button title="Set Barang" wire:click="showItemModal({{ $planning_cost->id }})">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                                </button>
                                <button title="Edit" wire:click="showPlanningEditModal({{ $planning_cost->id }})">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button title="Detail" wire:click="detailPlanning({{ $planning_cost->id }})">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                </button>
                                <button disabled title="Hapus" wire:click="deletePlanning({{ $planning_cost->id }})">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="rounded-lg mt-6">
            {{ $planning_costs->links() }}
        </div>
    </div>

    {{-- RABP MODAL --}}
    @if ($showingPlanningModal === true)
        <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
            <div class="bg-white p-4 rounded-xl shadow-md">
                <div class="flex justify-between items-center">
                    @if($isEditMode === true)
                        <h1 class="font-medium text-xl">Edit RABP</h1>
                    @else
                        <h1 class="font-medium text-xl">Tambah RABP</h1>
                    @endif
                    <button wire:click="closeModal">
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
                                d="M6 18L18 6M6 6l12 12"
                            ></path>
                        </svg>
                    </button>
                </div>
                
                <div class="border black w-full mt-4"></div>

                <div class="mt-4">
                    <div class="flex items-center gap-8 justify-between p-1">
                        <h1>Tanggal</h1>
                        <input
                            type="date"
                            wire:model.lazy="date"
                            class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                            disabled
                        />
                    </div>
                    <div class="flex items-center gap-8 justify-between p-1">
                        <h1>Nama Penawaran</h1>
                        <select
                            class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            wire:model="quotations_id"
                        >
                            <option value="">Pilih Penawaran</option>
                            @foreach ($quotations as $quotation)
                                <option value="{{ $quotation->id }}">{{ $quotation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center gap-8 justify-between p-1">
                        <h1>Kode RABP</h1>
                        <input
                            type="text"
                            wire:model="rabp_code"
                            class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                            disabled
                        />
                    </div>
                    <div class="flex items-center gap-8 justify-between p-1">
                        <h1>Nama RABP</h1>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                        />
                    </div>
                    <div class="flex items-center gap-8 justify-between p-1">
                        <h1>Keterangan</h1>
                        <input
                            type="text"
                            wire:model="description"
                            class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                        />
                    </div>

                    <div class="border black w-full mt-4"></div>

                    <div class="mt-4">
                        <div class="flex justify-end">
                            @if($isEditMode == true)
                                <button
                                    wire:click="updatePlanning"
                                    class="text-white bg-purple-900 py-2 px-6 rounded-xl"
                                >
                                    Update
                                </button>
                            @else
                                <button
                                    wire:click="storePlanning"
                                    class="text-white bg-purple-900 py-2 px-6 rounded-xl"
                                >
                                    Submit
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- SET ITEM MODAL --}}
    @if ($showingItemModal)
        <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Set Barang RABP</h1>
                        <button wire:click="closeModal">
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
                                    d="M6 18L18 6M6 6l12 12"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="border black w-full mt-4"></div>
                    
                    <div class="my-4">
                        <div class="flex items-center gap-4">
                            <div class="p-1">
                                <div class="flex items-center">
                                    <h1 class="w-24">Overhead</h1>
                                    <input
                                        type="number"
                                        wire:model="overhead_cost"
                                        class="border border-gray-300/50 rounded-xl p-2 text-sm"
                                        min="1"
                                        required
                                    />
                                </div>
                            </div>  
                            <div class="p-1">
                                <div class="flex items-center">
                                    <h1 class="w-20">Profit</h1>
                                    <input
                                        type="number"
                                        wire:model="profit"
                                        class="w-16 border border-gray-300/50 rounded-xl p-2 text-sm"
                                        min="1"
                                        required
                                    />
                                    <span class="py-2 w-6 text-right">%</span>
                                </div>
                            </div>  
                        </div>            
                        <div class="flex items-center gap-4">
                            <div class="p-1">
                                <div class="flex items-center">
                                    <h1 class="w-24 items-center">Preliminary</h1>
                                    <input
                                        type="number"
                                        wire:model="preliminary_cost"
                                        class="border border-gray-300/50 rounded-xl p-2 text-sm"
                                        min="1"
                                        required
                                    />
                                </div>
                            </div>  
                            <div class="p-1">
                                <div class="flex items-center">
                                    <h1 class="w-20">PPN</h1>
                                    <input
                                        type="number"
                                        wire:model="ppn"
                                        class="w-16 border border-gray-300/50 rounded-xl p-2 text-sm bg-gray-100 text-center"
                                        min="1"
                                        disabled
                                    />
                                    <span class="py-2 w-6 text-right">%</span>
                                </div>
                            </div>  
                        </div>
                    </div>            

                    <div class="h-[400px] overflow-y-auto overflow-x-hidden pr-4">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Nama</th>
                                    <th scope="col" class="py-3 px-6">Satuan</th>
                                    <th scope="col" class="py-3 px-6">Qty</th>
                                    <th scope="col" class="py-3 px-6">Harga</th>
                                    {{-- <th scope="col" class="py-3 px-6">Harga Total</th> --}}
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($finish_gooods as $fg) --}}
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">a</td>
                                        <td class="py-2 px-6">a</td>
                                        <td class="py-2 px-6">a</td>
                                        <td class="py-2 px-6">a</td>
                                        {{-- <td class="py-2 px-6">a</td> --}}
                                        <td class="py-2 px-6">
                                            <div class="flex items-center gap-4">
                                                <button disabled>
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                                </button>
                                                <button disabled>
                                                <svg
                                                    class="w-5 h-5 text-red-500"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    ></path>
                                                </svg>
                                                </button>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                {{-- @endforeach --}}
                            </tbody>
                            <tfoot>
                                <tr class="font-medium">
                                    <input wire:model="planning_costs_id" type="hidden" />
                                    <td class="py-2 px-2">
                                        <input 
                                            wire:model="keyword" 
                                            {{-- wire:click="updateKeyword" --}}
                                            class="border-gray-300/50  rounded-xl text-sm w-36 text-center"
                                            type="text"
                                        />
                                        @if (strlen($keyword) > 2)
                                            <div class="absolute text-sm">
                                                @if ($results->count() > 0)
                                                    <ul>
                                                        @foreach ($results as $result)
                                                            @if ($showKeyword)
                                                                <li 
                                                                    wire:click="updateKeyword('{{ $result->name }}')" class="border border-hray-300/50 w-36 px-2 py-2 rounded-xl cursor-pointer">
                                                                    {{ $result->name }}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <ul>
                                                        <li class="border border-hray-300/50 w-36 px-2 py-2 rounded-xl">
                                                            <span class="ml-2">No Result</span>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-2 px-2">
                                        <select
                                            class="w-20 border border-gray-300/50 rounded-xl bg-gray-100 shadow-sm text-sm"
                                            wire:model="measurements_id"
                                            disabled
                                        >
                                            @foreach ($measurements as $measurement)
                                                @if ($keyword != $measurement->name)        
                                                    <option value=""></option>
                                                @endif
                                                    <option value="{{ $measurement->id }}">{{ $measurement->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2 px-2">
                                        <input
                                            wire:model="qty"
                                            class="border-gray-300/50 rounded-xl text-sm w-20 text-center"
                                            type="number"
                                        />
                                    </td>
                                    <td class="py-2 px-2">
                                        <input
                                            wire:model="price"
                                            class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center"
                                            type="number"
                                            disabled
                                        />
                                    </td>
                                    {{-- <td class="py-2 px-2">
                                        <input
                                            wire:model="total_price"
                                            class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center"
                                            type="number"
                                            disabled
                                        />
                                    </td> --}}
                                    <td class="py-2 px-6">
                                        <button wire:click="storeRabpMaterial">
                                            <svg class="w-5 h-5 text-purple-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </td>
                                    {{-- <td>
                                        <input 
                                        wire:model="keyword" 
                                        wire:keydown="updateKeyword"
                                        class="border-gray-300/50  rounded-xl text-sm w-36 text-center"
                                        type="text"
                                        />
                                        @if (strlen($keyword) > 2)
                                            <div class="absolute text-sm">
                                                @if ($results->count() > 0)
                                                    <ul>
                                                        @foreach ($results as $result)
                                                            <li class="border border-hray-300/50 w-36 px-2 py-2 rounded-xl cursor-pointer">
                                                                {{ $result->name }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <ul>
                                                        <li class="border border-hray-300/50 w-36 px-2 py-2 rounded-xl">
                                                            <span class="ml-2">No Result</span>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </div>
                                        @endif
                                    </td> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="border black w-full mt-4"></div>

                    <div class="flex justify-end mt-4">
                        {{-- @if ($overhead_cost == NULL || $preliminary_cost == NULL || $profit == NULL || $checkExistBillMaterial <= 0) --}}
                            {{-- <button
                                disabled
                                wire:click="storeRabpCostMaterial"
                                class="text-white bg-gray-100 py-2 px-6 rounded-xl"
                            >
                                Submit
                            </button> --}}
                        {{-- @else --}}
                            <button
                                wire:click="storeRabpCostMaterial"
                                class="text-white bg-purple-900 py-2 px-6 rounded-xl"
                            >
                                Submit
                            </button>
                        {{-- @endif --}}
                    </div>   
                </div>
            </div>
    @endif

</div>
