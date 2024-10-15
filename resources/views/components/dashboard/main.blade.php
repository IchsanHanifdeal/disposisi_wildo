<x-main title="{{ $title }}" class="!p-0" full>

    <!-- Main Content Wrapper -->
    <div class="flex flex-col min-h-screen">
        <!-- Navbar -->
        @include('components.dashboard.navbar')
        
        <!-- Page Content -->
        <div class="flex-grow p-4 md:p-5 bg-stone-100 w-full">
            <div class="flex flex-col gap-5 md:gap-6 w-full">
                <!-- Dynamic Slot Content -->
                {{ $slot }}
            </div>
        </div>
        
        <!-- Footer -->
        @include('components.footer')
    </div>

</x-main>
