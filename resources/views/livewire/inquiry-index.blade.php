<div class="main-content bg-gray-100 flex-1">
    
    @section('title', 'Inquiry')

    {{-- PAGE TITLE --}}
    <div class="m-6">
        <div class="flex justify-between">
            <div class="flex items-center gap-4">
                <a href="#">
                    <div class="font-medium text-lg text-gray-400">Penawaran</div>
                </a>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                <a href="#">
                    <div class="font-medium text-lg">List Inquiry</div>
                </a>
            </div>
        </div>
    </div>

    {{-- TABLE DATA --}}
    <div class="m-6">
        <div class="overflow-x-auto shadow-sm sm:rounded-lg border border-gray-300/50">
            <div class="bg-white border-b-2 py-3 px-6 flex justify-between">
                <div class="flex items-center gap-4">
                    <select wire:model="showPage" class="border-gray-300/50 rounded-lg shadow-sm text-sm">
                        <option value="5">5</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                    <input wire:model="search" class="w-96 border-gray-300/50 rounded-lg p-2 shadow-sm text-sm" type="text" placeholder="Search">
                </div>
                <div class="flex items-center gap-4">
                    <button class="py-2 px-4 text-center rounded-lg border hover:bg-purple-900 hover:text-white">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                            <span>Download CSV</span>
                        </div> 
                    </button>
                    <button wire:click="showInquiryModal" class="py-2 px-4 text-center text-white rounded-lg border bg-purple-900">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Buat Inquiry</span>
                        </div>
                    </button>  
                </div>     
            </div>
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-white text-black">
                    <tr>
                        <th scope="col" class="py-3 px-6">#</th>
                        <th scope="col" class="py-3 px-6">Nama Inquiry</th>
                        <th scope="col" class="py-3 px-6">File Inquiry</th>
                        <th scope="col" class="py-3 px-6">File PO</th>
                        <th scope="col" class="py-3 px-6">Tanggal</th>
                        <th scope="col" class="py-3 px-6">Customer</th>
                        <th scope="col" class="py-3 px-6">Status</th>
                        <th scope="col" class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($inquiries as $inquiry)
                    <tr class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium">
                        <td class="py-4 px-6">{{ $count+=1 }}</td>
                        <td class="py-4 px-6">{{ $inquiry->name }}</td>
                        <td class="py-4 px-6"><a class="text-blue-900" href="{{ url('storage/inquiry/'.$inquiry->inquiry_file) }}">{{ $inquiry->inquiry_file }}</a></td>
                        @if ($inquiry->purchase_order_file == NULL)
                            <td class="py-4 px-6 text-red-600">Belum Tersedia</td>  
                        @else
                            <td class="py-4 px-6">
                                <a class="text-blue-600" href="{{ url('storage/purchaseorder/'.$inquiry->purchase_order_file) }}">{{ $inquiry->purchase_order_file }}</a>
                            </td>  
                        @endif
                        <td class="py-4 px-6">{{ $inquiry->date }}</td>
                        <td class="py-4 px-6">{{ $inquiry->customer['name'] }}</td>
                        <td class="py-4 px-6">
                            <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                {{ $inquiry->status['name'] }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <button title="Edit" wire:click="showInquiryEditModal( {{ $inquiry->id }} )">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button wire:click="detailInquiry({{ $inquiry->id }})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                </button>
                                <button title="Hapus" wire:click="deleteInquiry({{ $inquiry->id }})">
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
            {{ $inquiries->links() }}
        </div>
    </div>

    {{-- INQUIRY MODAL --}}
    @if ($showingInquiryModal === true)
        <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="flex justify-between items-center">
                    @if($isEditMode === true)
                        <h1 class="font-medium text-xl">Edit Inquiry</h1>
                    @else
                        <h1 class="font-medium text-xl">Tambah Inquiry</h1>
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
                    @error('name') <p class="text-sm text-red-500 error">{{ $message }}</p> @enderror
                    <div class="flex items-center gap-8 justify-between p-1">
                        <h1>Nama Inquiry</h1>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            required
                        />
                    </div>
                    @if ($isEditMode)
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>File Inquiry</h1>
                            <label class="text-sm" for="inquiry_file">
                                <input wire:model="inquiry_file" class="w-96 text-sm rounded-lg border border-gray-300/50" type="file">
                            </label>
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Inquiry Lama</h1>
                            <a class="w-96 text-blue-900" href="{{ url('storage/inquiry/'.$inquiry->inquiry_file) }}">{{ $inquiry->inquiry_file }}</a>
                        </div>
                    @else
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>File Inquiry</h1>
                            <label class="text-sm" for="inquiry_file">
                                <input wire:model="inquiry_file" class="w-96 text-sm rounded-lg border border-gray-300/50" type="file" required>
                            </label>
                        </div>
                    @endif
                    @if ($isEditMode)
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>File PO</h1>
                            <label class="text-sm" for="purchase_order_file">
                                <input wire:model="purchase_order_file" class="w-96 text-sm rounded-lg border border-gray-300/50" type="file">
                            </label>
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>PO Lama</h1>
                            @if ($inquiry->purchase_order_file == NULL)
                                <p class="w-96">Belum Tersedia</p>
                            @else
                                <a class="w-96 text-blue-900" href="{{ url('storage/purchaseorder/'.$inquiry->purchase_order_file) }}">{{ $inquiry->purchase_order_file }}</a>
                            @endif
                        </div>
                    @endif
                    <div class="flex items-center gap-8 justify-between p-1">
                        <h1>Keterangan</h1>
                        <input
                            type="description"
                            wire:model="description"
                            class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                        />
                    </div>
                    <div class="flex items-center gap-8 justify-between p-1">
                        <h1>Tanggal</h1>
                        <input
                            type="date"
                            wire:model="date"
                            class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            required
                        />
                    </div>
                    <div class="flex items-center gap-8 justify-between p-1">
                        <h1>Customer</h1>
                        <select
                            class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            wire:model="customers_id"
                        >
                            <option value="">Pilih Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-end">
                            @if($isEditMode == true)
                                <button
                                    wire:click="updateInquiry"
                                    class="text-white bg-purple-900 py-2 px-6 rounded-lg"
                                >
                                    Update
                                </button>
                            @else
                                <button
                                    wire:click="storeInquiry"
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

    {{-- DETAIL INQUIRY --}}
    @if ($showingDetailInquiryModal == true)
        <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="flex justify-between">
                    <h1 class="font-medium text-xl">Detail Inquiry</h1>
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
                <div class="mt-4 flex gap-6 justify-between">
                    <h1 class="font-medium">Nama Inquiry</h1>
                    <div class="w-[400px]">
                        <p>: {{ $name }}</p>
                    </div>
                </div>
                <div class="mt-1 flex gap-6 justify-between">
                    <h1 class="font-medium">File Inquiry</h1>
                    <div class="w-[400px]">
                        <div class="flex gap-2 justify-start">
                            <div>:</div>
                            <div class="flex border border-gray-300/50 rounded-lg shadow-sm text-center items-end">
                                <a href="{{ url('storage/inquiry/'.$inquiry_file) }}" class="text-blue-600 hover:bg-gray-100">
                                    <div class="w-24 p-2">
                                        <img src="{{ asset('/images/pdf_icon.png') }}">
                                        <p class="truncate">{{ $inquiry_file }}</p>
                                    </div>
                                </a>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="mt-1 flex gap-6 justify-between">
                    <h1 class="font-medium">File PO</h1>
                    @if ($purchase_order_file == NULL)
                        <div class="w-[400px]">
                            <p>: Belum Tersedia</p>
                        </div>
                    @else
                        <div class="w-[400px]">
                            <div class="flex gap-2 justify-start">
                                <div>:</div>
                                <div class="flex border border-gray-300/50 rounded-lg shadow-sm text-center items-end">
                                    <a href="{{ url('storage/inquiry/'.$inquiry_file) }}" class="text-blue-900 hover:bg-gray-100">
                                        <div class="w-24 p-2">
                                            <img src="{{ asset('/images/pdf_icon.png') }}">
                                            <p class="truncate">{{ $inquiry_file }}</p>
                                        </div>
                                    </a>
                                </div> 
                            </div>
                        </div> 
                    @endif
                </div>
                <div class="mt-1 flex gap-6 justify-between">
                    <h1 class="font-medium">Keterangan</h1>
                    <div class="w-[400px]">
                        <p>: {{ $description }}</p>
                    </div>
                </div>
                <div class="mt-1 flex gap-6 justify-between">
                    <h1 class="font-medium">Tanggal</h1>
                    <div class="w-[400px]">
                        <p>: {{ $date }}</p>
                    </div>
                </div>
                <div class="mt-1 flex gap-6 justify-between">
                    <h1 class="font-medium">Customer</h1>
                    <div class="w-[400px]">
                        <p>: {{ $customers_id }}</p>
                    </div>
                </div>
                <div class="mt-1 flex gap-6 justify-between">
                    <h1 class="font-medium">Status</h1>
                    <div class="w-[400px]">
                        <p>: {{ $status_id }}</p>
                    </div>
                </div>
                <div class="mt-1 flex gap-6 justify-between">
                    <h1 class="font-medium">Pembuat</h1>
                    <div class="w-[400px]">
                        <p>: {{ $users_id }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>