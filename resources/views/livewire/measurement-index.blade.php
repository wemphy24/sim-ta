<div class="main-content bg-gray-100 flex-1">

    @section('title', 'Measurement')

        <div class="m-6">
            <div class="flex justify-between">
                <div class="flex items-center gap-4">
                    <a href="#">
                        <div class="font-medium text-lg text-gray-400">Master Data</div>
                    </a>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <a href="#">
                        <div class="font-medium text-lg">Measurement</div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="m-6">
            <div
                class="overflow-x-auto shadow-sm sm:rounded-xl border border-gray-300/50"
            >
            <div class="bg-white border-b-2 py-3 px-6 flex justify-end gap-4">
                <button class="py-2 px-4 text-center rounded-lg border hover:bg-purple-900 hover:text-white">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                        <span>Download CSV</span>
                    </div> 
                </button>
                <button wire:click="showMeasurementModal" class="py-2 px-4 text-center text-white rounded-lg border bg-purple-900">
                    <div class="flex items-center gap-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Add Measurement</span>
                    </div>
                </button>               
            </div>
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-white text-black">
                        <tr>
                            <th scope="col" class="py-3 px-6">No</th>
                            <th scope="col" class="py-3 px-6">
                                Name
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Created
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Updated
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($measurements as $measurement)
                        <tr
                            class="bg-white border-b hover:bg-gray-100 hover:text-black font-medium"
                        >
                            <td class="py-4 px-6">{{ $count+=1 }}</td>
                            <td class="py-4 px-6">
                                {{ $measurement->name }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $measurement->created_at->format('m/d/Y') }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $measurement->updated_at->format('m/d/Y') }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <button wire:click="showMeasurementEditModal( {{ $measurement->id }} )">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="deleteMeasurement({{ $measurement->id }})">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Default bernilai false --}}
        @if ($showingMeasurementModal === true)
            <div
                class="bg-black bg-opacity-50 fixed inset-0 flex justify-center items-center"
            >
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <div class="flex justify-between items-center">
                        @if($isEditMode === true)
                            <h1 class="font-medium text-xl">Update Measurement</h1>
                        @else
                            <h1 class="font-medium text-xl">Add Measurement</h1>
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
                        <div class="flex items-center gap-8 justify-between p-1">
                            <h1>Name</h1>
                            <input
                                type="text"
                                wire:model="name"
                                class="w-96 border border-gray-300/50 rounded-lg p-2 shadow-sm mt-1 text-sm"
                            />
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-end">
                                @if($isEditMode == true)
                                    <button
                                        wire:click="updateMeasurement"
                                        class="text-white bg-purple-900 py-2 px-6 rounded-xl"
                                    >
                                        Update
                                    </button>
                                @else
                                    <button
                                        wire:click="storeMeasurement"
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
</div>
