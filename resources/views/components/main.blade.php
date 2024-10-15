<!DOCTYPE html>
<html lang="en" data-theme="dim">

<head>
    @include('components.head')
    <style>
        .toast {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .toast-show {
            opacity: 1;
        }
    </style>
</head>

<body class="flex flex-col mx-auto min-h-screen">
    <main class="{{ $class ?? 'p-4' }}" role="main">
        {{ $slot }}

        <!-- Toast Container at the top-right -->
        <div id="toast-container" class="fixed top-5 right-5 z-50"></div>

        <script>
            function showToast(message, type) {
                const toastContainer = document.getElementById('toast-container');
                const toast = document.createElement('div');
                
                // Add Tailwind CSS and DaisyUI classes for modern styling
                toast.classList.add('toast', `toast-${type}`, 'bg-white', 'shadow-lg', 'rounded-lg', 'p-4', 'flex', 'items-center', 'justify-between', 'mb-4', 'max-w-sm', 'w-full', 'relative', 'transition', 'duration-500', 'transform', 'hover:scale-105');

                // Toast inner HTML structure with close button
                toast.innerHTML = `
                    <div class="text-sm text-gray-800">${message}</div>
                    <button onclick="this.parentElement.remove()" class="text-gray-400 focus:outline-none hover:text-gray-600 absolute top-0 right-0 mt-3 mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;

                // Append the toast to the container
                toastContainer.appendChild(toast);

                // Show the toast with animation
                setTimeout(() => {
                    toast.classList.add('toast-show');
                }, 100);

                // Remove the toast after 5 seconds
                setTimeout(() => {
                    toast.classList.remove('toast-show');
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }, 5000);
            }

            // Function to play delete audio
            function playDeleteAudio() {
                var audio = new Audio('{{ asset('success.mp3') }}'); // Update this path to your audio file
                audio.play().catch(function(error) {
                    console.log('Audio playback failed:', error);
                });
            }

            // Example usage of session to show toast
            @if (session('toast'))
                showToast('{{ session('toast.message') }}', '{{ session('toast.type') }}');
                @if(session('toast.playAudio'))
                    playDeleteAudio(); // Play audio if the delete action was successful
                @endif
            @endif
        </script>

    </main>
</body>

</html>
