<div id="errorMessage" class="error-message-overlay text-balance text-center flex flex-col font-['Tajawal'] w-72 h-72 left-12 absolute z-10 bg-white rounded-md place-items-center shadow-2xl items-center justify-center top-1/2 -translate-y-1/2
2xl:left-[38%] 2xl:w-[32.6rem] 2xl:h-[32rem]
xl:left-1/3 xl:w-[32.6rem] xl:h-[32rem]
lg:left-64 lg:w-[32.6rem] lg:h-[32rem]
md:w-96 md:h-96 md:left-80
max-md:left-20">
    <img src="{{ asset("assets/icons/error-icon.png") }}" class="w-[9.2rem]" alt="error-icon" />
    <p class="font-bold text-2xl text-balance">{{ session('error_message') }}</p>
</div>

<style>
    .error-message-overlay {
        transition: opacity 1s ease;
    }
</style>

@push('scripts')
<script>
    // Hide error message after 4 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.opacity = '0'; // Start fade-out effect
                setTimeout(() => errorMessage.remove(), 1000); // Remove from DOM after fade-out
            }, 2000); // Delay of 4 seconds
        }
    });
</script>
@endpush