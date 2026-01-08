@props(['step'])

<div class="mb-10">
    <div class="flex items-center justify-between">

        @php
            $steps = [
                1 => 'Data Diri',
                2 => 'Program Studi',
                3 => 'Upload Berkas',
                4 => 'Selesai'
            ];
        @endphp

        @foreach($steps as $number => $label)
            <div class="flex-1 flex items-center">
                
                <div class="
                    w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold
                    {{ $step >= $number ? 'bg-blue-800 text-white' : 'bg-gray-300 text-gray-600' }}
                ">
                    {{ $number }}
                </div>

                <div class="ml-3 text-sm
                    {{ $step >= $number ? 'text-blue-800 font-semibold' : 'text-gray-500' }}">
                    {{ $label }}
                </div>

                @if(!$loop->last)
                    <div class="flex-1 h-1 mx-4
                        {{ $step > $number ? 'bg-blue-800' : 'bg-gray-300' }}">
                    </div>
                @endif

            </div>
        @endforeach

    </div>
</div>
