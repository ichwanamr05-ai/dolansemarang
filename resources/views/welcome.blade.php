@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto brutal-box bg-white p-6 md:p-10">
        <span class="bg-[#FFDE59] border-2 border-black px-3 py-1 text-xs font-mono-code font-bold uppercase">
            Personalisasi Dolan Semarang
        </span>
        <h1 class="text-3xl md:text-4xl font-bold mt-3 mb-2">Halo, pejalan!</h1>
        <p class="text-gray-700 mb-6">
            Pilih kategori wisata Semarang yang paling kamu suka — rekomendasi di Homepage akan menyesuaikan.
        </p>

        <form action="{{ route('onboarding.save') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                @foreach($categories as $cat)
                    @php $checked = in_array($cat, $selectedInterests); @endphp
                    <label class="cursor-pointer block">
                        <input type="checkbox" name="interests[]" value="{{ $cat }}" {{ $checked ? 'checked' : '' }} class="peer sr-only">
                        <div class="brutal-box p-4 text-center font-bold bg-white peer-checked:bg-[#FF66C4] peer-checked:text-black transition">
                            #{{ $cat }}
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4">
                <button type="submit" name="skip" value="1" class="font-mono-code text-sm underline font-bold">
                    Lewati dulu
                </button>
                <button type="submit" class="brutal-btn bg-[#CCFF00] px-6 py-3 font-bold text-base">
                    Selesai — Buka Homepage-ku →
                </button>
            </div>
        </form>
    </div>
@endsection