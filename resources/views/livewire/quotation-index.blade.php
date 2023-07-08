<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">

    @section('title', 'Quotation')

    @if ($showingMainPage)
        
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#"><div class="font-medium text-lg text-gray-400">Sales</div></a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#"><div class="font-medium text-lg">Penawaran</div></a>
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
                <button wire:click="showQuotation" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat Penawaran</span>
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
                            <option value="quotation_code">KODE PENAWARAN</option>
                            <option value="name">NAMA</option>
                            <option value="project">PROYEK</option>
                            <option value="date">TANGGAL</option>
                            <option value="status_id">STATUS</option>
                            <option value="customers_id">CUSTOMER</option>
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
                            <th scope="col" class="py-3 px-3">Kode Penawaran</th>
                            <th scope="col" class="py-3 px-3">Nama</th>
                            <th scope="col" class="py-3 px-3">File Penawaran</th>
                            <th scope="col" class="py-3 px-3">Proyek</th>
                            <th scope="col" class="py-3 px-3">Tanggal</th>
                            <th scope="col" class="py-3 px-3">Customer</th>
                            <th scope="col" class="py-3 px-3">Status</th>
                            <th scope="col" class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($quotations as $quotation)
                        <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                            <td class="py-1 px-3">{{ ($quotations ->currentpage()-1) * $quotations ->perpage() + $loop->index + 1 }}</td>
                            <td class="py-1 px-3 font-medium">{{ $quotation->quotation_code }}</td>
                            <td class="py-1 px-3">{{ $quotation->name }}</td>
                            @if ($quotation->quotation_file == NULL)
                                <td class="px-3 text-red-700">Belum Tersedia</td>  
                            @else
                                <td class="px-3">
                                    <a class="text-blue-600" href="{{ url('storage/purchaseorder/'.$quotation->quotation_file) }}">{{ $quotation->quotation_file }}</a>
                                </td>  
                            @endif
                            <td class="py-1 px-3">{{ $quotation->project }}</td>
                            <td class="py-1 px-3">{{ $quotation->date }}</td>
                            <td class="py-1 px-3">{{ $quotation->customer['name'] }}</td>
                            <td class="py-1 px-3">
                                @if ($quotation->status['name'] == "Working")
                                    <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                        {{ $quotation->status['name'] }}
                                    </div>
                                @elseif ($quotation->status['name'] == "Pending")
                                    <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                        {{ $quotation->status['name'] }}
                                    </div>
                                @else
                                    <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                        {{ $quotation->status['name'] }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-1 px-3">
                                <div class="flex items-center gap-4">
                                    <button wire:click="showDetail({{ $quotation->id }})" class="bg-blue-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
                {{ $quotations->links() }}
            </div>
        </div>

        {{-- QUOTATION MODAL --}}
        @if ($showingQuotation)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Buat Penawaran</h1>
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kode Inquiry</h1>
                            <select wire:model="inquiries_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                <option value="">Pilih Inquiry</option>
                                @foreach ($inquiries as $inquiry)
                                    <option value="{{ $inquiry->id }}">{{ $inquiry->inquiry_code }} - {{ $inquiry->customer['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kode Penawaran</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                type="text"
                                wire:model="quotation_code"
                                disabled
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="text"
                                wire:model="name"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Proyek</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="text"
                                wire:model="project"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Tanggal</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                type="date"
                                wire:model.lazy="date"
                                disabled
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Lokasi</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="text"
                                wire:model="location"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Customer</h1>
                            <select wire:model="customers_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" disabled>
                                <option value="">Pilih Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="mt-4">
                            <div class="flex justify-end">
                                <button wire:click="storeQuotation" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
                        <div class="font-medium text-lg text-gray-400">Penawaran</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">{{ $name }}</div>
                    </a>
                </div>
                <button wire:click="back" class="text-lg font-medium">
                    Kembali
                </button>
            </div>
        </div>

        <div class="m-6">

            <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                <div class="bg-white py-3 px-6">
                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kode Penawaran: </label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="text"
                                wire:model="quotation_code"
                                disabled
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Inquiry:</label>
                            <select wire:model="inquiries_id" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled>
                                <option value="">Pilih Inquiry</option>
                                @foreach ($inquiries as $inquiry)
                                    <option value="{{ $inquiry->id }}">{{ $inquiry->name }}</option>
                                @endforeach
                            </select>
                            {{-- <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="text"
                                wire:model="inquiries_id"
                                disabled
                            /> --}}
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Nama:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="name"
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Proyek:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="project"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Customer:</label>
                            <select wire:model="customers_id" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled>
                                <option value="">Pilih Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:w-1/2">
                            <label>Lokasi:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="location"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Tanggal:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled
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
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-yellow-200 font-bold"
                                    type="text"
                                    wire:model="status_id"
                                    disabled
                                />
                            @else
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-green-200 font-bold"
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
                            <label for="quotation_file">File Penawaran:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="file"
                                wire:model="quotation_file"
                            />
                            <div class="my-2">
                                @if ($quotation->quotation_file == NULL)
                                    <p class="w-full text-red-600">Belum Tersedia</p>
                                @else
                                    <div class="border border-gray-300/50 rounded-lg shadow-sm text-center w-24">
                                    <a href="{{ url('storage/quotation/'.$quotation->quotation_file) }}" class="text-blue-600 hover:bg-gray-100">
                                        <div class="w-24 p-2">
                                            <img src="{{ asset('/images/pdf_icon.png') }}">
                                            <p class="truncate">{{ $quotation->quotation_file }}</p>
                                        </div>
                                    </a>
                                </div> 
                                @endif
                            </div>
                        </div>
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
            </div>

            {{-- BUTTON ACTION--}}
            <div class="py-3 px-6">
                <div class="flex justify-end gap-4">
                    <button wire:click="updateQuotation" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        Simpan
                    </button>
                    @if ($quotation->status['name'] == "Pending")
                        <button wire:click="approve" class="py-2 px-6 my-2 text-center rounded-lg bg-green-500 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                            Approve
                        </button>
                    @elseif ($quotation->status['name'] == "Working")
                        <button wire:click="completeQO" class="py-2 px-6 my-2 text-center rounded-lg bg-green-500 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                            Selesai
                        </button>
                    @else
                        <button wire:click="" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                             Penawaran Selesai
                        </button>
                    @endif             
                </div>
            </div>
        </div>
    @endif
        
</div>
