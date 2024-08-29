<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kai's Frozen Store</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css"
    rel="stylesheet"/>

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
     @wireUiScripts
    @livewireStyles
</head>

<body class="font-sans antialiased bg-fuchsia-700  relative">
    <x-notifications position="top-right" />
    <x-dialog z-index="z-50" blur="md" align="center" />
    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
        aria-controls="sidebar-multi-level-sidebar" type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="sidebar-multi-level-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-fuchsia-900 ">
            <ul class="space-y-2 font-medium ">
                <a href="ds">
                    <div class="flex  flex-col items-center h-full px-3  overflow-y-auto  ">
                        <div class="">
                            <img src="{{ asset('images/steak.png') }}" alt="Violation Photo" class="w-12 h-12 ">
                        </div>
                          <div class="text-center mt-2">
                             <label for="" class="font-black text-white text-xl">Kai's Frozen Store</label>
                          </div>
                     </div>
                </a>
                <li>
                    <a href="Admindashboard"
                        class="flex items-center p-2 text-white hover:text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="ri-dashboard-fill"></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('add-products') }}"   class="flex items-center p-2 text-white hover:text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="ri-add-box-fill"></i>
                       <span class="flex-1 ms-3 whitespace-nowrap">Add Products</span>

                    </a>
                 </li>
                 {{-- <li>
                    <a href=""   class="flex items-center p-2 text-white hover:text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="ri-discount-percent-fill"></i>
                       <span class="flex-1 ms-3 whitespace-nowrap">Add Promos</span>

                    </a>
                 </li> --}}

                 <li>
                    <a href="{{ route('add-rider') }}"   class="flex items-center p-2 text-white hover:text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="ri-motorbike-fill"></i>
                       <span class="flex-1 ms-3 whitespace-nowrap">Rider</span>

                    </a>
                 </li>

                 <li>
                    <a href="{{ route('pos') }}"   class="flex items-center p-2 text-white hover:text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="ri-motorbike-fill"></i>
                       <span class="flex-1 ms-3 whitespace-nowrap">POS</span>

                    </a>
                 </li>

                 <li>
                    <a href="{{ route('orders') }}"   class="flex items-center p-2 text-white hover:text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="ri-file-list-fill"></i>
                       <span class="flex-1 ms-3 whitespace-nowrap">Order Lists </span>

                    </a>
                 </li>
                 <li>
                    <a href="{{ route('assignorders') }}"   class="flex items-center p-2 text-white hover:text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="ri-file-list-fill"></i>
                       <span class="flex-1 ms-3 whitespace-nowrap">Assign Orders </span>

                    </a>
                 </li>

                 <li>
                    <a href=""   class="flex items-center p-2 text-white hover:text-black rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="ri-history-fill"></i>
                       <span class="flex-1 ms-3 whitespace-nowrap">Transaction History</span>

                    </a>
                 </li>







            </ul>


        </div>


    </aside>


    <div class="flex justify-end text-black  mr-10 mt-4">
        <div>
            <x-dropdown>
                <x-slot name="trigger">

                    <x-avatar xs squared src="https://cdn-icons-png.flaticon.com/512/6897/6897018.png" class="w-12 h-12"/>
                </x-slot>

                <x-dropdown.item label="{{ Auth::user()->name }}" />
                <x-dropdown.item separator label="Logout" href="{{  route('logout') }}"/>
            </x-dropdown>

        </div>
      </div>
    <div class="p-4 sm:ml-64">
        <div class="p-4  border-gray-200  rounded-lg dark:border-gray-700 ">
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>



</body>

</html>
