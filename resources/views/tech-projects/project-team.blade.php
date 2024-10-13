<section class="mt-4">
    <h1 class="font-bold text-xl">فريق العمل</h1>

    <div class="grid grid-cols-2 gap-x-12">
        @foreach($team as $member)
        <div class="grid gap-y-5 mt-6">
            <p class="font-normal text-base">{{ $member->role_name }}</p>
            <input type="text" placeholder="{{ $member->m_name }}" class="input font-normal text-base" disabled />
        </div>
        @endforeach
    </div>
</section>