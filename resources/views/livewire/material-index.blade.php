<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">

    @section('title', 'Material')

        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Master Data</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">Material</div>
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
                @if (Auth::user()->role == "Direktur")
                    <button wire:click="showMaterialModal" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Buat Material</span>
                        </div>
                    </button> 
                @endif               
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
                            <option value="material_code">KODE MATERIAL</option>
                            <option value="name">NAMA</option>
                            <option value="categories_id">KATEGORI</option>
                            <option value="price">HARGA</option>
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
                            <th scope="col" class="py-3 px-2">#</th>
                            <th scope="col" class="py-3 px-2">Kode Material</th>
                            <th scope="col" class="py-3 px-2">Nama</th>
                            <th scope="col" class="py-3 px-2">Kategori</th>
                            <th scope="col" class="py-3 px-2">Harga</th>
                            <th scope="col" class="py-3 px-2">Harga Lama</th>
                            <th scope="col" class="py-3 px-2">Req Ubah Harga</th>
                            <th scope="col" class="py-3 px-2">Stok</th>
                            <th scope="col" class="py-3 px-2">Min Stok</th>
                            <th scope="col" class="py-3 px-2">Max Stok</th>
                            <th scope="col" class="py-3 px-2">Satuan</th>
                            <th scope="col" class="py-3 px-2">Diperbarui</th>
                            <th scope="col" class="py-3 px-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr class="bg-white border-b hover:bg-gray-100 hover:text-black text-sm">
                                <td class="py-3 px-6">{{ ($materials ->currentpage()-1) * $materials ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-3 px-2 font-bold">{{ $material->material_code }}</td>
                                <td class="py-3 px-2">{{ $material->name }}</td>
                                <td class="py-3 px-2">{{ $material->category['name'] }}</td>
                                <td class="font-medium py-3 px-2">Rp. {{ number_format($material->price) }}</td>
                                <td class="font-medium py-3 px-2">Rp. {{ number_format($material->old_price) }}</td>
                                @if ($material->price == $material->change_price)
                                    <td class="font-medium py-3 px-2">Rp. {{ number_format($material->change_price) }}</td>
                                @else
                                    <td class="font-medium py-3 px-2 text-red-500">Rp. {{ number_format($material->change_price) }}</td>
                                @endif
                                <td class="text-center font-medium py-3 px-2">{{ $material->stock }}</td>
                                <td class="text-center font-medium py-3 px-2">{{ $material->min_stock }}</td>
                                <td class="text-center font-medium py-3 px-2">{{ $material->max_stock }}</td>
                                <td class="py-3 px-2">{{ $material->measurement['name'] }}</td>
                                <td class="py-3 px-2">{{ $material->updated_at->format('d-m-Y') }}</td>
                                <td class="py-3 px-2">
                                    <div class="flex items-center gap-4">
                                        <button class="hover:scale-110 hover:-translate-x-0 hover:duration-150" title="Edit" wire:click="showMaterialEditModal( {{ $material->id }} )">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button class="hover:scale-110 hover:-translate-x-0 hover:duration-150" title="Hapus" wire:click="deleteMaterial({{ $material->id }})">
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        @if (Auth::user()->role == "Direktur" && $material->price_approval == "Need Approve")
                                            <button wire:click="showChangePrice({{ $material->id }})" class="text-white font-medium bg-green-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Approve
                                            </button>
                                        @elseif ($material->price_approval != "Need Approve")
                                            <button wire:click="showChangePrice({{ $material->id }})" class="text-white font-medium bg-yellow-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Ubah Harga
                                            </button>  
                                        @elseif (Auth::user()->role != "Direktur" && $material->price_approval == "Need Approve")
                                            {{-- <button wire:click="showChangePrice({{ $material->id }})" class="text-white bg-yellow-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Ubah Harga
                                            </button>  --}}
                                            <button wire:click="" class="text-white bg-red-500 p-2 rounded-lg font-medium" disabled>
                                                Perlu Approve Direktur
                                            </button> 
                                        @endif
                                        
                                        @if ($material->stock <= $material->min_stock && $material->pr_status == "Menunggu")
                                            <button title="Request PR" wire:click="showRequest({{ $material->id }})" class="text-white font-medium bg-yellow-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Request PR
                                            </button> 
                                        @elseif ($material->stock <= $material->min_stock && $material->pr_status == "PO Berhasil")
                                            <button title="Sedang PO" wire:click="" class="text-white font-medium bg-red-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150" disabled>
                                                Sedang PO
                                            </button> 
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="rounded-lg mt-6">
                {{ $materials->links() }}
            </div>
        </div>

        {{-- MATERIAL MODAL --}}
        @if ($showingMaterialModal)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        @if($isEditMode)
                            <h1 class="font-medium text-xl">Edit Material</h1>
                        @else
                            <h1 class="font-medium text-xl">Tambah Material</h1>
                        @endif
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kode Material</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="text" placeholder="Kode Material"
                                wire:model="material_code"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="text" placeholder="Nama"
                                wire:model="name"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kategori</h1>
                            <select class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                wire:model="categories_id"
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($isEditMode)
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Harga</h1>
                                <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="number" placeholder="Harga" disabled
                                    wire:model="price"
                                />
                            </div>
                        @else
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Harga</h1>
                                <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="number" placeholder="Harga"
                                    wire:model="price"
                                />
                            </div>
                        @endif
                        
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Stok</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="number" placeholder="Stok"
                                wire:model="stock"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Min Stok</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="number" placeholder="Min Stok"
                                wire:model="min_stock"         
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Max Stok</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="number" placeholder="Max Stok"
                                wire:model="max_stock"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Satuan</h1>
                            <select class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                wire:model="measurements_id"
                            >   
                                <option value="">Pilih Satuan</option>
                                @foreach ($measurements as $measurement)
                                    <option value="{{ $measurement->id }}">{{ $measurement->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-end">
                                @if($isEditMode)
                                    <button class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150" wire:click="updateMaterial">
                                        Update
                                    </button>
                                @else
                                    <button class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150" wire:click="storeMaterial">
                                        Submit
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($showingRequest)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Material Request</h1>
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                        <label>Jumlah: </label>
                        <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="number" placeholder="Jumlah"            
                            wire:model="qty_ask"
                        />
                    </div>
                    <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                        <label>Deadline: </label>
                        <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="date"
                            wire:model="deadline"
                        />
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-end">
                            <button wire:click="requestPR" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($showingChangePrice)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Perubahan Harga</h1>
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                        <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="number" placeholder="Harga"            
                            wire:model="change_price"
                        />
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-end gap-4">
                            @if (Auth::user()->role == "Direktur" && $price_approval == "Need Approve")
                                <button wire:click="approve" class="text-white bg-green-500 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                    Approve
                                </button>
                            @else
                            <button wire:click="storeChangePrice" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Submit
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>
