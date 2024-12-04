<div id="errorMessage" class="error-message-overlay text-balance text-center flex flex-col font-['Tajawal'] w-72 h-72 absolute left-10 z-10 bg-white rounded-md place-items-center shadow-2xl items-center justify-center top-1/2 -translate-y-1/2
desktop:left-[50rem]
laptop:left-[25rem]">
    <img src="{{ asset("assets/icons/success.png") }}" class="w-[9.2rem] h-[9.2rem]" alt="error-icon" />
    <p class="font-bold text-2xl">{{ session('success_message') }}</p>
</div>

<style>
    .error-message-overlay {
        transition: opacity 1s ease;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.opacity = '0';
                setTimeout(() => errorMessage.remove(), 1000);
            }, 1000);
        }
    });
</script>
@endpush