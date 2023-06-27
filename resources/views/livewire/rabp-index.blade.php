<div class="main-content bg-zinc-100 flex-1 md:ml-64 h-screen">

    @section('title', 'RABP')

        @if ($showingMainPage)
        
            {{-- PAGE TITLE --}}
            <div class="mx-6 mt-20">
                <div class="flex justify-between">
                    <div class="flex items-center gap-4">
                        <a href="#"><div class="font-medium text-lg text-gray-400">Sales</div></a>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        <a href="#"><div class="font-medium text-lg">Rancangan Anggaran Biaya Penawaran (RABP)</div></a>
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
                    <button wire:click="showRabp" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800 hover:scale-105 hover:-translate-x-0 hover:duration-150">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Buat RABP</span>
                        </div>
                    </button> 
                    {{-- <button wire:click="viewPdf" class="py-2 px-4 text-center text-white rounded-lg border bg-zinc-800">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Test PDF</span>
                        </div>
                    </button>  --}}
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
                                <option value="rabp_code">KODE RABP</option>
                                <option value="name">NAMA</option>
                                <option value="description">KETERANGAN</option>
                                <option value="date">TANGGAL</option>
                                <option value="status_id">STATUS</option>
                                <option value="quotations_id">NAMA PENAWARAN</option>
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
                                <th scope="col" class="py-3 px-3">Kode RABP</th>
                                <th scope="col" class="py-3 px-3">Nama Penawaran</th>
                                <th scope="col" class="py-3 px-3">Nama RABP</th>
                                <th scope="col" class="py-3 px-3">Keterangan</th>
                                <th scope="col" class="py-3 px-3">Tanggal</th>
                                <th scope="col" class="py-3 px-3">Status</th>
                                <th scope="col" class="py-3 px-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($rabps as $rabp)
                            <tr class="bg-white border-b hover:bg-gray-50 hover:text-black text-sm">
                                <td class="py-1 px-3">{{ ($rabps->currentpage()-1) * $rabps ->perpage() + $loop->index + 1 }}</td>
                                <td class="py-1 px-3 font-medium">{{ $rabp->rabp_code }}</td>
                                <td class="py-1 px-3">{{ $rabp->quotation['name'] }}</td>
                                <td class="py-1 px-3">{{ $rabp->name }}</td>
                                <td class="py-1 px-3">{{ $rabp->description }}</td>
                                <td class="py-1 px-3">{{ $rabp->date }}</td>
                                <td class="py-1 px-3">
                                    @if ($rabp->status['name'] == "Working")
                                        <div class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $rabp->status['name'] }}
                                        </div>
                                    @elseif ($rabp->status['name'] == "Complete")
                                        <div class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $rabp->status['name'] }}
                                        </div>
                                    @else
                                        <div class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center">
                                            {{ $rabp->status['name'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-1 px-3">
                                    <div class="flex items-center gap-4">                                     
                                        <button wire:click="showDetail({{ $rabp->id }})" class="bg-blue-500 px-2 py-1 rounded-md hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                        </button>
                                        @if ($rabp->status['name'] == "Pending")
                                            <button title="Approve" wire:click="approvee1({{ $rabp->id }})" class="text-white bg-green-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Approve 1
                                            </button>
                                        @elseif ($rabp->status['name'] == "Working")
                                            <button title="Approve" wire:click="approvee2({{ $rabp->id }})" class="text-white bg-green-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150">
                                                Approve 2
                                            </button>
                                        @else
                                            <button title="Approve" wire:click="" class="text-white bg-red-500 p-2 rounded-lg font-medium hover:scale-105 hover:-translate-x-0 hover:duration-150" disabled>
                                                Approve 2
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
                    {{ $rabps->links() }}
                </div>
            </div>

            {{-- RABP MODAL --}}
            @if ($showingRabp)
                <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                    <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                        <div class="flex justify-between items-center">
                            <h1 class="font-medium text-xl">Buat RABP</h1>
                            <button wire:click="closeModal">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Kode Penawaran</h1>
                                <select wire:model="quotations_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                    <option value="">Pilih Penawaran</option>
                                    @foreach ($quotations as $quotation)
                                        <option value="{{ $quotation->id }}">{{ $quotation->quotation_code }} - {{ $quotation->customer['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Kode RABP</h1>
                                <input wire:model="rabp_code" type="text" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" disabled/>
                            </div>
                            @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Nama</h1>
                                <input wire:model="name" type="text" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" required placeholder="Nama RABP" maxlength="128"/>
                            </div>
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Keterangan</h1>
                                <input wire:model="description" type="text" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" maxlength="128"/>
                            </div>
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                <h1>Tanggal</h1>
                                <input wire:model.lazy="date" type="date" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" />
                            </div>

                            <div class="mt-4">
                                <div class="flex justify-end">
                                    <button wire:click="storeRabp" class="text-white bg-zinc-800 py-2 px-6 rounded-lg hover:scale-105 hover:-translate-x-0 hover:duration-150">
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
                            <div class="font-medium text-lg text-gray-400">Penawaran</div>
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

                {{-- SECTION DATA RABP --}}
                <div class="overflow-x-auto sm:rounded-lg border border-gray-300/50">
                    <div class="bg-white py-3 px-6">
                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Kode RABP:</label>
                                <input wire:model="rabp_code" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled/>
                            </div>
                            <div class="md:w-1/2">
                                <label>Nama Penawaran:</label>
                                <input wire:model="quotations_id" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled/>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Nama RABP:</label>
                                <input wire:model="name" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"/>
                            </div>
                            <div class="md:w-1/2">
                                <label class="font-medium">Keterangan:</label>
                                <input wire:model="description" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"/>
                            </div>
                        </div>

                        {{--  --}}
                        <div class="md:flex gap-2 form py-1">
                            <div class="md:w-1/2">
                                <label>Tanggal:</label>
                                <input wire:model="date" type="date" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm"/>
                            </div>
                            <div class="md:w-1/2">
                                <label>Status:</label>
                                @if ($status_id == "Pending")
                                    <input wire:model="status_id" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-red-200" disabled/>
                                @elseif ($status_id == "Working")
                                    <input wire:model="status_id" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-yellow-200" disabled/>
                                @else
                                    <input wire:model="status_id" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-green-200" disabled/>
                                @endif
                            </div>
                        </div>

                        {{--  --}}
                        <div class="form">
                            <label>Dibuat:</label>
                            <input wire:model="users_id" type="text" class="w-full border border-gray-300/50 rounded-lg shadow-sm text-sm bg-gray-100" disabled/>
                        </div>
                    </div>
                </div>

                {{-- BUTTON ACTION --}}
                <div class="pt-3 px-6">
                    <div class="flex justify-end">
                        <button wire:click="updateRabp" class="text-white bg-zinc-800 py-2 px-6 rounded-lg">
                            Simpan
                        </button>
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
                            <div class="md:w-1/2">
                                <label>PPN:</label>
                                <div class="w-full border border-gray-300/50 rounded-lg shadow-sm bg-red-200">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 py-10 bg-red-400 rounded-l-lg"></div>
                                        <div class="text-2xl font-medium">{{ $ppn }} %</div>
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
                        <button wire:click="updateCost" class="text-white bg-zinc-800 py-2 px-6 rounded-lg">
                            Simpan
                        </button>
                    </div>
                </div>

                {{-- SECTION DAFTAR BARANG --}}
                <div class="bg-white overflow-x-auto sm:rounded-lg border border-gray-300/50 mt-6">
                    <div class="py-3 px-6">
                        <div class="font-medium text-xl mb-3">Daftar Barang</div>
                        <table class="w-full text-sm text-left text-black">
                            <thead class="bg-zinc-200">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Barang</th>
                                    <th scope="col" class="py-3 px-6">Qty</th>
                                    <th scope="col" class="py-3 px-6">Harga</th>
                                    <th scope="col" class="py-3 px-6">Sub Total</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailrabps as $detailrabp)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        <td class="py-2 px-6">{{ $detailrabp->set_good['name'] }}</td>
                                        <td class="py-2 px-6">{{ $detailrabp->qty }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($detailrabp->price) }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($detailrabp->price * $detailrabp->qty) }}</td>
                                        <td class="py-2 px-6 text-blue-600">
                                            <button wire:click="editSetGood({{ $detailrabp->id }})" class="bg-yellow-500 px-2 py-1 rounded-md">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                            </button>
                                            <button wire:click="detailGood({{ $detailrabp->set_goods_id }})" class="bg-blue-500 px-2 py-1 rounded-md">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                            </button>
                                            <button wire:click="printPdf({{ $detailrabp->set_goods_id }})" class="bg-zinc-500 px-2 py-1 rounded-md">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"></path></svg>
                                            </button>
                                        </td>
                                        {{-- <td class="py-2 px-6 text-blue-600"><button wire:click="updateProfitPrice">Hitung Ulang</button></td> --}}
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class="font-medium">
                                    <td class="py-2 px-2">
                                        <select wire:model="set_goods_id" class="w-full border-gray-300/50 rounded-lg text-sm">
                                            <option value="">Pilih Barang</option>
                                            @foreach ($setgoods as $setgood)
                                                <option value="{{ $setgood->id }}">{{ $setgood->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2 px-2">
                                        <input wire:model="qty_bg" type="number" class="w-full border-gray-300/50 rounded-lg text-sm text-center" min="1"/>
                                    </td>
                                    <td class="py-2 px-2">
                                        <input wire:model="price_bg" type="number" class="w-full border-gray-300/50  rounded-lg text-sm text-center" disabled/>
                                    </td>
                                    <td class="py-2 px-2">
                                        <input wire:model="total_price_bg" type="number" class="w-full border-gray-300/50  rounded-lg text-sm text-center" disabled/>
                                    </td>
                                    <td class="py-2 px-6">
                                        <button class="bg-zinc-800 px-2 py-1 rounded-md" wire:click="storeGood">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        {{-- <div class="mt-3 flex justify-center">
                            <button wire:click="getReview" class="text-white bg-zinc-800 py-2 px-6 rounded-lg">
                                Review
                            </button>
                        </div> --}}

                        {{-- SECTION HARGA PRODUKSI --}}
                        <div class="px-6 mt-3">
                            
                            <div class="flex gap-3 items-center justify-between font-medium">
                                <h1>Total Produksi:</h1>
                                <div class="text-xl font-bold">Rp. {{ number_format($total_price_production) }}</div>
                            </div>
                        
                            <div class="flex gap-3 items-center justify-between font-medium">
                                <h1>Total Profit:</h1>
                                <div class="text-xl font-bold">Rp. {{ number_format($total_profit) }}</div>
                            </div>
                        
                            <div class="flex gap-3 items-center justify-between font-medium">
                                <h1>Total PPN:</h1>
                                <div class="text-xl font-bold">Rp. {{ number_format($total_ppn) }}</div>
                            </div>
                        
                            <div class="flex gap-3 items-center justify-between font-medium">
                                <h1>Total Jual:</h1>
                                <div class="text-xl font-bold">Rp. {{ number_format($total_price) }}</div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="py-3 px-6">
                    <div class="flex justify-between">
                        <div class="flex gap-4">
                            @if ($status_id == 'Pending')
                                <button wire:click="viewPdf" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                                    Download Penawaran
                                </button>
                                <button wire:click="showProduction" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                                    Proses Produksi
                                </button>
                            @elseif ($status_id == 'Working')
                                <button wire:click="viewPdf" class="py-2 px-6 my-2 text-center rounded-lg bg-yellow-500 text-white">
                                    Download Penawaran
                                </button>
                                <button wire:click="showProduction" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                                    Proses Produksi
                                </button>
                            @else   
                                <button wire:click="viewPdf" class="py-2 px-6 my-2 text-center rounded-lg bg-yellow-500 text-white">
                                    Download Penawaran
                                </button>
                                <button wire:click="showProduction" class="py-2 px-6 my-2 text-center rounded-lg bg-blue-500 text-white">
                                    Proses Produksi
                                </button>
                            @endif
                        </div>
                        
                        <div class="flex gap-4">
                            @if ($status_id == 'Complete')
                                <button wire:click="showRevision" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                                    Revisi
                                </button>
                            @else
                                <button wire:click="showRevision" class="py-2 px-6 my-2 text-center rounded-lg bg-indigo-500 text-white">
                                    Revisi
                                </button>
                            @endif
                            @if ($status_id == 'Pending')
                                <button wire:click="approve1" class="py-2 px-6 my-2 text-center rounded-lg bg-green-500 text-white">
                                    Approve 1
                                </button>
                            @elseif ($status_id == 'Working')
                                <button wire:click="approve2" class="py-2 px-6 my-2 text-center rounded-lg bg-green-500 text-white">
                                    Approve 2
                                </button>
                            @else
                                <button wire:click="approve2" class="py-2 px-6 my-2 text-center rounded-lg bg-red-500 text-white" disabled>
                                    Approve 2
                                </button>
                            @endif
                        </div>
                    </div>
                    {{-- <button wire:click="viewPdf" class="py-2 px-6 text-center rounded-lg bg-yellow-500 w-full text-white">
                        <div class="flex items-center gap-1 justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                            <span>Download Penawaran</span>
                        </div> 
                    </button> --}}
                </div>

                <!-- PRODUCTION MODAL -->
                @if ($showingProduction)
                    <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                        <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                            <div class="flex justify-between items-center">
                                <h1 class="font-medium text-xl">Tentukan Deadline</h1>
                                <button wire:click="closeProduction">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                    <h1>Kode Produksi</h1>
                                    <input wire:model="production_code" type="text" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" maxlength="128"/ disabled>
                                </div>
                                <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                    <h1>Tanggal</h1>
                                    <input wire:model="date" type="date" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" maxlength="128"/>
                                </div>
                                <div class="mt-4">
                                    <div class="flex justify-end">
                                        <button wire:click="storeProduction" class="text-white bg-zinc-800 py-2 px-6 rounded-lg">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



                {{-- REVISION MODAL --}}
                @if ($showingRevision)
                    <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                        <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                            <div class="flex justify-between items-center">
                                <h1 class="font-medium text-xl">Tambahkan Revisi</h1>
                                <button wire:click="closeRevision">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                                    <h1>Keterangan</h1>
                                    <input wire:model="description" type="text" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" maxlength="128"/>
                                </div>
                                <div class="mt-4">
                                    <div class="flex justify-end">
                                        <button wire:click="storeRevision" class="text-white bg-zinc-800 py-2 px-6 rounded-lg">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

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
                                    <th scope="col" class="py-3 px-6">Harga Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mbud as $t)
                                    <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                        {{-- <td class="py-2 px-6">{{ $t->set_good['name'] }}</td> --}}
                                        <td class="py-2 px-6">{{ $t->material['name'] }}</td>
                                        <td class="py-2 px-6">{{ $t->qty }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($t->price) }}</td>
                                        <td class="py-2 px-6">Rp. {{ number_format($t->total_price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>     
            </div>

            {{-- SECTION DETAIL MATERIAl --}}
            @if ($showingDetailGood)
                <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-center">
                            <h1 class="font-medium text-xl">{{ $good_name }}</h1>
                            <button wire:click="closeDetailGood">
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
                                        <th scope="col" class="py-3 px-6">Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($setbillmaterials as $sbm)
                                        <tr class="bg-white hover:bg-gray-50 hover:text-black font-medium">
                                            <td class="py-2 px-6">{{ $sbm->material['name'] }}</td>
                                            <td class="py-2 px-6">{{ $sbm->qty * $count_material }}</td>
                                            <td class="py-2 px-6">Rp. {{ number_format($sbm->price) }}</td>
                                            <td class="py-2 px-6">Rp. {{ number_format($sbm->total_price * $count_material) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- SECTION EDIT MODAL --}}
            @if ($showingEditGood)
                <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                    <div class="bg-white p-4 rounded-lg shadow-md w-[350px] h-[500px] overflow-auto sm:w-fit sm:h-fit">
                        <div class="flex justify-between items-center">
                            <h1 class="font-medium text-xl">Edit Barang</h1>
                            <button wire:click="closeEdit">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Barang</h1>
                            <select wire:model="s_good_id" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm">
                                <option value="">Pilih Barang</option>
                                @foreach ($setgoods as $setgood)
                                    <option value="{{ $setgood->id }}">{{ $setgood->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Qty</h1>
                            <input wire:model="b_qty" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm" type="number"/>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Harga</h1>
                            <input wire:model="b_price" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="number" disabled/>
                        </div>
                        <div class="flex items-center gap-0 justify-between p-1 flex-wrap sm:gap-2">
                            <h1>Sub Total</h1>
                            <input wire:model="b_total_price" class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100" type="number" disabled/>
                        </div>
                        <div class="mt-4">
                        <div class="flex justify-end">
                            <button wire:click="updateSetGood" class="text-white bg-zinc-800 py-2 px-6 rounded-lg">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endif

</div>
