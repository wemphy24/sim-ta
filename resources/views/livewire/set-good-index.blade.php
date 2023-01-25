<div class="main-content bg-gray-100 flex-1">

    @section('title', 'Set Barang')

        {{-- PAGE TITLE --}}
        <div class="m-6">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Penawaran</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">Set Barang</div>
                    </a>
                </div>
            </div>
        </div>
        
        {{-- TABLE DATA --}}
        <div class="m-6">
            <div class="overflow-x-auto shadow-sm sm:rounded-lg border border-gray-300/50">
                <div class="bg-white border-b-2 py-3 px-6 flex justify-end gap-4">
                    <button class="py-2 px-4 text-center rounded-lg border hover:bg-purple-900 hover:text-white">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                            <span>Download CSV</span>
                        </div> 
                    </button>
                    <button wire:click="showSetGood" class="py-2 px-4 text-center text-white rounded-lg border bg-purple-900">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Buat Set Barang</span>
                        </div>
                    </button>               
                </div>
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-white text-black">
                        <tr>
                            <th scope="col" class="py-3 px-6">#</th>
                            <th scope="col" class="py-3 px-6">Kode Set Barang</th>
                            <th scope="col" class="py-3 px-6">Nama</th>
                            <th scope="col" class="py-3 px-6">Kategori</th>
                            <th scope="col" class="py-3 px-6">Qty</th>
                            <th scope="col" class="py-3 px-6">Satuan</th>
                            <th scope="col" class="py-3 px-6">Harga</th>
                            <th scope="col" class="py-3 px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($set_goods as $set_good)
                            <tr class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium">
                                <td class="py-4 px-6">{{ ($set_goods ->currentpage()-1) * $set_goods ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-4 px-6 font-bold">{{ $set_good->set_goods_code }}</td>
                                <td class="py-4 px-6">{{ $set_good->name }}</td>
                                <td class="py-4 px-6">{{ $set_good->category['name'] }}</td>
                                <td class="py-4 px-6">{{ $set_good->qty }}</td>
                                <td class="py-4 px-6">{{ $set_good->measurement['name'] }}</td>
                                @if ($set_good->price == 0)                                   
                                    <td class="py-4 px-6 text-red-600">Belum Tersedia</td>
                                @else
                                    <td class="py-4 px-6">Rp. {{ number_format($set_good->price) }}</td>
                                @endif
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <button title="Tambah" wire:click="showSetBill( {{ $set_good->id }} )">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                            </svg>
                                        </button>
                                        <button title="Edit" wire:click="showEditGood( {{ $set_good->id }} )">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                            </svg>
                                        </button>
                                        <button title="Detail" wire:click="showDetail({{ $set_good->id }})">
                                            <svg class="w-5 h-5" fill="none"  stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                            </svg>
                                        </button>
                                        {{-- <button title="Hapus" wire:click="deleteCustomer({{ $set_good->id }})">
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>  --}}
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
        @if ($showingSetGoodModal)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center">
                        @if($isEditMode === true)
                            <h1 class="font-medium text-xl">Edit Set Barang</h1>
                        @else
                            <h1 class="font-medium text-xl">Tambah Set Barang</h1>
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
                    <div class="mt-4">
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Kode Set Barang</h1>
                            <input
                                disabled
                                type="text"
                                wire:model="set_goods_code"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                            />
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Nama</h1>
                            <select
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                wire:model="name"
                            >
                                <option value="">Pilih Barang</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->name }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Kategori</h1>
                            <select
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                wire:model="categories_id"
                                disabled
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Qty</h1>
                            <input
                                type="number"
                                wire:model="qty"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                min=1
                            />
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Satuan</h1>
                            <select
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                wire:model="measurements_id"
                                disabled
                            >
                                <option value="">Pilih Satuan</option>
                                @foreach ($measurements as $measurement)
                                    <option value="{{ $measurement->id }}">{{ $measurement->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Harga</h1>
                            <input
                                disabled
                                type="number"
                                wire:model="price"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                            />
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-end">
                                @if($isEditMode == true)
                                    <button
                                        wire:click="updateSetGood"
                                        class="text-white bg-purple-900 py-2 px-6 rounded-lg"
                                    >
                                        Update
                                    </button>
                                @else
                                    <button
                                        wire:click="storeSetGood"
                                        class="text-white bg-purple-900 py-2 px-6 rounded-lg"
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

        {{-- BILL MATERIAL MODAL --}}
        @if ($showingBillMaterialModal)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Set Bill Material</h1>
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

                    <div class="text-center my-4">
                        <h1 class="font-medium">{{ $good_name }}</h1>
                    </div>

                    <div class="h-[400px] overflow-y-auto overflow-x-hidden">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Material</th>
                                    <th scope="col" class="py-3 px-6">Qty</th>
                                    <th scope="col" class="py-3 px-6">Harga</th>
                                    <th scope="col" class="py-3 px-6">Total Harga</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($set_bill_materials as $bms)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">{{ $bms->material['name'] }}</td>
                                        <td class="py-2 px-6">{{ $bms->qty }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($bms->price) }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($bms->total_price) }}</td>
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
                                    <input wire:model="set_goods_id" type="hidden" />
                                    <td class="py-2 px-2">
                                        <select
                                            wire:model="materials_id"
                                            class="border-gray-300/50 rounded-xl text-sm w-46"
                                        >
                                            <option value="">Pilih Material</option>
                                            @foreach ($material_bms as $material_bm)
                                            <option value="{{ $material_bm->id }}">{{ $material_bm->name }}</option>
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
                                        <button wire:click="storeSetBill">
                                            <svg class="w-5 h-5 text-purple-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="border black w-full mt-4"></div>

                </div>
            </div>
        @endif

        {{-- DETAIL MODAL --}}
        @if ($showingDetailModal)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center w-[1000px]">
                        <h1 class="font-medium text-xl">Detail {{ $good_name }}</h1>
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
                        <div class="mt-1">
                            <h1 class="font-medium">Kode Set Barang :</h1>
                            <input
                                disabled
                                type="text"
                                wire:model="set_goods_code"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-50"
                            />
                        </div>
                        <div class="mt-1">
                            <h1 class="font-medium">Kategori :</h1>
                            <input
                                disabled
                                type="text"
                                wire:model="categories_id"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-50"
                            />
                        </div>
                        <div class="mt-1">
                            <h1 class="font-medium">Qty :</h1>
                            <input
                                disabled
                                type="text"
                                wire:model="qty"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-50"
                            />
                        </div>
                        <div class="mt-1">
                            <h1 class="font-medium">Satuan :</h1>
                            <input
                                disabled
                                type="text"
                                wire:model="measurements_id"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-50"
                            />
                        </div>
                        <div class="mt-1">
                            <h1 class="font-medium">Harga :</h1>
                            <input
                                disabled
                                type="text"
                                wire:model="price"
                                class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-50"
                            />
                        </div>
                    </div>

                    <div class="border black w-full mt-4"></div>

                    <div class="mt-4">
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
                                @foreach ($set_bill_materials as $bms)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">{{ $bms->material['name'] }}</td>
                                        <td class="py-2 px-6">{{ $bms->qty }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($bms->price) }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($bms->total_price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

</div>