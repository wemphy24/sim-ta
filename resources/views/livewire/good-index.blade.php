<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">

    @section('title', 'Barang')

    @if ($showingMainPage)
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Master Data</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">Barang</div>
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
                <button wire:click="showGoodModal" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat Barang</span>
                    </div>
                </button> 
            </div> 

            <div class="overflow-x-auto shadow-sm sm:rounded-lg border border-gray-300/50">
                <div class="bg-white border-b-2 py-3 px-6 flex justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <select wire:model="showPage" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="5">5</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <input wire:model.debounce.500ms="search" class="border-gray-300/50 rounded-lg p-2 text-sm" type="text" placeholder="Search">
                        <select wire:model="searchBy" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="good_code">KODE BARANG</option>
                            <option value="name">NAMA</option>
                            <option value="categories_id">KATEGORI</option>
                            <option value="stock">STOK</option>
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
                            <th scope="col" class="py-3 px-6">#</th>
                            <th scope="col" class="py-3 px-6">Kode Barang</th>
                            <th scope="col" class="py-3 px-6">Nama</th>
                            <th scope="col" class="py-3 px-6">Kategori</th>
                            <th scope="col" class="py-3 px-6">Harga Pokok</th>
                            <th scope="col" class="py-3 px-6">Harga Jual</th>
                            <th scope="col" class="py-3 px-6">Stok</th>
                            <th scope="col" class="py-3 px-6">Satuan</th>
                            <th scope="col" class="py-3 px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($goods as $g)
                            <tr class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium">
                                <td class="py-4 px-6">{{ ($goods ->currentpage()-1) * $goods ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-4 px-6">{{ $g->good_code }}</td>
                                <td class="py-4 px-6">{{ $g->name }}</td>
                                <td class="py-4 px-6">{{ $g->category['name'] }}</td>
                                <td class="py-4 px-6">Rp. {{ number_format($g->price) }}</td>
                                <td class="py-4 px-6">Rp. {{ number_format($g->sell_price) }}</td>
                                <td class="py-4 px-6">{{ $g->stock }}</td>
                                <td class="py-4 px-6">{{ $g->measurement['name'] }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-4">
                                            <button wire:click="detail({{ $g->id }})" class="bg-blue-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="rounded-lg mt-6">
                {{ $goods->links() }}
            </div>
        </div>

        {{-- BARANG MODAL --}}
        @if ($showingGoodModal)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Tambah Barang</h1>
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kode Barang</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="text" disabled
                                wire:model="good_code" 
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="text" placeholder="Nama"
                                wire:model.debounce.500ms="name"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kategori</h1>
                            <select class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" wire:model="categories_id" disabled>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Harga</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="number" disabled
                                wire:model="price"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Stok</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="number" disabled
                                wire:model="stock"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Satuan</h1>
                            <select class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" wire:model="measurements_id" disabled>   
                                <option value="">Pilih Satuan</option>
                                @foreach ($measurements as $measurement)
                                    <option value="{{ $measurement->id }}">{{ $measurement->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Customer</h1>
                            <select class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" wire:model="customers_id">   
                                <option value="">Pilih Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-end">
                                <button class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150" wire:click="store">
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
                            <div class="font-medium text-lg text-gray-400">Barang</div>
                        </a>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        <a href="#">
                            <div class="font-medium text-lg">{{ $name }}</div>
                        </a>
                    </div>
                    <button wire:click="back" class="text-lg font-medium hover:text-purple-900">
                        Kembali
                    </button>
                </div>
            </div>

            <div class="m-6 pb-6">

                {{-- SECTION DATA BARANG --}}
                <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                    <div class="bg-white py-3 px-6">
                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Kode Barang:</label>
                                <input wire:model="good_code" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled/>
                            </div>
                            <div class="md:w-1/2">
                                <label>Nama:</label>
                                <input wire:model.debounce.500ms="name" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"/>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Stok:</label>
                                <input wire:model="stock" type="number" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled/>
                            </div>
                            <div class="md:w-1/2">
                                <label class="font-medium">Kategori:</label>
                                <select wire:model="categories_id" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Harga Pokok:</label>
                                <input wire:model="price" type="number" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled/>
                            </div>
                            <div class="md:w-1/2">
                                <label>Harga Jual:</label>
                                <input wire:model="sell_price" type="number" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled/>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Satuan:</label>
                                <select wire:model="measurements_id" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled>
                                    <option value="">Pilih Satuan</option>
                                    @foreach ($measurements as $m)
                                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:w-1/2">
                                <label>Disusun:</label>
                                <input wire:model="users_id" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="text" disabled maxlength="128"/>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION COST --}}
                <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50 mt-6">
                    <div class="bg-white py-3 px-6">
                        <div class="font-medium text-xl mb-3">Total Biaya</div>

                        {{-- DISPLAY COST --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Overhead:</label>
                                <div class="w-full border border-gray-300/50 rounded-lg shadow-sm bg-blue-200">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 py-10 bg-blue-400 rounded-l-lg"></div>
                                        <div class="text-2xl font-medium">Rp. {{ number_format($overhead) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-1/2">
                                <label>Preliminary:</label>
                                <div class="w-full border border-gray-300/50 rounded-lg shadow-sm bg-blue-200">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 py-10 bg-blue-400 rounded-l-lg"></div>
                                        <div class="text-2xl font-medium">Rp. {{ number_format($preliminary) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-1/2">
                                <label>Profit:</label>
                                <div class="w-full border border-gray-300/50 rounded-lg shadow-sm bg-blue-200">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 py-10 bg-blue-400 rounded-l-lg"></div>
                                        <div class="text-2xl font-medium">{{ number_format($profit) }} %</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM COST --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Overhead:</label>
                                <input wire:model="overhead" type="number" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm" min="0" required/>
                            </div>
                            <div class="md:w-1/2">
                                <label>Preliminary:</label>
                                <input wire:model="preliminary" type="number" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm" min="0" required/>
                            </div>
                            <div class="md:w-1/2">
                                <label>Profit:</label>
                                <input wire:model="profit" type="number" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm" min="0" required/>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BUTTON ACTION --}}
                <div class="pt-3 px-6">
                    <div class="flex justify-end">
                        <button wire:click="update" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                            Simpan
                        </button>
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
                                    <th scope="col" class="py-3 px-6">Sub Total</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($billmaterials as $bm)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">{{ $bm->material['name'] }}</td>
                                        <td class="py-2 px-6">{{ $bm->qty }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($bm->price) }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($bm->total_price) }}</td>
                                        <td class="py-2 px-6 text-blue-600">
                                            <button wire:click="edit({{ $bm->id }})" class="bg-yellow-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
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
                                            @foreach ($materials as $m)
                                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2 px-2">
                                        <input class="border-gray-300/50 rounded-xl text-sm w-20 text-center" type="number" min="1"
                                            wire:model="qty_bm"
                                        />
                                    </td>
                                    <td class="py-2 px-2">
                                        <input class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center" type="number" disabled
                                            wire:model="price_bm"    
                                        />
                                    </td>
                                    <td class="py-2 px-2">
                                        <input class="border-gray-300/50  rounded-xl bg-gray-100 text-sm w-36 text-center" type="number" disabled
                                            wire:model="total_price_bm"
                                        />
                                    </td>
                                    <td class="py-2 px-6">
                                        <button class="bg-zinc-800 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150" wire:click="storeBillMaterial">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif
</div>
