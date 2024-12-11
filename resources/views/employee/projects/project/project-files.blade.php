<section class="mt-14">
    <h1 class="font-bold text-xl">مرفقات</h1>

    <div class="grid mt-[2.9rem] gap-y-5 pb-52">
        @foreach($files as $file)
        @php
            $fileName = $file->file_name ?? '';
            $filePath = $file->file ?? '';
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
            $icon = match($fileType) {
                'pdf' => 'pdf.png',
                'ai' => 'Illustrator.png',
                'jpg', 'png' => 'Image.png',
                'mp4', 'mov' => 'video.png',
                'doc', 'docx' => 'docx.png',
                'xlsx' => 'xlsx.png',
                'pptx' => 'pptx.png',
                default => '', // Replace with a generic file icon if needed
            };
        @endphp

        <small class="font-normal text-base">{{ $fileName }}</small>
        <div class="w-[52rem] h-[4.1rem] bg-white rounded flex justify-between">
            <div class="flex gap-x-5 p-4 items-center">
                @if($icon !== '')
                <img src="{{ asset("assets/icons/$icon") }}" class="w-[1.4rem] h-7" alt="{{ $fileType }}" />
                @endif
                <p class="font-normal text-base">{{ $fileName }}</p>
            </div>
            <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $filePath }}" download="">عرض الملف</a>
        </div>
        @endforeach
    </div>
</section>