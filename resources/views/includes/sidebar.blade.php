<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        <a href="https://flowbite.com" class="flex ml-2 md:mr-24">
          {{-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="FlowBite Logo" /> --}}
          <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">SIM Group</span>
        </a>
      </div>
      <div class="flex items-center">
          <div class="flex items-center ml-3">
            <div>
              <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
              </button>
            </div>
            <div class="border z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow" id="dropdown-user">
              <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900" role="none">
                  {{ Auth::user()->name }}
                </p>
                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                  {{ Auth::user()->email }}
                </p>
              </div>
              {{-- <ul class="py-1" role="none">
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign Out</a>
                </li>
              </ul> --}}
            </div>
          </div>
        </div>
    </div>
  </div>
</nav>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-white text-zinc-800">
      <ul class="space-y-2">
        {{-- DASHBOARD --}}
         <li>
            <a href="{{ url('general') }}" class="{{ request()->is('general') ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group">
               <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
               <span class="ml-3 font-medium">Dashboard</span>
            </a>
         </li>

         {{-- MASTER DATA --}}
         @if (Auth::user()->role == "Marketing")
            <li>
               <button type="button" class="{{ request()->is(['masterdata/material','masterdata/customer','masterdata/supplier','masterdata/category','masterdata/measurement','masterdata/good']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-masterdata" data-collapse-toggle="dropdown-masterdata">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"></path>
                     <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"></path>
                     <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Master Data</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-masterdata" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ route('masterdata.customer') }}" class="{{ request()->is(['masterdata/customer']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Customer</a>
                     </li>
               </ul>
            </li>
         @elseif(Auth::user()->role == "QS")
            <li>
               <button type="button" class="{{ request()->is(['masterdata/material','masterdata/customer','masterdata/supplier','masterdata/category','masterdata/measurement','masterdata/good']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-masterdata" data-collapse-toggle="dropdown-masterdata">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"></path>
                     <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"></path>
                     <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Master Data</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-masterdata" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ route('masterdata.good') }}" class="{{ request()->is(['masterdata/good']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Barang</a>
                     </li>
               </ul>
            </li>
         @elseif(Auth::user()->role == "Produksi")
         @elseif(Auth::user()->role == "Logistik")
         @elseif(Auth::user()->role == "Purchasing")
            <li>
               <button type="button" class="{{ request()->is(['masterdata/material','masterdata/customer','masterdata/supplier','masterdata/category','masterdata/measurement','masterdata/good']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-masterdata" data-collapse-toggle="dropdown-masterdata">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"></path>
                     <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"></path>
                     <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Master Data</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-masterdata" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ route('masterdata.material') }}" class="{{ request()->is(['masterdata/material']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Material</a>
                     </li>
               </ul>
            </li>
         @else
            <li>
               <button type="button" class="{{ request()->is(['masterdata/material','masterdata/customer','masterdata/supplier','masterdata/category','masterdata/measurement','masterdata/good']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-masterdata" data-collapse-toggle="dropdown-masterdata">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"></path>
                     <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"></path>
                     <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Master Data</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-masterdata" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ route('masterdata.material') }}" class="{{ request()->is(['masterdata/material']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Material</a>
                     </li>
                     <li>
                        <a href="{{ route('masterdata.good') }}" class="{{ request()->is(['masterdata/good']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Barang</a>
                     </li>
                     <li>
                        <a href="{{ route('masterdata.customer') }}" class="{{ request()->is(['masterdata/customer']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Customer</a>
                     </li>
                     <li>
                        <a href="{{ route('masterdata.supplier') }}" class="{{ request()->is(['masterdata/supplier']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Supplier</a>
                     </li>
                     <li>
                        <a href="{{ route('masterdata.category') }}" class="{{ request()->is(['masterdata/category']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Kategori</a>
                     </li>
                     <li>
                        <a href="{{ route('masterdata.measurement') }}" class="{{ request()->is(['masterdata/measurement']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Satuan</a>
                     </li>
               </ul>
            </li>
         @endif
         

         {{-- SALES --}}
         @if (Auth::user()->role == "Marketing")
            <li>
               <button type="button" class="{{ request()->is(['inquiry','quotation','rabp','setgood','rabp1']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-penawaran" data-collapse-toggle="dropdown-penawaran">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path clip-rule="evenodd" fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Sales</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-penawaran" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ url('quotation') }}" class="{{ request()->is(['quotation']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Penawaran</a>
                     </li>
                     <li>
                        <a href="{{ url('rabp1') }}" class="{{ request()->is(['rabp1']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">RABP (New)</a>
                     </li>
               </ul>
            </li>
         @elseif(Auth::user()->role == "QS")
            <li>
               <button type="button" class="{{ request()->is(['inquiry','quotation','rabp','setgood','rabp1']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-penawaran" data-collapse-toggle="dropdown-penawaran">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path clip-rule="evenodd" fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Sales</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-penawaran" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ url('quotation') }}" class="{{ request()->is(['quotation']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Penawaran</a>
                     </li>
                     <li>
                        <a href="{{ url('rabp1') }}" class="{{ request()->is(['rabp1']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">RABP (New)</a>
                     </li>
               </ul>
            </li>
         @elseif(Auth::user()->role == "Direktur")
            <li>
               <button type="button" class="{{ request()->is(['inquiry','quotation','rabp','setgood','rabp1']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-penawaran" data-collapse-toggle="dropdown-penawaran">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path clip-rule="evenodd" fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Sales</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-penawaran" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ url('quotation') }}" class="{{ request()->is(['quotation']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Penawaran</a>
                     </li>
                     <li>
                        <a href="{{ url('rabp1') }}" class="{{ request()->is(['rabp1']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">RABP (New)</a>
                     </li>
               </ul>
            </li>
         @else
         @endif
         

         {{-- KONTRAK --}}
         @if (Auth::user()->role == "Marketing")
            <li>
               <a href="{{ url('contract') }}" class="{{ request()->is('contract') ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group">
                  <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path clip-rule="evenodd" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path></svg>
                  <span class="flex-1 ml-3 whitespace-nowrap font-medium">Kontrak</span>
               </a>
            </li>
         @elseif(Auth::user()->role == "QS")
         @elseif(Auth::user()->role == "Produksi")
            <li>
               <a href="{{ url('contract') }}" class="{{ request()->is('contract') ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group">
                  <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path clip-rule="evenodd" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path></svg>
                  <span class="flex-1 ml-3 whitespace-nowrap font-medium">Kontrak</span>
               </a>
            </li>
         @elseif(Auth::user()->role == "Direktur")
            <li>
               <a href="{{ url('contract') }}" class="{{ request()->is('contract') ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group">
                  <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path clip-rule="evenodd" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path></svg>
                  <span class="flex-1 ml-3 whitespace-nowrap font-medium">Kontrak</span>
               </a>
            </li>
         @else
         @endif


         {{-- PRODUKSI --}}
         @if (Auth::user()->role == "Produksi")
            <li>
               <button type="button" class="{{ request()->is(['production','qualitycontrol']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-produksi" data-collapse-toggle="dropdown-produksi">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path d="M12 .75a8.25 8.25 0 00-4.135 15.39c.686.398 1.115 1.008 1.134 1.623a.75.75 0 00.577.706c.352.083.71.148 1.074.195.323.041.6-.218.6-.544v-4.661a6.714 6.714 0 01-.937-.171.75.75 0 11.374-1.453 5.261 5.261 0 002.626 0 .75.75 0 11.374 1.452 6.712 6.712 0 01-.937.172v4.66c0 .327.277.586.6.545.364-.047.722-.112 1.074-.195a.75.75 0 00.577-.706c.02-.615.448-1.225 1.134-1.623A8.25 8.25 0 0012 .75z"></path>
                     <path clip-rule="evenodd" fill-rule="evenodd" d="M9.013 19.9a.75.75 0 01.877-.597 11.319 11.319 0 004.22 0 .75.75 0 11.28 1.473 12.819 12.819 0 01-4.78 0 .75.75 0 01-.597-.876zM9.754 22.344a.75.75 0 01.824-.668 13.682 13.682 0 002.844 0 .75.75 0 11.156 1.492 15.156 15.156 0 01-3.156 0 .75.75 0 01-.668-.824z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Produksi</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-produksi" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ url('production') }}" class="{{ request()->is(['production']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">List Produksi</a>
                     </li>
                     <li>
                        <a href="{{ url('qualitycontrol') }}" class="{{ request()->is(['qualitycontrol']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Quality Control</a>
                     </li>
               </ul>
            </li>
         @elseif(Auth::user()->role == "Direktur")
            <li>
               <button type="button" class="{{ request()->is(['production','qualitycontrol']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-produksi" data-collapse-toggle="dropdown-produksi">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path d="M12 .75a8.25 8.25 0 00-4.135 15.39c.686.398 1.115 1.008 1.134 1.623a.75.75 0 00.577.706c.352.083.71.148 1.074.195.323.041.6-.218.6-.544v-4.661a6.714 6.714 0 01-.937-.171.75.75 0 11.374-1.453 5.261 5.261 0 002.626 0 .75.75 0 11.374 1.452 6.712 6.712 0 01-.937.172v4.66c0 .327.277.586.6.545.364-.047.722-.112 1.074-.195a.75.75 0 00.577-.706c.02-.615.448-1.225 1.134-1.623A8.25 8.25 0 0012 .75z"></path>
                     <path clip-rule="evenodd" fill-rule="evenodd" d="M9.013 19.9a.75.75 0 01.877-.597 11.319 11.319 0 004.22 0 .75.75 0 11.28 1.473 12.819 12.819 0 01-4.78 0 .75.75 0 01-.597-.876zM9.754 22.344a.75.75 0 01.824-.668 13.682 13.682 0 002.844 0 .75.75 0 11.156 1.492 15.156 15.156 0 01-3.156 0 .75.75 0 01-.668-.824z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Produksi</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-produksi" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ url('production') }}" class="{{ request()->is(['production']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">List Produksi</a>
                     </li>
                     <li>
                        <a href="{{ url('qualitycontrol') }}" class="{{ request()->is(['qualitycontrol']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Quality Control</a>
                     </li>
               </ul>
            </li>
         @else
         @endif


         {{-- PENGELOLAAN --}}
         @if (Auth::user()->role == "Logistik")
            <li>
               <button type="button" class="{{ request()->is(['logistic','retur','logistic_good']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-pengelolaan" data-collapse-toggle="dropdown-pengelolaan">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path><path clip-rule="evenodd" fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Pengelolaan</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-pengelolaan" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ url('logistic') }}" class="{{ request()->is(['logistic']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Logistik Material</a>
                     </li>
                     <li>
                        <a href="{{ url('retur') }}" class="{{ request()->is(['retur']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Retur Material</a>
                     </li>
                     <li>
                        <a href="{{ url('logisticgood') }}" class="{{ request()->is(['logisticgood']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Logistik Barang</a>
                     </li>
               </ul>
            </li>
         @elseif (Auth::user()->role == "Direktur")
            <li>
               <button type="button" class="{{ request()->is(['logistic','retur','logistic_good']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-pengelolaan" data-collapse-toggle="dropdown-pengelolaan">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path><path clip-rule="evenodd" fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Pengelolaan</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-pengelolaan" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ url('logistic') }}" class="{{ request()->is(['logistic']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Logistik Material</a>
                     </li>
                     <li>
                        <a href="{{ url('retur') }}" class="{{ request()->is(['retur']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Retur Material</a>
                     </li>
                     <li>
                        <a href="{{ url('logisticgood') }}" class="{{ request()->is(['logisticgood']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Logistik Barang</a>
                     </li>
               </ul>
            </li>
         @else
         @endif


         {{-- PENGADAAN --}}
         @if (Auth::user()->role == "Purchasing")
            <li>
               <button type="button" class="{{ request()->is(['purchaserequest','purchaseorder','goodreceive']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-pengadaan" data-collapse-toggle="dropdown-pengadaan">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Pengadaan</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-pengadaan" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ url('purchaserequest') }}" class="{{ request()->is(['purchaserequest']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Purchase Request</a>
                     </li>
                     <li>
                        <a href="{{ url('purchaseorder') }}" class="{{ request()->is(['purchaseorder']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Purchase Order</a>
                     </li>
                     <li>
                        <a href="{{ url('goodreceive') }}" class="{{ request()->is(['goodreceive']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">GRN PO</a>
                     </li>
               </ul>
            </li>
         @elseif (Auth::user()->role == "Direktur")
            <li>
               <button type="button" class="{{ request()->is(['purchaserequest','purchaseorder','goodreceive']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group" aria-controls="dropdown-pengadaan" data-collapse-toggle="dropdown-pengadaan">
                     <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                     <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path></svg>
                     <span class="flex-1 ml-3 text-left whitespace-nowrap font-medium" sidebar-toggle-item>Pengadaan</span>
                     <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               </button>
               <ul id="dropdown-pengadaan" class="hidden py-2 space-y-2">
                     <li>
                        <a href="{{ url('purchaserequest') }}" class="{{ request()->is(['purchaserequest']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Purchase Request</a>
                     </li>
                     <li>
                        <a href="{{ url('purchaseorder') }}" class="{{ request()->is(['purchaseorder']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">Purchase Order</a>
                     </li>
                     <li>
                        <a href="{{ url('goodreceive') }}" class="{{ request()->is(['goodreceive']) ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg pl-11 hover:bg-zinc-800 hover:text-white group">GRN PO</a>
                     </li>
               </ul>
            </li>
         @else
         @endif


         {{-- PENGIRIMAN --}}
         @if (Auth::user()->role == "Logistik")
            <li>
               <a href="{{ url('delivery') }}" class="{{ request()->is('delivery') ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group">
                  <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path></svg>
                  <span class="flex-1 ml-3 whitespace-nowrap font-medium">Pengiriman</span>
               </a>
            </li>
         @elseif (Auth::user()->role == "Direktur")
            <li>
               <a href="{{ url('delivery') }}" class="{{ request()->is('delivery') ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group">
                  <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path></svg>
                  <span class="flex-1 ml-3 whitespace-nowrap font-medium">Pengiriman</span>
               </a>
            </li>
         @else
         @endif

         {{-- USERS --}}
         <li>
            <a href="{{ url('detailuser') }}" class="{{ request()->is('detailuser') ? 'bg-zinc-800 text-white' : '' }} border flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-zinc-800 hover:text-white group">
               <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
               <span class="flex-1 ml-3 whitespace-nowrap font-medium">Users</span>
            </a>
         </li>
         
         {{-- LOGOUT --}}
         <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="border flex items-center p-2 text-base font-normal rounded-lg hover:bg-zinc-800 hover:text-white group">
               <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"></path></svg>
               <span class="flex-1 ml-3 whitespace-nowrap font-medium">Logout</span>
               <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display:none;">
                    @csrf
                </form>
            </a>
         </li>
      </ul>
   </div>
</aside>

