@extends('layouts.app')

@section('content')
    <style>
        .interest-checkbox:checked + .interest-card {
            background-color: #FF66C4;
            color: #000000;
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px #000000;
        }
        .interest-checkbox:checked + .interest-card .interest-badge {
            background-color: #CCFF00;
            color: #000000;
        }
    </style>

    <div class="max-w-3xl mx-auto brutal-box bg-white p-6 md:p-10">
        <span class="bg-[#FFDE59] border-2 border-black px-3 py-1 text-xs font-mono-code font-bold uppercase">
            Personalisasi Dolan Semarang
        </span>
        <h1 class="text-3xl md:text-4xl font-bold mt-3 mb-2">Halo, pejalan!</h1>
        <p class="text-gray-700 mb-6">
            Klik kategori wisata Semarang yang paling kamu suka — rekomendasi di Homepage akan menyesuaikan.
        </p>

        <form action="{{ route('onboarding.save') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                @foreach($categories as $cat)
                    @php $checked = in_array($cat, $selectedInterests); @endphp
                    <label class="cursor-pointer block select-none">
                        <input
                            type="checkbox"
                            name="interests[]"
                            value="{{ $cat }}"
                            {{ $checked ? 'checked' : '' }}
                            class="interest-checkbox sr-only"
                        >
                        <div class="interest-card brutal-box p-4 text-center bg-white transition-all flex flex-col items-center justify-center gap-1.5">
                            <span class="interest-badge font-mono-code text-[10px] font-bold px-2 py-0.5 border border-black bg-[#FFFDF5]">
                                KLIK PILIH
                            </span>
                            <span class="font-bold text-base">#{{ $cat }}</span>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4">
                <button type="submit" name="skip" value="1" class="font-mono-code text-sm underline font-bold cursor-pointer">
                    Lewati dulu
                </button>
                <button type="submit" class="brutal-btn bg-[#CCFF00] px-6 py-3 font-bold text-base cursor-pointer">
                    Selesai — Buka Homepage-ku →
                </button>
            </div>
        </form>
    </div>
@endsection