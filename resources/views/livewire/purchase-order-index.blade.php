<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">
    
    @section('title', 'Purchase Order')

    @if ($showingMainPage)
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#"><div class="font-medium text-lg text-gray-400">Pengadaan</div></a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#"><div class="font-medium text-lg">Purchase Order</div></a>
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
                <button wire:click="showPO" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat PO</span>
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
                            <option value="purchase_order_code">KODE PO</option>
                            <option value="name">NAMA</option>
                            <option value="description">KETERANGAN</option>
                            <option value="suppliers_id">SUPPLIER</option>
                            <option value="po_date">TANGGAL PO</option>
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
                            <th scope="col" class="py-3 px-3">Kode PO</th>
                            <th scope="col" class="py-3 px-3">Nama</th>
                            <th scope="col" class="py-3 px-3">Keterangan</th>
                            <th scope="col" class="py-3 px-3">Supplier</th>
                            <th scope="col" class="py-3 px-3">Tanggal</th>
                            <th scope="col" class="py-3 px-3">Status</th>
                            <th scope="col" class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($purchaseorders as $po)
                            <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                <td class="py-1 px-3">{{ ($purchaseorders ->currentpage()-1) * $purchaseorders ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-1 px-3 font-medium">{{ $po->purchase_order_code }}</td>
                                <td class="py-1 px-3">{{ $po->name }}</td>
                                <td class="py-1 px-3">{{ $po->description }}</td>
                                <td class="py-1 px-3">{{ $po->supplier['name'] }}</td>
                                <td class="py-1 px-3">{{ $po->po_date }}</td>
                                <td class="py-1 px-3">
                                    @if ($po->status['name'] == "Working")
                                        <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $po->status['name'] }}
                                        </div>
                                    @elseif ($po->status['name'] == "Complete")
                                        <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $po->status['name'] }}
                                        </div>
                                    @else
                                        <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $po->status['name'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-1 px-3">
                                    <div class="flex items-center gap-4">
                                        <button title="Detail" wire:click="detail({{ $po->id }})" class="text-white bg-blue-500 px-2 py-1 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
                {{ $purchaseorders->links() }}
            </div>
        </div>

        {{-- PURCHASE ORDER MODAL --}}
        @if ($showingPO)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Buat PO</h1>
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kode PO</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="text" disabled
                                wire:model="purchase_order_code"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="text"
                                wire:model="name"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Keterangan</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="text" disabled
                                wire:model="description"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Supplier</h1>
                            <select wire:model="suppliers_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                <option value="">Pilih Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Tanggal</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="date" disabled
                                wire:model.lazy="po_date"
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
                    <a href="#"><div class="font-medium text-lg text-gray-400">Purchase Order</div></a>
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
            {{-- SECTION DATA PURCHASE ORDER --}}
            <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                <div class="bg-white py-3 px-6">

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kode PO:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="text" disabled
                                wire:model="purchase_order_code"
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Nama:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm" type="text"
                                wire:model="name"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Keterangan:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="text" disabled
                                wire:model="description"
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Supplier:</label>
                            <select wire:model="suppliers_id" class="w-full border border-gray-300/50 rounded-lg p-2 shadow-sm text-sm">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Tanggal:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="date" disabled
                                wire:model="po_date"
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Status:</label>
                            @if ($status_id == "Pending")
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-red-200 font-bold"type="text" disabled
                                    wire:model="status_id"
                                />
                            @elseif ($status_id == "Working")
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-yellow-200 font-bold" type="text" disabled
                                    wire:model="status_id"
                                    
                                />
                            @else
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-green-200 font-bold" type="text" disabled 
                                    wire:model="status_id"
                                />
                            @endif
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Diskon (%):</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm" type="number"
                                wire:model="discount"
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Harga:</label>
                            <div class="w-full border border-gray-300/50 rounded-lg shadow-sm bg-blue-200">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 py-10 bg-blue-400 rounded-l-lg"></div>
                                    @if ($this->total_price == NULL)
                                        <div class="text-2xl font-medium">Belum Tersedia</div>
                                    @else
                                        <div class="text-2xl font-medium">Rp. {{ number_format($total_price) }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{--  --}}

            {{-- BUTTON ACTION--}}
            <div class="pt-3 px-6">
                <div class="flex justify-end gap-4">
                    <button wire:click="update" class="py-2 px-6 text-center rounded-lg bg-zinc-800 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        Simpan
                    </button>
                </div>
            </div>
            {{--  --}}

            {{-- SECTION DAFTAR MATERIAL --}}
            <div class="bg-white overflow-x-auto sm:rounded-lg border border-gray-300/50 mt-6">
                <div class="py-3 px-6">
                    <div class="font-medium text-xl mb-3">Daftar Material</div>
                    <table class="w-full text-sm text-left text-black">
                        <thead class="bg-zinc-200">
                            <tr>
                                <th scope="col" class="py-3 px-6">Material</th>
                                <th scope="col" class="py-3 px-6">Qty</th>
                                <th scope="col" class="py-3 px-6">Harga</th>
                                <th scope="col" class="py-3 px-6">Sub Total</th>
                                <th scope="col" class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($detailpos as $dp)
                                <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                    <td class="py-1 px-6">{{ $dp->material['name'] }}</td>
                                    <td class="py-1 px-6">{{ $dp->qty }}</td>
                                    <td class="py-1 px-6">Rp. {{ number_format($dp->price) }}</td>
                                    <td class="py-1 px-6">Rp. {{ number_format($dp->total_price) }}</td>
                                    <td class="py-1 px-6 text-white">
                                        <div class="flex items-center gap-4">
                                            
                                            @if ($dp->status == "Menunggu Pesanan")
                                                <button wire:click="editOrderPO({{ $dp->id }})" class="bg-yellow-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                                </button>
                                                <button wire:click="printGRN({{ $dp->id }})" class="bg-green-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                    Cetak GRN
                                                </button>
                                            @else
                                                <button wire:click="" class="bg-red-500 px-2 py-1 rounded-md" disabled>
                                                    Sudah Cetak
                                                </button>
                                            @endif
                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        @if ($this->status_id != "Working" && $this->status_id != "Complete")
                        <tfoot>
                            <tr class="font-medium">
                                <input wire:model="set_goods_id" type="hidden" />
                                <td class="py-2 px-2">
                                    <select wire:model="materials_id" class="border-gray-300/50 rounded-xl text-sm w-46">
                                        <option value="">Pilih Material</option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2 px-2">
                                    <input
                                        wire:model="qty"
                                        class="border-gray-300/50 rounded-xl text-sm w-20 text-center"
                                        type="number"
                                        min="1"
                                    />
                                </td>
                                <td class="py-2 px-2">
                                    <input
                                        wire:model="price"
                                        class="border-gray-300/50  rounded-xl text-sm w-36 text-center"
                                        type="number"
                                        min="0"
                                    />
                                </td>
                                <td class="py-2 px-2">
                                    <input
                                        wire:model="total_price_m"
                                        class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center"
                                        type="number"
                                        disabled
                                    />
                                </td>
                                <td class="py-2 px-6">
                                    <button class="bg-zinc-800 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150" wire:click="storeOrderPO">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>

                    {{-- SECTION HARGA PRODUKSI --}}
                        <div class="px-6 mt-3">
                            <div class="flex gap-3 items-center justify-between font-medium">
                                <h1>Total Harga:</h1>
                                <div class="text-xl font-bold">Rp. {{ number_format($this->real_price) }}</div>
                            </div>
                            <div class="flex gap-3 items-center justify-between font-medium">
                                <h1>Diskon {{ $discount }}% :
                                </h1>
                                <div class="text-xl font-bold">Rp. {{ number_format($this->total_discount) }}</div>
                            </div>
                            <div class="flex gap-3 items-center justify-between font-medium">
                                <h1>Total PPN 11% :</h1>
                                <div class="text-xl font-bold">Rp. {{ number_format($this->total_ppn) }}</div>
                            </div>
                            <div class="flex gap-3 items-center justify-between font-medium">
                                <h1>Total Bayar:</h1>
                                <div class="text-xl font-bold">Rp. {{ number_format($this->total_price) }}</div>
                            </div>
                        </div>

                </div>
            </div>
            {{--  --}}
            <div class="py-3 px-6">
                <div class="flex justify-between">
                    <div class="flex gap-4">
                        @if ($this->status_id == "Pending")
                            <button wire:click="" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                                Download Purchase Order
                            </button>
                        @else
                            <button wire:click="viewPdf" class="py-2 px-6 my-2 text-center rounded-lg bg-yellow-500 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Download Purchase Order
                            </button>
                        @endif
                        
                    </div>
                    
                    <div class="flex gap-4">
                        @if ($this->status_id == "Pending")
                            <button wire:click="approvePO" class="py-2 px-6 my-2 text-center rounded-lg bg-green-500 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Approve 
                            </button>
                        @elseif ($this->status_id == "Working")
                            <button wire:click="completePO" class="py-2 px-6 my-2 text-center rounded-lg bg-green-500 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Selesai  
                            </button>
                        @elseif ($this->status_id == "Complete")
                            <button wire:click="" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                                PO Selesai  
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        

        {{-- SECTION EDIT DETAIL PO --}}
        @if ($showingEditPO)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Edit</h1>
                        <button wire:click="closeEditPO">
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
                                    <th scope="col" class="py-3 px-6">Harga</th>
                                    <th scope="col" class="py-3 px-6">Sub Total</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($editdetailpos as $edp)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">
                                            <select wire:model="materials_id_e" class="border-gray-300/50 rounded-xl text-sm w-46">
                                                <option value="">Pilih Material</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="py-2 px-6">
                                            <input wire:model="qty_e" type="number" class="w-24 border-gray-300/50  rounded-lg text-sm text-center"/>
                                        </td>
                                        <td class="py-2 px-6">
                                            <input wire:model="price_e" type="number" class="w-24 border-gray-300/50  rounded-lg text-sm text-center"/>
                                        </td>
                                        <td class="py-2 px-6">
                                            <input wire:model="total_price_e" type="number" class="w-24 border-gray-300/50  rounded-lg text-sm text-center bg-gray-100" disabled/>
                                        </td>
                                        <td class="py-2 px-6">
                                            <button wire:click="storeEditPO" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
