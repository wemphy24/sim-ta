<div class="main-content bg-gray-50 flex-1 ml-64 h-screen">

    @section('title', 'RABP')

        @if ($showingMainPage)
        
            {{-- PAGE TITLE --}}
            <div class="m-6">
                <div class="flex justify-between">
                    <div class="flex items-center gap-4">
                        <a href="#">
                            <div class="font-medium text-lg text-gray-400">Penawaran</div>
                        </a>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        <a href="#">
                            <div class="font-medium text-lg">Rancangan Anggaran Biaya Penawaran (RABP)</div>
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- TABLE DATA --}}
            <div class="m-6">
                <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                    <div class="bg-white border-b-2 py-3 px-6 flex justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <select wire:model="showPage" class="border-gray-300/50 rounded-lg text-sm">
                                <option value="5">5</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                            </select>
                            <input wire:model="search" class="w-96 border-gray-300/50 rounded-lg p-2 text-sm" type="text" placeholder="Search">
                            <select wire:model="searchBy" class="border-gray-300/50 rounded-lg text-sm">
                                <option value="rabp_code">KODE RABP</option>
                                <option value="name">NAME</option>
                                <option value="description">KETERANGAN</option>
                                <option value="date">TANGGAL</option>
                                {{-- <option value="status_id">STATUS</option> --}}
                            </select>
                            <select wire:model="orderAsc" class="border-gray-300/50 rounded-lg text-sm">
                                <option value="1">Ascending</option>
                                <option value="0">Descending</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-4">
                            <button class="py-2 px-4 text-center rounded-lg border hover:bg-purple-900 hover:text-white">
                                <div class="flex items-center gap-1">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                                    <span>Download CSV</span>
                                </div> 
                            </button>
                            <button wire:click="showRabp" class="py-2 px-4 text-center text-white rounded-lg border bg-purple-900">
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
                                <td class="py-4 px-6 font-bold">{{ $rabp->rabp_code }}</td>
                                <td class="py-4 px-6">{{ $rabp->quotation['quotation_code'] }}</td>
                                <td class="py-4 px-6">{{ $rabp->name }}</td>
                                <td class="py-4 px-6">{{ $rabp->description }}</td>
                                <td class="py-4 px-6">{{ $rabp->date }}</td>
                                <td class="py-4 px-6">
                                    @if ($rabp->status['name'] == "Working")
                                        <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $rabp->status['name'] }}
                                        </div>
                                    @else
                                        <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $rabp->status['name'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <button title="Detail" wire:click="detailRabp({{ $rabp->id }})">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
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
            @if ($showingRabpModal)
                <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-center">
                            <h1 class="font-medium text-xl">Buat RABP</h1>
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
                            {{-- SECTION RABP --}}
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
                            @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                            <div class="flex items-center gap-8 justify-between p-1">
                                <h1>Nama</h1>
                                <input
                                    placeholder="Nama RABP"
                                    type="text"
                                    wire:model="name"
                                    class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                    required
                                    maxlength="128"
                                />
                            </div>
                            <div class="flex items-center gap-8 justify-between p-1">
                                <h1>Keterangan</h1>
                                <input
                                    type="text"
                                    wire:model="description"
                                    class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                    maxlength="128"
                                />
                            </div>
                            <div class="flex items-center gap-8 justify-between p-1">
                                <h1>Tanggal</h1>
                                <input
                                    type="date"
                                    wire:model.lazy="date"
                                    class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                    disabled
                                />
                            </div>

                            <div class="border black w-full mt-4"></div>

                            <div class="mt-4">
                                <div class="flex justify-end">
                                    <button
                                        wire:click="storeRabp"
                                        class="text-white bg-purple-900 py-2 px-6 rounded-lg"
                                    >
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
        @if ($showingDetailModal)
            <div class="m-6">
                <div class="flex justify-between">
                    <div class="flex items-center gap-4">
                        <a href="#">
                            <div class="font-medium text-lg text-gray-400">Penawaran</div>
                        </a>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        <a href="#">
                            <div class="font-medium text-lg">RABP Penawaran Panel A</div>
                        </a>
                    </div>
                    <button 
                        class="text-lg font-medium hover:text-purple-900" 
                        wire:click="back">Kembali
                    </button>
                </div>
            </div>

            <div class="m-6">
                <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                    <div class="bg-white py-3 px-6">
                        {{-- SECTION RABP --}}
                        <div class="my-2">
                            <p class="font-medium">Kode RABP:</p>
                            <input
                                disabled
                                type="text"
                                wire:model="rabp_code"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                            />
                        </div>
                        <div class="my-2">
                            <p class="font-medium">Kode Penawaran:</p>
                            <input
                                disabled
                                type="text"
                                wire:model="quotations_id"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                            />
                        </div>
                        <div class="my-2">
                            <p class="font-medium">Nama:</p>
                            <input
                                type="text"
                                wire:model="name"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                required
                                maxlength="128"
                            />
                        </div>
                        <div class="my-2">
                            <p class="font-medium">Keterangan:</p>
                            <input
                                type="text"
                                wire:model="description"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                maxlength="128"
                            />
                        </div>
                        <div class="my-2">
                            <p class="font-medium">Tanggal:</p>
                            <input
                                disabled
                                type="date"
                                wire:model="date"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                            />
                        </div>
                        <div class="my-2 flex justify-end">
                            <button
                                wire:click="updateRabp"
                                class="text-white bg-purple-900 py-2 px-6 rounded-lg"
                            >
                                Update
                            </button>
                        </div>
                    
                        <div class="border black w-full mt-4"></div>

                        {{-- SECTION COST --}}
                        <div class="my-2">
                            <p class="font-medium">Tentukan Overhead:</p>
                            <input
                                placeholder="Tentukan Overhead"
                                type="number"
                                wire:model="overhead"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                required
                                min="0"
                            />
                        </div>  
                        <div class="my-2">
                            <p class="font-medium">Tentukan Preliminary:</p>
                            <input
                                placeholder="Tentukan Preliminary"
                                type="number"
                                wire:model="preliminary"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                required
                                min="0"
                            />
                        </div>  
                        <div class="my-2">
                            <p class="font-medium">Tentukan Profit:</p>
                            <input
                                placeholder="Tentukan Profit"
                                type="number"
                                wire:model="profit"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                required
                                max="100"
                                min="0"
                            />
                        </div>  
                        <div class="my-2">
                            <p class="font-medium">PPN:</p>
                            <input
                                disabled
                                type="number"
                                wire:model="ppn"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                            />
                        </div>
                        <div class="my-2 flex justify-end">
                            <button
                                wire:click="updateCost"
                                class="text-white bg-purple-900 py-2 px-6 rounded-lg"
                            >
                                Update
                            </button>
                        </div>

                        <div class="border black w-full my-4"></div>

                        {{-- SECTION GOOD --}}
                        <table class="w-full text-sm text-left text-gray-600 my-2">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Barang</th>
                                    <th scope="col" class="py-3 px-6">Qty</th>
                                    <th scope="col" class="py-3 px-6">Harga</th>
                                    <th scope="col" class="py-3 px-6">Sub Total</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailrabps as $detailrabp)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">{{ $detailrabp->set_good['name'] }}</td>
                                        <td class="py-2 px-6">{{ $detailrabp->qty }}</td>
                                        <td class="py-2 px-6">{{ $detailrabp->price }}</td>
                                        <td class="py-2 px-6 text-blue-600"><button wire:click="detailGood({{ $detailrabp->set_goods_id }})">Detail</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="font-medium">
                                    <td class="py-2 px-2">
                                        <select
                                            wire:model="set_goods_id"
                                            class="w-full border-gray-300/50 rounded-lg text-sm"
                                        >
                                            <option value="">Pilih Barang</option>
                                            @foreach ($setgoods as $setgood)
                                            <option value="{{ $setgood->id }}">{{ $setgood->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2 px-2">
                                        <input
                                            wire:model="qty_bg"
                                            class="w-full border-gray-300/50 rounded-lg text-sm text-center"
                                            type="number"
                                            min="1"
                                        />
                                    </td>
                                    <td class="py-2 px-2">
                                        <input
                                            wire:model="price_bg"
                                            class="w-full border-gray-300/50  rounded-lg text-sm text-center"
                                            type="number"
                                            disabled
                                        />
                                    </td>
                                    <td class="py-2 px-2">
                                        <input
                                            wire:model="total_price_bg"
                                            class="w-full border-gray-300/50  rounded-lg text-sm text-center"
                                            type="number"
                                            disabled
                                        />
                                    </td>
                                    <td class="py-2 px-6">
                                        <button wire:click="storeGood">
                                            <svg class="w-5 h-5 text-purple-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <tr class="font-medium">
                                    <td></td>
                                    <td></td>
                                    <td class="text-right font-bold px-2">Total Profit</td>
                                    <td class="py-2 px-2">
                                        <div class="text-center">Rp. {{ number_format($total_profit) }}</div>
                                    </td>
                                    <td class="py-2 px-6">
                                    </td>
                                </tr>
                                <tr class="font-medium">
                                    <td></td>
                                    <td></td>
                                    <td class="text-right font-bold px-2">Total Harga</td>
                                    <td class="py-2 px-2">
                                        <div class="text-center">Rp. {{ number_format($total_price) }}</div>
                                    </td>
                                    <td class="py-2 px-6">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            {{-- DETAIL GOOD MODAL --}}
            @if ($showingDetailGood)
                <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-center">
                            <h1 class="font-medium text-xl">{{ $good_name }}</h1>
                            <button wire:click="closeDetailGood">
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

                        <div class="overflow-y-auto overflow-x-hidden">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">Material</th>
                                        <th scope="col" class="py-3 px-6">Qty</th>
                                        <th scope="col" class="py-3 px-6">Harga</th>
                                        <th scope="col" class="py-3 px-6">Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($setbillmaterials as $sbm)
                                        <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                            <td class="py-2 px-6">{{ $sbm->material['name'] }}</td>
                                            <td class="py-2 px-6">{{ $sbm->qty }}</td>
                                            <td class="py-2 px-6">Rp. {{ number_format($sbm->price) }}</td>
                                            <td class="py-2 px-6">Rp. {{ number_format($sbm->total_price) }}</td>
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
