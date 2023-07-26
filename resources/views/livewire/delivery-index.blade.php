<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">
    
    @section('title', 'Pengiriman')

    @if ($showingMainPage)
        {{-- PAGE TITLE --}}
        <div class="mx-6 mt-20">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#"><div class="font-medium text-lg text-gray-400">Kontrak</div></a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#"><div class="font-medium text-lg">List Pengiriman</div></a>
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
                <button wire:click="showDelivery" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Buat Pengiriman</span>
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
                            <option value="delivery_code">KODE PENGIRIMAN</option>
                            <option value="contracts_id">NAMA KONTRAK</option>
                            <option value="name">NAMA PENGIRIMAN</option>
                            <option value="description">KETERANGAN</option>
                            <option value="send_date">TANGGAL DIKIRIM</option>
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
                            <th scope="col" class="py-3 px-3">Kode Pengiriman</th>
                            <th scope="col" class="py-3 px-3">Nama Pengiriman</th>
                            <th scope="col" class="py-3 px-3">Nama Kontrak</th>
                            <th scope="col" class="py-3 px-3">Keterangan</th>
                            <th scope="col" class="py-3 px-3">Tanggal Dikirim</th>
                            <th scope="col" class="py-3 px-3">Tanggal Diterima</th>
                            <th scope="col" class="py-3 px-3">Status</th>
                            <th scope="col" class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($deliverys as $delivery)
                            <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                <td class="py-1 px-3">{{ ($deliverys ->currentpage()-1) * $deliverys ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-1 px-3 font-medium">{{ $delivery->delivery_code }}</td>
                                <td class="py-1 px-3">{{ $delivery->name }}</td>
                                <td class="py-1 px-3">{{ $delivery->contract['name'] }}</td>
                                <td class="py-1 px-3">{{ $delivery->description }}</td>
                                <td class="py-1 px-3">{{ date('d-m-Y', strtotime($delivery->send_date)) }}</td>
                                @if ($delivery->received_date == NULL)
                                    <td class="py-1 px-3 text-red-500 font-medium">Belum Diterima</td>
                                @else
                                    <td class="py-1 px-3">{{ date('d-m-Y', strtotime($delivery->received_date)) }}</td>
                                @endif
                                <td class="py-1 px-3">
                                    @if ($delivery->status['name'] == "Working")
                                        <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $delivery->status['name'] }}
                                        </div>
                                    @elseif ($delivery->status['name'] == "Complete")
                                        <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $delivery->status['name'] }}
                                        </div>
                                    @else
                                        <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $delivery->status['name'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-1 px-3">
                                    <div class="flex items-center gap-4">
                                        <button wire:click="detail({{ $delivery->id }})" class="bg-blue-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
                {{ $deliverys->links() }}
            </div>
        </div>

        {{-- DELIVERY MODAL --}}
        @if ($showingDelivery)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Buat Pengiriman</h1>
                        <button wire:click="closeModal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mt-4">
                        
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Kode Pengiriman</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                type="text"
                                wire:model="delivery_code"
                                disabled
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama Kontrak</h1>
                            <select wire:model="contracts_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                <option value="">Pilih Kontrak</option>
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->id }}">{{ $contract->contract_code }} - {{ $contract->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama Rabp</h1>
                            <select wire:model="rabps_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                <option value="">Pilih Rabp</option>
                                @foreach ($rabps as $rabp)
                                    <option value="{{ $rabp->id }}">{{ $rabp->rabp_code }} - {{ $rabp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Nama Pengiriman</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="text"
                                wire:model="name"
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Keterangan</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                type="text"
                                wire:model="description"
                                disabled
                            />
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Tanggal Dikirim</h1>
                            <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                type="date"
                                wire:model.lazy="send_date"
                                disabled
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
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Pengriman</div>
                    </a>
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
            {{-- SECTION DATA PENGIRIMAN --}}
            <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                <div class="bg-white py-3 px-6">

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Kode Pengiriman:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100"
                                type="text"
                                wire:model="delivery_code"
                                disabled
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Nama Pengriman:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="name"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Nama Kontrak:</label>
                            <select wire:model="contracts_id" class="w-full border-gray-300/50 rounded-lg text-sm bg-gray-100" disabled>
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:w-1/2">
                            <label>Keterangan:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"
                                type="text"
                                wire:model="description"
                            />
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        <div class="md:w-1/2">
                            <label>Tanggal Dikirim:</label>
                            <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="date" disabled
                                wire:model="send_date" 
                            />
                        </div>
                        <div class="md:w-1/2">
                            <label>Tanggal Diterima:</label>
                            @if ($this->received_date == NULL)
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100 text-red-500" type="text" disabled
                                value="Belum Diterima"/>
                            @else
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" type="text" disabled
                                wire:model="received_date"/>
                            @endif
                            
                        </div>
                    </div>

                    {{--  --}}
                    <div class="md:flex gap-2 form py-1">
                        
                            <div class="md:w-1/2">
                                <label>Nomor Kendaraan:</label>
                                <input class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm" type="text"
                                    wire:model="plate_number" 
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

                </div>
            </div>
            {{--  --}}

            {{-- BUTTON ACTION--}}
            <div class="py-3 px-6">
                <div class="flex justify-end gap-4">
                    <button wire:click="update" class="py-2 px-6 my-2 text-center rounded-lg bg-zinc-800 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        Simpan
                    </button>
                </div>
            </div>
            {{--  --}}

            {{-- SECTION DATA BARANG --}}
            <div class="bg-white overflow-x-auto sm:rounded-lg border border-gray-300/50 mt-6">
                <div class="py-3 px-6">
                    <div class="font-medium text-xl mb-3">Daftar Barang</div>
                    <table class="w-full text-sm text-left text-black">
                        <thead class="bg-zinc-200">
                            <tr>
                                <th scope="col" class="py-3 px-6">Barang</th>
                                <th scope="col" class="py-3 px-6">Qty</th>
                                <th scope="col" class="py-3 px-6">Satuan</th>
                                <th scope="col" class="py-3 px-6">Status</th>
                                <th scope="col" class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($detailrabps as $detailrabp)
                                <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                    <td class="py-2 px-6">{{ $detailrabp->good['name'] }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->qty }}</td>
                                    <td class="py-2 px-6">{{ $detailrabp->good->measurement['name'] }}</td>
                                    @if ($detailrabp->good->status_delivery == NULL)
                                        <td class="py-2 px-6 text-red-500">Belum Diambil</td>
                                    @else
                                        <td class="py-2 px-6">{{ $detailrabp->good->status_delivery }}</td>
                                    @endif
                                    <td class="py-2 px-6 text-white">
                                        @if ($detailrabp->good->status_delivery == NULL)
                                            <button wire:click="printLogistic({{ $detailrabp->goods_id }})" class="bg-green-500 px-2 py-1 rounded-md">
                                                Ambil Barang
                                            </button>
                                        @elseif ($detailrabp->good->status_delivery == "Sedang Diambil")
                                            <button wire:click="" class="bg-yellow-500 px-2 py-1 rounded-md" disabled>
                                                Sedang Diambil
                                            </button>
                                        @elseif ($detailrabp->good->status_delivery == "Sedang Dikirim")
                                            <button wire:click="" class="bg-red-500 px-2 py-1 rounded-md" disabled>
                                                Selesai
                                            </button>
                                        @endif
                                    </td>   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{--  --}}

            <div class="py-3 px-6">
                <div class="flex justify-between">
                    <div class="flex gap-4">
                        @if ($this->status_id == "Pending")
                            <button wire:click="" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                                Download Surat Jalan
                            </button>
                        @else
                            <button wire:click="viewPdf" class="py-2 px-6 my-2 text-center rounded-lg bg-yellow-500 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Download Surat Jalan
                            </button>
                        @endif
                        
                    </div>
                    
                    <div class="flex gap-4">
                        @if ($this->status_id == "Pending")
                            <button wire:click="approve" class="py-2 px-6 my-2 text-center rounded-lg bg-green-500 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Approve  
                            </button>
                        @elseif ($this->status_id == "Working")
                            <button wire:click="showReceived" class="py-2 px-6 my-2 text-center rounded-lg bg-green-500 text-white hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Selesai  
                            </button>
                        @elseif ($this->status_id == "Complete")
                            <button wire:click="" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                                Pengiriman Selesai  
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- INPUT TERIMA MODAL --}}
        @if ($showingReceived)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                    <div class="flex justify-between items-center">
                        <h1 class="font-medium text-xl">Tanggal Diterima</h1>
                        <button wire:click="closeModalReceived">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                        <input class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            type="date"
                            wire:model="received_date"
                        />
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-end">
                            <button wire:click="completeDelivery" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
