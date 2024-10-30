<div id="errorMessage" class="error-message-overlay absolute z-10 gap-y-16 bg-white w-[32.6rem] h-[32rem] rounded-md grid place-items-center shadow-2xl">
    <img src="{{ asset("assets/icons/success.png") }}" class="w-[9.2rem] h-[9.2rem]" alt="error-icon" />
    <p class="font-bold text-2xl">{{ session('success_message') }}</p>
</div>

<style>
    .absolute {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        top: 50%;
        transform: translateY(-50%);
    }

    .error-message-overlay {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        top: 50%;
        transform: translateY(-50%);
        transition: opacity 1s ease;
        /* Smooth fade-out effect */
    }
</style>

<script>
    // Hide error message after 4 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.opacity = '0'; // Start fade-out effect
                setTimeout(() => errorMessage.remove(), 1000); // Remove from DOM after fade-out
            }, 4000); // Delay of 4 seconds
        }
    });
</script>