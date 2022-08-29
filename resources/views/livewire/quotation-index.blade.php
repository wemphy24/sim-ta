<div class="main-content bg-gray-100 flex-1">

    @section('title', 'Quotation')

        <div class="m-6">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Penawaran</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">Quotation</div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="m-6">
            <div
                class="overflow-x-auto shadow-sm sm:rounded-xl border border-gray-300/50"
            >
            <div class="bg-white border-b-2 py-3 px-6 flex justify-between gap-4">
                <div class="flex items-center gap-4">
                    <select wire:model="showPage" class="border-gray-300/50 rounded-xl shadow-sm text-sm">
                        <option value="5">5</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                    <input wire:model="search" class="w-96 border-gray-300/50 rounded-xl p-2 shadow-sm text-sm" type="text" placeholder="Search">
                </div>
                <div class="flex items-center gap-4">
                    <button class="py-2 px-4 text-center rounded-xl border hover:bg-purple-900 hover:text-white">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                            <span>Download CSV</span>
                        </div> 
                    </button>
                    <button wire:click="showQuotationModal" class="py-2 px-4 text-center text-white rounded-xl border bg-purple-900">
                        <div class="flex items-center gap-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>Add Quotation</span>
                        </div>
                    </button>   
                </div>        
            </div>
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">No</th>
                            <th scope="col" class="py-3 px-6">
                                Quotation Code
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Name
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Project
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Date
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Customer
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
                        @foreach ($quotations as $quotation)
                        <tr
                            class="bg-white border-b hover:bg-gray-50 hover:text-black font-medium"
                        >
                            <td class="py-4 px-6">{{ ($quotations ->currentpage()-1) * $quotations ->perpage() + $loop->index + 1 }}</td>
                            <td class="py-4 px-6">
                                {{ $quotation->quotation_code }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $quotation->name }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $quotation->project }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $quotation->date }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $quotation->customer['name'] }}
                            </td>
                            <td class="py-4 px-6">
                                <div
                                    class="bg-red-200 w-24 py-1.5 rounded-full font-medium text-center"
                                >
                                    {{ $quotation->status['name'] }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <button wire:click="detailQuotation({{ $quotation->id }})">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                    </button>
                                    <button wire:click="showQuotationEditModal( {{ $quotation->id }} )">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="deleteQuotation({{ $quotation->id }})">
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
                {{ $quotations->links() }}
            </div>
            
        </div>

        {{-- Default bernilai false --}}
        @if ($showingQuotationModal === true)
            <div
                class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center"
            >
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <div class="flex justify-between items-center">
                        @if($isEditMode === true)
                            <h1 class="font-medium text-xl">Update Quotation</h1>
                        @else
                            <h1 class="font-medium text-xl">Add Quotation</h1>
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
                    <div class="border black w-full mt-4"></div>
                    <div class="mt-4">
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Quotation Code</h1>
                            <input
                                disabled
                                type="text"
                                wire:model="quotation_code"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                            />
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Name</h1>
                            <input
                                type="text"
                                wire:model="name"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            />
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Project</h1>
                            <input
                                type="text"
                                wire:model="project"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            />
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Date</h1>
                            <input
                                disabled
                                type="date"
                                wire:model.lazy="currentDate"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                            />
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Location</h1>
                            <input
                                type="text"
                                wire:model="location"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            />
                        </div>
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Customer</h1>
                            <select
                                @if($isEditMode)
                                disabled
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm bg-gray-100"
                                wire:model="customers_id"
                                @else
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                                wire:model="customers_id"
                                @endif
                            >
                                <option value="">Choose Customer</option>
                                @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="border black w-full mt-4"></div>
                        <div class="mt-4">
                            <div class="flex justify-end">
                                @if($isEditMode == true)
                                    <button
                                        wire:click="updateQuotation"
                                        class="text-white bg-purple-900 py-2 px-6 rounded-xl"
                                    >
                                        Update
                                    </button>
                                @else
                                    <button
                                        wire:click="storeQuotation"
                                        class="text-white bg-purple-900 py-2 px-6 rounded-xl"
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
        
        @if ($showingDetailQuotationModal == true)
            <div class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center">
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <div class="flex justify-between">
                        <h1 class="font-medium text-xl">Detail Quotation</h1>
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
                        <h1 class="font-medium">Quotation Code</h1>
                        <div class="w-[400px]">
                            <p>: {{ $quotation_code }}</p>
                        </div>
                    </div>
                    <div class="mt-1 flex gap-6 justify-between">
                        <h1 class="font-medium">Name</h1>
                        <div class="w-[400px]">
                            <p>: {{ $name }}</p>
                        </div>
                    </div>
                    <div class="mt-1 flex gap-6 justify-between">
                        <h1 class="font-medium">Project</h1>
                        <div class="w-[400px]">
                            <p>: {{ $project }}</p>
                        </div>
                    </div>
                    <div class="mt-1 flex gap-6 justify-between">
                        <h1 class="font-medium">Date</h1>
                        <div class="w-[400px]">
                            <p>: {{ $currentDate }}</p>
                        </div>
                    </div>
                    <div class="mt-1 flex gap-6 justify-between">
                        <h1 class="font-medium">Location</h1>
                        <div class="w-[400px]">
                            <p>: {{ $location }}</p>
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
                        <h1 class="font-medium">Created By</h1>
                        <div class="w-[400px]">
                            <p>: {{ $users_id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>
