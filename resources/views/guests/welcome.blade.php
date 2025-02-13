@extends('layouts.guest')

@section('content')
<div class="container mx-auto p-4 bg-primary-light h-screen flex flex-col justify-center items-center" style="background-image: url('/img/carousel-2.jpg'); background-size: cover; background-position: center;">
    <div class="max-w-sm bg-blue-900 text-white rounded-lg shadow-xl mx-auto mt-20">
        <div class="p-4">
            <div class="flex flex-col items-center text-center space-y-2">
                <div class="text-sm text-gray-300 uppercase tracking-wider">
                    Selamat Datang
                </div>
                <div id="guest-name" class="text-xl font-semibold animate-fade-in">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const guestNameElement = document.getElementById('guest-name');

        // Function to update guest name with animation
        const updateGuestName = (name) => {
            guestNameElement.classList.remove('animate-fade-in');
            void guestNameElement.offsetWidth; // Trigger reflow to restart animation
            guestNameElement.textContent = name;
            guestNameElement.classList.add('animate-fade-in');
        };

        // Check if guest name is already in localStorage
        const guestName = localStorage.getItem('guestName');
        if (guestName) {
            updateGuestName(`Yth. Saudara/Saudari ${guestName} Beserta Keluarga`);
        }

        // Listen for storage changes
        window.addEventListener('storage', (event) => {
            if (event.key === 'guestName') {
                updateGuestName(`Yth. Saudara/Saudari ${event.newValue} Beserta Keluarga`);
            }
        });

        // Listen for messages from other tabs
        window.addEventListener('message', (event) => {
            if (event.data.type === 'GUEST_UPDATED') {
                updateGuestName(`Yth. Saudara/Saudari ${event.data.guestName} Beserta Keluarga`);
            }
        });
    });
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>
@endsection
