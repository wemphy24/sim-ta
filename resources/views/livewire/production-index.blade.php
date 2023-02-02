<div class="main-content bg-gray-50 flex-1 md:ml-64 h-screen">

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
                <div class="flex items-center gap-4">
                    <button class="py-2 px-4 text-center rounded-lg border hover:bg-purple-900 hover:text-white">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                            <span>Download CSV</span>
                        </div> 
                    </button>
                    <button wire:click="showMaterialModal" class="py-2 px-4 text-center text-white rounded-lg border bg-purple-900">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Buat Material</span>
                        </div>
                </button> 
                </div>        
            </div>
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-white text-black">
                    <tr>
                        <th scope="col" class="py-3 px-6">#</th>
                        <th scope="col" class="py-3 px-6">Kode Produksi</th>
                        <th scope="col" class="py-3 px-6">Kode RABP</th>
                        <th scope="col" class="py-3 px-6">Nama</th>
                        <th scope="col" class="py-3 px-6">Keterangan</th>
                        <th scope="col" class="py-3 px-6">Deadline</th>
                        <th scope="col" class="py-3 px-6">Status</th>
                        <th scope="col" class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($materials as $material)
                        <tr class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium">
                            <td class="py-4 px-6">{{ ($materials ->currentpage()-1) * $materials ->perpage() + $loop->index + 1 }}</td>
                            <td class="py-4 px-6">{{ $material->material_code }}</td>
                            <td class="py-4 px-6">{{ $material->name }}</td>
                            <td class="py-4 px-6">{{ $material->category['name'] }}</td>
                            <td class="py-4 px-6">Rp. {{ number_format($material->price) }}</td>
                            <td class="py-4 px-6">{{ $material->stock }}</td>
                            <td class="py-4 px-6">{{ $material->min_stock }}</td>
                            <td class="py-4 px-6">{{ $material->max_stock }}</td>
                            <td class="py-4 px-6">{{ $material->measurement['name'] }}</td>
                            <td class="py-4 px-6">{{ $material->updated_at->format('m/d/Y') }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <button title="Edit" wire:click="showMaterialEditModal( {{ $material->id }} )">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button title="Hapus" wire:click="deleteMaterial({{ $material->id }})">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
        {{-- <div class="rounded-lg mt-6">
            {{ $materials->links() }}
        </div> --}}
    </div>
    
</div>
