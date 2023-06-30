<div class="main-content bg-zinc-100 flex-1 sm:ml-64 h-screen">

    @section('title', 'Dashboard')
    
        <div class="m-6">
            <div class="my-6 text-xl font-medium">Informasi Umum</div>
            <div class="flex gap-6 flex-wrap justify-center lg:justify-between">
                <div class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-zinc-800 hover:text-white">
                    <div
                        class="bg-zinc-800 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-zinc-800"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-2xl">{{ $inquiries }}</p>
                        <p class="font-medium">Total Inquiry</p>
                    </div>
                    <a href="{{ route('inquiry') }}">
                        <svg
                            class="w-6 h-6 text-zinc-800 group-hover:text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </a>
                </div>

                <div class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-zinc-800 hover:text-white">
                    <div
                        class="bg-zinc-800 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-zinc-800"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-2xl">{{ $quotations }}</p>
                        <p class="font-medium">Total Penawaran</p>
                    </div>
                    <a href="{{ route('quotation') }}">
                        <svg
                            class="w-6 h-6 text-zinc-800 group-hover:text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </a>
                </div>

                <div class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-zinc-800 hover:text-white">
                    <div
                        class="bg-zinc-800 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-zinc-800"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-2xl">{{ $rabpss }}</p>
                        <p class="font-medium">Total RABP</p>
                    </div>
                    <a href="{{ route('rabp') }}">
                        <svg
                            class="w-6 h-6 text-zinc-800 group-hover:text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </a>
                </div>

                <div class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-zinc-800 hover:text-white">
                    <div
                        class="bg-zinc-800 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-zinc-800"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"
                            ></path>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-2xl">{{ $purchaseorders }}</p>
                        <p class="font-medium">Total Pengadaan</p>
                    </div>
                    <a href="{{ route('purchaseorder') }}">
                        <svg
                            class="w-6 h-6 text-zinc-800 group-hover:text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </a>
                </div>

                <div class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-zinc-800 hover:text-white">
                    <div
                        class="bg-zinc-800 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-zinc-800"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"
                            ></path>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-2xl">{{ $returs }}</p>
                        <p class="font-medium">Total Retur</p>
                    </div>
                    <a href="{{ route('retur') }}">
                        <svg
                            class="w-6 h-6 text-zinc-800 group-hover:text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </a>
                </div>

                <div class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-zinc-800 hover:text-white">
                    <div
                        class="bg-zinc-800 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-zinc-800"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"
                            ></path>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-2xl">{{ $logistics }}</p>
                        <p class="font-medium">Total Logistik</p>
                    </div>
                    <a href="{{ route('logistic') }}">
                        <svg
                            class="w-6 h-6 text-zinc-800 group-hover:text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </a>
                </div>

                <div class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-zinc-800 hover:text-white">
                    <div
                        class="bg-zinc-800 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-zinc-800"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"
                            ></path>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-2xl">{{ $qualitycontrols }}</p>
                        <p class="font-medium">Total QC</p>
                    </div>
                    <a href="{{ route('qualitycontrol') }}">
                        <svg
                            class="w-6 h-6 text-zinc-800 group-hover:text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </a>
                </div>

                <div class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-zinc-800 hover:text-white">
                    <div
                        class="bg-zinc-800 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-zinc-800"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"
                            ></path>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-2xl">{{ $deliverys }}</p>
                        <p class="font-medium">Total Pengiriman</p>
                    </div>
                    <a href="{{ route('delivery') }}">
                        <svg
                            class="w-6 h-6 text-zinc-800 group-hover:text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="m-6">
            <div class="my-6 text-xl font-medium">Daftar List RABP</div>
            <div class="overflow-x-auto shadow-sm sm:rounded-xl border border-gray-300/50">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-white text-black">
                        <tr>
                            <th scope="col" class="py-3 px-3">#</th>
                            <th scope="col" class="py-3 px-3">Kode RABP</th>
                            <th scope="col" class="py-3 px-3">
                                Nama Penawaran
                            </th>
                            <th scope="col" class="py-3 px-3">
                                Nama RABP
                            </th>
                            <th scope="col" class="py-3 px-3">
                                Keterangan
                            </th>
                            <th scope="col" class="py-3 px-3">
                                Tanggal
                            </th>
                            <th scope="col" class="py-3 px-3">
                                Status
                            </th>
                            <th scope="col" class="py-3 px-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach ($rabps as $rabp)
                        <tr
                            class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium"
                        >
                            <td class="py-1 px-3">{{ ($rabps->currentpage()-1) * $rabps ->perpage() + $loop->index + 1 }}</td>
                            <td class="py-1 px-3">
                                {{ $rabp->rabp_code }}
                            </td>
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
                                {{-- <a href="">
                                    <svg
                                        class="w-6 h-6 text-zinc-800"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                                        ></path>
                                    </svg>
                                </a> --}}
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
        
</div>
