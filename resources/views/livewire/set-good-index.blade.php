<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">

    @section('title', 'Set Barang')

        @if ($showingMainPage)
            
            {{-- PAGE TITLE --}}
            <div class="mx-6 mt-20">
                <div class="flex justify-between">
                    <div class="flex items-center gap-4">
                        <a href="#"><div class="font-medium text-lg text-gray-400">Sales</div></a>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        <a href="#"><div class="font-medium text-lg">Set Barang</div></a>
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
                    <button wire:click="showSetGood" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Buat Set Barang</span>
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
                                <option value="set_goods_code">KODE SET BARANG</option>
                                <option value="name">NAMA</option>
                                <option value="qty">QTY</option>
                                <option value="price">HARGA</option>
                                <option value="categories_id">KATEGORI</option>
                                <option value="measurements_id">SATUAN</option>
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
                                <th scope="col" class="py-3 px-3">Kode Set Barang</th>
                                <th scope="col" class="py-3 px-3">Nama</th>
                                <th scope="col" class="py-3 px-3">Kategori</th>
                                <th scope="col" class="py-3 px-3">Qty</th>
                                <th scope="col" class="py-3 px-3">Satuan</th>
                                <th scope="col" class="py-3 px-3">Harga</th>
                                <th scope="col" class="py-3 px-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($set_goods as $set_good)
                                <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                    <td class="py-1 px-3">{{ ($set_goods ->currentpage()-1) * $set_goods ->perpage() + $loop->index + 1 }}</td>
                                    <td class="py-1 px-3 font-medium">{{ $set_good->set_goods_code }}</td>
                                    <td class="py-1 px-3">{{ $set_good->name }}</td>
                                    <td class="py-1 px-3">{{ $set_good->category['name'] }}</td>
                                    <td class="py-1 px-3">{{ $set_good->qty }}</td>
                                    <td class="py-1 px-3">{{ $set_good->measurement['name'] }}</td>
                                    @if ($set_good->price == 0)                                   
                                        <td class="py-2 px-3 text-red-600">Belum Tersedia</td>
                                    @else
                                        <td class="py-2 px-3">Rp. {{ number_format($set_good->price) }}</td>
                                    @endif
                                    <td class="py-1 px-3">
                                        <div class="flex items-center gap-4">
                                            <button wire:click="showDetail({{ $set_good->id }})" class="bg-blue-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
                    {{ $set_goods->links() }}
                </div>
            </div>

            {{-- SET GOOD MODAL --}}
            @if ($showingSetGood)
                <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                    <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                        <div class="flex justify-between items-center">
                            <h1 class="font-medium text-xl">Buat Set Barang</h1>
                            <button wire:click="closeModal">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Kode Penawaran</h1>
                                <select wire:model="quotations_id" class="w-96 border border-gray-300/50 rounded-lg shadow-sm text-sm">
                                    <option value="">Pilih Penawaran</option>
                                    @foreach ($quotations as $quotation)
                                        <option value="{{ $quotation->id }}">{{ $quotation->quotation_code }} - {{ $quotation->customer['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Kode Set Barang</h1>
                                <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                    disabled
                                    type="text"
                                    wire:model="set_goods_code"
                                />
                            </div>

                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Nama</h1>
                                <select class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                    wire:model="name"
                                >
                                    <option value="">Pilih Barang</option>
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->name }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Kategori</h1>
                                <select class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                    wire:model="categories_id"
                                    disabled
                                >
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Satuan</h1>
                                <select class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                    wire:model="measurements_id"
                                    disabled
                                >
                                    <option value="">Pilih Satuan</option>
                                    @foreach ($measurements as $measurement)
                                        <option value="{{ $measurement->id }}">{{ $measurement->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4">
                                <div class="flex justify-end">
                                    <button wire:click="storeSetGood" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
                            <div class="font-medium text-lg text-gray-400">Sales</div>
                        </a>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        <a href="#">
                            <div class="font-medium text-lg">Set {{ $name }}</div>
                        </a>
                    </div>
                    <button 
                        class="text-lg font-medium" 
                        wire:click="back">Kembali
                    </button>
                </div>
            </div>

            <div class="m-6 pb-6">
                {{-- SECTION DATA SET BARANG --}}
                <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">

                    <div class="bg-white py-3 px-6">

                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Kode Set Barang:</label>
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                    type="text"
                                    wire:model="set_goods_code"
                                    disabled
                                />
                            </div>
                            <div class="md:w-1/2">
                                <label>Nama:</label>
                                <select
                                    class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                    wire:model="name"
                                >
                                    <option value="">Pilih Barang</option>
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->name }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Kategori:</label>
                                <select
                                    class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                    wire:model="categories_id"
                                    disabled
                                >
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:w-1/2">
                                <label>Qty:</label>
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                    type="number"
                                    wire:model="qty"
                                />
                            </div>
                        </div>

                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Satuan:</label>
                                <select
                                    class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                    wire:model="categories_id"
                                    disabled
                                >
                                    <option value="">Pilih Satuan</option>
                                    @foreach ($measurements as $measurement)
                                        <option value="{{ $measurement->id }}">{{ $measurement->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:w-1/2">
                                <label>Harga:</label>
                                <div class="w-full border border-gray-300/50 rounded-lg shadow-sm bg-blue-200">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 py-10 bg-blue-400 rounded-l-lg"></div>
                                        <div class="text-2xl font-medium">Rp. {{ number_format($price) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

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
                                    <th scope="col" class="py-3 px-6">Total Harga</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($set_bill_materials as $sbm)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-1 px-6">{{ $sbm->material['name'] }}</td>
                                        <td class="py-1 px-6">{{ $sbm->qty }}</td>
                                        <td class="py-1 px-6">Rp. {{ number_format($sbm->price) }}</td>
                                        <td class="py-1 px-6">Rp. {{ number_format($sbm->total_price) }}</td>
                                        <td class="py-1 px-6">
                                            <button wire:click="editSetBill({{ $sbm->id }})" class="bg-yellow-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                            </button>
                                            <button disabled class="bg-red-500 px-2 py-1 rounded-md">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class="font-medium">
                                    <input wire:model="set_goods_id" type="hidden" />
                                    <td class="py-2 px-2">
                                        <select wire:model="materials_id" class="border-gray-300/50 rounded-xl text-sm w-46">
                                            <option value="">Pilih Material</option>
                                            @foreach ($all_materials as $all_material)
                                                <option value="{{ $all_material->id }}">{{ $all_material->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2 px-2">
                                        <input
                                            wire:model="qty_bm"
                                            class="border-gray-300/50 rounded-xl text-sm w-20 text-center"
                                            type="number"
                                            min="1"
                                        />
                                    </td>
                                    <td class="py-2 px-2">
                                        <input
                                            wire:model="price_bm"
                                            class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center"
                                            type="number"
                                            disabled
                                        />
                                    </td>
                                    <td class="py-2 px-2">
                                        <input
                                            wire:model="total_price_bm"
                                            class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center"
                                            type="number"
                                            disabled
                                        />
                                    </td>
                                    <td class="py-2 px-6">
                                        <button class="bg-zinc-800 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150" wire:click="storeSetBill">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                {{-- BUTTON ACTION--}}
                <div class="py-3 px-6">
                    <div class="flex justify-end gap-4">
                        <button wire:click="updateSetGood" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

            

            {{-- EDIT MODAL --}}
            @if ($showingEditMaterial)
                <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                    <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                        <div class="flex justify-between items-center">
                            <h1 class="font-medium text-xl">Edit Material</h1>
                            <button wire:click="closeEdit">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Material</h1>
                            <select wire:model="m_id"  class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                <option value="">Pilih Material</option>
                                @foreach ($all_materials as $all_material)
                                    <option value="{{ $all_material->id }}">{{ $all_material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Qty</h1>
                            <input wire:model="m_qty" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="number"/>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Harga</h1>
                            <input wire:model="m_price" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="number" disabled/>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Harga Total</h1>
                            <input wire:model="m_total_price" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="number" disabled/>
                        </div>
                        <div class="mt-4">
                        <div class="flex justify-end">
                            <button wire:click="updateSetBill" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            
        @endif

</div>