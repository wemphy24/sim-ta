<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">
    
    @section('title', 'Inquiry')

    @if ($showingMainPage)
        
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#"><div class="font-medium text-lg text-gray-400">Sales</div></a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#"><div class="font-medium text-lg">Inquiry</div></a>
                </div>
            </div>
        </div>

        {{-- TABLE DATA --}}
        <div class="m-6">
            {{-- ACTION BUTTON --}}
            <div class="flex items-center justify-start gap-4 mb-6 lg:justify-end">
                <button class="py-2 px-4 text-center rounded-lg border hover:bg-zinc-800 hover:text-white">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                        <span>Download CSV</span>
                    </div> 
                </button>
                <button wire:click="showInquiry" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat Inquiry</span>
                    </div>
                </button> 
            </div> 

            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="border-b-2 py-3 px-6 flex">
                    <div class="flex items-center gap-4">
                        <select wire:model="showPage" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="5">5</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <input wire:model.debounce.500ms="search" class="border-gray-300/50 rounded-lg p-2 text-sm" type="text" placeholder="Search">
                        <select wire:model="searchBy" class="border-gray-300/50 rounded-lg text-sm">
                            <option value="inquiry_code">KODE INQUIRY</option>
                            <option value="name">NAMA</option>
                            <option value="description">KETERANGAN</option>
                            <option value="customers_id">CUSTOMER</option>
                            <option value="date">TANGGAL</option>
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
                            <th scope="col" class="py-2 px-4">#</th>
                            <th scope="col" class="py-2 px-3">Kode Inquiry</th>
                            <th scope="col" class="py-2 px-3">Nama</th>
                            <th scope="col" class="py-2 px-3">File Inquiry</th>
                            <th scope="col" class="py-2 px-3">File PO</th>
                            <th scope="col" class="py-2 px-3">Tanggal</th>
                            <th scope="col" class="py-2 px-3">Customer</th>
                            <th scope="col" class="py-2 px-3">Keterangan</th>
                            <th scope="col" class="py-2 px-3">Status</th>
                            <th scope="col" class="py-2 px-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($inquiries as $inquiry)
                        <tr class="bg-white border-b hover:bg-zinc-100 text-sm">
                            <td class="py-1 px-4">{{ ($inquiries ->currentpage()-1) * $inquiries ->perpage() + $loop->index + 1 }}</td>
                            <td class="py-1 px-3 font-medium">INQ.016.3.2023.1002</td>
                            <td class="py-1 px-3">{{ $inquiry->name }}</td>
                            <td class="py-1 px-3"><a class="text-blue-700" href="{{ url('storage/inquiry/'.$inquiry->inquiry_file) }}">{{ $inquiry->inquiry_file }}</a></td>
                            @if ($inquiry->purchase_order_file == NULL)
                                <td class="px-3 text-red-700">Belum Tersedia</td>  
                            @else
                                <td class="px-3">
                                    <a class="text-blue-600" href="{{ url('storage/purchaseorder/'.$inquiry->purchase_order_file) }}">{{ $inquiry->purchase_order_file }}</a>
                                </td>  
                            @endif
                            <td class="py-1 px-3">{{ $inquiry->date }}</td>
                            <td class="py-1 px-3">{{ $inquiry->customer['name'] }}</td>
                            <td class="py-1 px-3">{{ $inquiry->description }}</td>
                            <td class="py-1 px-3">
                                @if ($inquiry->status['name'] == "Working")
                                    <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                        {{ $inquiry->status['name'] }}
                                    </div>
                                @elseif ($inquiry->status['name'] == "Pending")
                                    <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                        {{ $inquiry->status['name'] }}
                                    </div>
                                @else
                                    <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                        {{ $inquiry->status['name'] }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-1 px-3">
                                <div class="flex items-center gap-2 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                    <button wire:click="showDetail({{ $inquiry->id }})" class="bg-blue-500 px-2 py-1 rounded-md">
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
                {{ $inquiries->links() }}
            </div>
        </div>

        {{-- INQUIRY MODAL --}}
        @if ($showingInquiry)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Buat Inquiry</h1>
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kode Inquiry</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" required disabled
                                type="text"   
                                wire:model="inquiry_code"
                            />
                        </div>
                        @error('name') <p class="text-sm text-red-500 error">{{ $message }}</p> @enderror
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="text" required
                                wire:model="name"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>File Inquiry</h1>
                            <label class="text-sm" for="inquiry_file">
                                <input class="w-96 text-sm rounded-lg border border-gray-300/50" required
                                    type="file"
                                    wire:model="inquiry_file"
                                >
                            </label>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Keterangan</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="description"
                                wire:model="description"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Tanggal</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" required
                                type="date"
                                wire:model="date"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Customer</h1>
                            <select wire:model="customers_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                <option value="">Pilih Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-end">
                                <button wire:click="storeInquiry" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
        <div class="mt-20 mx-6">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Sales</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">{{ $name }}</div>
                    </a>
                </div>
                <button class="text-lg font-medium" wire:click="back">
                    Kembali
                </button>
            </div>
        </div>

        
        <div class="m-6">

            {{-- PROGRESS BAR --}}
            {{-- <div class="mb-6">
                <div class="w-full bg-gray-200 rounded-full mb-2">
                    @if ($status_id == "Complete")
                        <div class="bg-zinc-800 h-2.5 rounded-full" style="width:100%"></div>
                    @else
                        <div class="bg-zinc-800 h-2.5 rounded-full" style="width:50%"></div>
                    @endif
                </div>
                <div class="flex justify-between font-medium">
                    <label>Pending</label>
                    <label>Working</label>
                    <label>Complete</label>
                </div>
            </div> --}}

            <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                <div class="bg-white py-3 px-6">
                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kode Inquiry:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="inquiry_code"
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Nama:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="name"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Keterangan:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                wire:model="description"
                                type="text"
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Customer:</label>
                            <select wire:model="customers_id" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm">
                                <option value="">Pilih Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Tanggal:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="date"
                                wire:model="date"
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Status:</label>
                            @if ($status_id == "Pending")
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-red-200 font-bold"
                                    type="text"
                                    wire:model="status_id"
                                    disabled
                                />
                            @elseif ($status_id == "Working")
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-yellow-200"
                                    type="text"
                                    wire:model="status_id"
                                    disabled
                                />
                            @else
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-green-200"
                                    type="text"
                                    wire:model="status_id"
                                    disabled
                                />
                            @endif
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label for="inquiry_file">File Inquiry:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="file"
                                wire:model="inquiry_file"
                            />
                            <div class="my-2">
                                <div class="border border-gray-300/50 rounded-lg shadow-sm text-center w-24">
                                    <a href="{{ url('storage/inquiry/'.$inquiry->inquiry_file) }}" class="text-blue-600 hover:bg-gray-100">
                                        <div class="w-24 p-2">
                                            <img src="{{ asset('/images/pdf_icon.png') }}">
                                            <p class="truncate">{{ $inquiry->inquiry_file }}</p>
                                        </div>
                                    </a>
                                </div> 
                            </div>
                        </div>
                        <div class="md:w-1/2">
                            <label for="purchase_order_file">File PO:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="file"
                                wire:model="purchase_order_file"
                            />
                            <div class="my-2">
                                @if ($inquiry->purchase_order_file == NULL)
                                    <p class="w-full text-red-600">Belum Tersedia</p>
                                @else
                                    <div class="border border-gray-300/50 rounded-lg shadow-sm text-center w-24">
                                    <a href="{{ url('storage/purchaseorder/'.$inquiry->purchase_order_file) }}" class="text-blue-600 hover:bg-gray-100">
                                        <div class="w-24 p-2">
                                            <img src="{{ asset('/images/pdf_icon.png') }}">
                                            <p class="truncate">{{ $inquiry->purchase_order_file }}</p>
                                        </div>
                                    </a>
                                </div> 
                                @endif
                            </div>
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:w-1/2">
                        <label>Dibuat:</label>
                        <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled
                            type="text"
                            wire:model="users_id"
                            maxlength="128"
                        />
                    </div>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="py-3 px-6">
                <div class="flex justify-end gap-4">
                    <button wire:click="updateInquiry" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        Simpan
                    </button>
                    <button wire:click="doneInquiry" class="py-2 px-6 my-2 text-center rounded-lg bg-green-500 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        Approve
                    </button>
                </div>
                
            </div>
        </div>
    @endif

</div>
