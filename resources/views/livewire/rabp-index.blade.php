<div class="main-content bg-gray-50 flex-1">

    @section('title', 'RABP')

        {{-- PAGE TITLE --}}
        <div class="m-6">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Penawaran</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">Rancangan Anggaran Belanja Penawaran (RABP)</div>
                    </a>
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
                        {{-- <button wire:click="showRabpModal" class="py-2 px-4 text-center text-white rounded-xl border bg-purple-900">
                            <div class="flex items-center gap-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                <span>Add RABP</span>
                            </div>
                        </button>    --}}
                    </div>        
                </div>
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">No</th>
                            <th scope="col" class="py-3 px-6">Kode RABP</th>
                            <th scope="col" class="py-3 px-6">Kode Penawaran</th>
                            <th scope="col" class="py-3 px-6">Nama</th>
                            <th scope="col" class="py-3 px-6">Keterangan</th>
                            <th scope="col" class="py-3 px-6">Tanggal</th>
                            <th scope="col" class="py-3 px-6">Status</th>
                            <th scope="col" class="py-3 px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rabps as $rabp)
                        <tr
                            class="bg-white border-b hover:bg-gray-50 hover:text-black font-medium"
                        >
                            <td class="py-4 px-6">{{ ($rabps ->currentpage()-1) * $rabps ->perpage() + $loop->index + 1 }}</td>
                            <td class="py-4 px-6">{{ $rabp->budget_plan_code }}</td>
                            <td class="py-4 px-6">{{ $rabp->quotation['quotation_code'] }}</td>
                            <td class="py-4 px-6">{{ $rabp->quotation['name'] }}</td>
                            <td class="py-4 px-6">{{ $rabp->description }}</td>
                            <td class="py-4 px-6">{{ $rabp->date }}</td>
                            <td class="py-4 px-6">
                                <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                    {{ $rabp->status['name'] }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <button title="detail" wire:click="detailRabp({{ $rabp->id }})">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                    </button>
                                    <button title="edit" wire:click="showRabpEditModal( {{ $rabp->id }} )">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button title="tambah" wire:click="showRabpMaterial({{ $rabp->id }})">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    </button>
                                    <button wire:click="deleteRabp({{ $rabp->id }})">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="rounded-lg mt-6">
                {{ $rabps->links() }}
            </div>
        </div>

        {{-- RABP MODAL --}}
        @if ($showingRabpModal === true)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <div class="flex justify-between items-center">
                        @if($isEditMode === true)
                            <h1 class="font-medium text-xl">Update RABP</h1>
                        @else
                            <h1 class="font-medium text-xl">Add RABP</h1>
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
                            <h1>Date</h1>
                            <input
                                type="date"
                                wire:model.lazy="currentDate"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                disabled
                            />
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>RABP Code</h1>
                            <input
                                type="text"
                                wire:model="budget_plan_code"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                disabled
                            />
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Description</h1>
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
                                        wire:click="updateRabp"
                                        class="text-white bg-purple-900 py-2 px-6 rounded-xl"
                                    >
                                        Update
                                    </button>
                                @else
                                    <button
                                        wire:click="storeRabp"
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

        {{-- DETAIL MODAL --}}
        @if ($showingDetailRabpModal == true)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-xl">
                    <div class="flex justify-between">
                        <h1 class="font-medium text-xl">Detail RABP</h1>
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

                    <div class="h-[600px] overflow-y-auto pr-4">
                        <div class="mt-4 flex">
                            <h1 class="font-medium w-36">Kode Penawaran</h1>
                            <div>{{ $quotation_code }}</div>
                        </div>
                        <div class="mt-0.5 flex">
                            <h1 class="font-medium w-36">Tanggal</h1>
                            <div>{{ $quotation_date }}</div>
                        </div>
                        <div class="mt-0.5 flex">
                            <h1 class="font-medium w-36">Nama</h1>
                            <div>{{ $quotation_name }}</div>
                        </div>
                        <div class="mt-0.5 flex">
                            <h1 class="font-medium w-36">Customer</h1>
                            <div>{{ $quotation_customer }}</div>
                        </div>
                        <div class="mt-4 flex">
                            <h1 class="font-medium w-36">Kode RABP</h1>
                            <div>{{ $budget_plan_code }}</div>
                        </div>
                        <div class="mt-0.5 flex">
                            <h1 class="font-medium w-36">Description</h1>
                            <div>{{ $description }}</div>
                        </div>
                        <div class="mt-0.5 flex">
                            <h1 class="font-medium w-36">Status</h1>
                            <div>{{ $status_id }}</div>
                        </div>
                        <div class="mt-0.5 flex">
                            <h1 class="font-medium w-36">Pembuat</h1>
                            <div>{{ $users_id }}</div>
                        </div>

                        <div class="mt-4 flex">
                            <h1 class="font-medium w-36">Detail Material</h1>
                            <div class="border border-gray-300/50 p-2 rounded-xl shadow-sm">
                                <table class="w-full text-sm text-left text-gray-600">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            {{-- <th scope="col" class="py-1.5 px-6">Kode Material</th> --}}
                                            <th scope="col" class="py-1.5 px-6">Nama</th>
                                            <th scope="col" class="py-1.5 px-6">Satuan</th>
                                            <th scope="col" class="py-1.5 px-6">Qty</th>
                                            <th scope="col" class="py-1.5 px-6">Harga</th>
                                            <th scope="col" class="py-1.5 px-6">Harga Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bill_materials as $bm)
                                            <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                                {{-- <td scope="col" class="py-1.5 px-6">Kode Material</td> --}}
                                                <td scope="col" class="py-1.5 px-6">{{ $bm->material['name'] }}</td>
                                                <td scope="col" class="py-1.5 px-6">{{ $bm->material->measurement['name'] }}</td>
                                                <td scope="col" class="py-1.5 px-6">{{ $bm->quantity }}</td>
                                                <td scope="col" class="py-1.5 px-6">Rp. {{ number_format($bm->price) }}</td>
                                                <td scope="col" class="py-1.5 px-6">Rp. {{ number_format($bm->total_price) }}</td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td colspan="4" class="text-right font-bold">Biaya Overhead</td>
                                                <td class="py-1.5 px-6">Rp. 1,000,000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right font-bold">Profit</td>
                                                <td class="py-1.5 px-6">Rp. 1,000,000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right font-bold">PPN</td>
                                                <td class="py-1.5 px-6">Rp. 1,000,000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right font-bold">Total RABP</td>
                                                <td class="py-1.5 px-6">Rp. 1,000,000</td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- RABP MATERIAL MODAL --}}
        @if ($showingRabpMaterialModal)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Tambah RABP Material</h1>
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

                    <div class="h-[500px] overflow-y-auto overflow-x-hidden pr-4">
                        <div class="mt-4">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Material</th>
                                        <th scope="col" class="py-3 px-6">Qty</th>
                                        {{-- <th scope="col" class="py-3 px-6">Satuan</th> --}}
                                        <th scope="col" class="py-3 px-6">Harga</th>
                                        <th scope="col" class="py-3 px-6">Harga Total</th>
                                        <th scope="col" class="py-3 px-6">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bill_materials as $bm)
                                        <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                            <td class="py-2 px-6">{{ $bm->material['name'] }}</td>
                                            <td class="py-2 px-6">{{ $bm->quantity }}</td>
                                            {{-- <td class="py-2 px-6">{{ $bm->material->measurement['name'] }}</td> --}}
                                            <td class="py-2 px-6">Rp. {{ number_format($bm->price) }}</td>
                                            <td class="py-2 px-6">Rp. {{ number_format($bm->total_price) }}</td>
                                            <td class="py-2 px-6">
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
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="font-medium">
                                        <input wire:model="budget_plans_id" type="hidden" />
                                        <td class="py-2 px-2">
                                            <select
                                                wire:model="materials_id"
                                                class="border-gray-300/50 rounded-xl text-sm w-36 text-center"
                                            >
                                                @foreach ($materials as $material)
                                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="py-2 px-2">
                                            <input
                                                wire:model="quantity"
                                                class="border-gray-300/50 rounded-xl text-sm w-20 text-center"
                                                type="number"
                                                min="1"
                                            />
                                        </td>
                                        {{-- <td class="py-2 px-2">
                                            <input
                                                wire:model="measurements_id"
                                                class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center"
                                                type="text"
                                                disabled
                                            />
                                        </td> --}}
                                        <td class="py-2 px-2">
                                            <input
                                                wire:model="price"
                                                class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center"
                                                type="number"
                                                disabled
                                            />
                                        </td>
                                        <td class="py-2 px-2">
                                            <input
                                                wire:model="total_price"
                                                class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center"
                                                type="number"
                                                disabled
                                            />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="border black w-full mt-4"></div>
                    
                    <div class="flex justify-end mt-4">
                        <button
                            wire:click="storeRabpMaterial"
                            class="text-white bg-purple-900 py-2 px-6 rounded-xl"
                        >
                            Submit
                        </button>
                    </div>   
                </div>
            </div>
        @endif
</div>
