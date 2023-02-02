<div class="main-content bg-gray-50 flex-1 sm:ml-64 h-screen">

    @section('title', 'Dashboard')
    
        <div class="m-6">
            <div class="my-6 text-xl font-medium">Informasi Umum</div>
            <div
                class="flex gap-6 flex-wrap justify-center lg:justify-between"
            >
                <div
                    class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-purple-900 hover:text-white"
                >
                    <div
                        class="bg-purple-900 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-purple-900"
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
                        <p class="font-bold text-2xl">{{ $customers }}</p>
                        <p class="font-medium">Total Customer</p>
                    </div>
                    <a href="{{ route('masterdata.customer') }}">
                        <svg
                            class="w-6 h-6 text-purple-900 group-hover:text-white"
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
                <div
                    class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-purple-900 hover:text-white"
                >
                    <div
                        class="bg-purple-900 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-purple-900"
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
                        <p class="font-bold text-2xl">{{ $suppliers }}</p>
                        <p class="font-medium">Total Supplier</p>
                    </div>
                    <a href="{{ route('masterdata.supplier') }}">
                        <svg
                            class="w-6 h-6 text-purple-900 group-hover:text-white"
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
                <div
                    class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-purple-900 hover:text-white"
                >
                    <div
                        class="bg-purple-900 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-purple-900"
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
                        <p class="font-bold text-2xl">{{ $quotations }}</p>
                        <p class="font-medium">Total Penawaran</p>
                    </div>
                    <a href="{{ route('quotation') }}">
                        <svg
                            class="w-6 h-6 text-purple-900 group-hover:text-white"
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
                <div
                    class="flex w-72 justify-around gap-2 items-center bg-white rounded-xl p-4 border border-gray-300/50 group hover:bg-purple-900 hover:text-white"
                >
                    <div
                        class="bg-purple-900 p-4 rounded-xl group-hover:bg-white"
                    >
                        <svg
                            class="w-8 h-8 text-white group-hover:text-purple-900"
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
                        <p class="font-bold text-2xl">6</p>
                        <p class="font-medium">Total Pengiriman</p>
                    </div>
                    <a href="">
                        <svg
                            class="w-6 h-6 text-purple-900 group-hover:text-white"
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
            <div class="my-6 text-xl font-medium">Tugas Berjalan</div>
            <div
                class="overflow-x-auto shadow-sm sm:rounded-xl border border-gray-300/50"
            >
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-white text-black">
                        <tr>
                            <th scope="col" class="py-3 px-6">No</th>
                            <th scope="col" class="py-3 px-6">
                                Deskripsi
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Deadline
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Tanggal Terakhir
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Divisi
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Status
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium"
                        >
                            <td class="py-4 px-6">1</td>
                            <td class="py-4 px-6">
                                Penawaran Material Bahan
                            </td>
                            <td class="py-4 px-6">3 Hari</td>
                            <td class="py-4 px-6">24 January 2023</td>
                            <td class="py-4 px-6">Produksi</td>
                            <td class="py-4 px-6">
                                <div
                                    class="bg-red-200 w-24 font-medium py-1.5 rounded-full text-center"
                                >
                                    Pending
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <a href="">
                                    <svg
                                        class="w-6 h-6 text-purple-900"
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
                                </a>
                            </td>
                        </tr>
                        <tr
                            class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium"
                        >
                            <td class="py-4 px-6">2</td>
                            <td class="py-4 px-6">Pembuatan Panel A</td>
                            <td class="py-4 px-6">3 Hari</td>
                            <td class="py-4 px-6">24 January 2023</td>
                            <td class="py-4 px-6">Produksi</td>
                            <td class="py-4 px-6">
                                <div
                                    class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center"
                                >
                                    On Process
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <a href="">
                                    <svg
                                        class="w-6 h-6 text-purple-900"
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
                                </a>
                            </td>
                        </tr>
                        <tr
                            class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium"
                        >
                            <td class="py-4 px-6">3</td>
                            <td class="py-4 px-6">
                                Pengiriman Panel A
                            </td>
                            <td class="py-4 px-6">3 Hari</td>
                            <td class="py-4 px-6">24 January 2023</td>
                            <td class="py-4 px-6">Logistik</td>
                            <td class="py-4 px-6">
                                <div
                                    class="bg-green-200 w-24 py-1.5 rounded-full font-medium text-center"
                                >
                                    Complete
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <a href="">
                                    <svg
                                        class="w-6 h-6 text-purple-900"
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
                                </a>
                            </td>
                        </tr>
                        <tr
                            class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium"
                        >
                            <td class="py-4 px-6">1</td>
                            <td class="py-4 px-6">
                                Penawaran Material Bahan
                            </td>
                            <td class="py-4 px-6">3 Hari</td>
                            <td class="py-4 px-6">24 January 2023</td>
                            <td class="py-4 px-6">Produksi</td>
                            <td class="py-4 px-6">
                                <div
                                    class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center"
                                >
                                    Pending
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <a href="">
                                    <svg
                                        class="w-6 h-6 text-purple-900"
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
                                </a>
                            </td>
                        </tr>
                        <tr
                            class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium"
                        >
                            <td class="py-4 px-6">2</td>
                            <td class="py-4 px-6">Pembuatan Panel A</td>
                            <td class="py-4 px-6">3 Hari</td>
                            <td class="py-4 px-6">24 January 2023</td>
                            <td class="py-4 px-6">Produksi</td>
                            <td class="py-4 px-6">
                                <div
                                    class="bg-yellow-200 w-24 py-1.5 rounded-full font-medium text-center"
                                >
                                    On Process
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <a href="">
                                    <svg
                                        class="w-6 h-6 text-purple-900"
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
                                </a>
                            </td>
                        </tr>
                        <tr
                            class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium"
                        >
                            <td class="py-4 px-6">3</td>
                            <td class="py-4 px-6">
                                Pengiriman Panel A
                            </td>
                            <td class="py-4 px-6">3 Hari</td>
                            <td class="py-4 px-6">24 January 2023</td>
                            <td class="py-4 px-6">Logistik</td>
                            <td class="py-4 px-6">
                                <div
                                    class="bg-green-200 py-1.5 w-24 rounded-full font-medium text-center"
                                >
                                    Complete
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <a href="">
                                    <svg
                                        class="w-6 h-6 text-purple-900"
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
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
</div>
