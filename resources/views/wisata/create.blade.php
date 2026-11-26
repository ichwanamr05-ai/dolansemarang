@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('wisata.index') }}" class="inline-block font-mono-code text-sm font-bold mb-4 underline">
            ← Kembali ke Daftar Wisata
        </a>

        <div class="brutal-box bg-white p-6 md:p-8">
            <span class="bg-[#CCFF00] border-2 border-black px-2.5 py-1 text-xs font-mono-code font-bold uppercase">
                Kontribusi Komunitas
            </span>
            <h1 class="text-3xl font-bold mt-2 mb-6">Rekomendasiin Destinasi di Semarang</h1>

            <form action="{{ route('wisata.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-bold mb-1">Nama Tempat Wisata *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Klenteng Sam Poo Kong atau Lawang Sewu"
                        class="w-full border-3 border-black p-3 focus:outline-none focus:bg-[#FFF9DB]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold mb-1">Kategori *</label>
                        <select name="category" required class="w-full border-3 border-black p-3 bg-white font-bold">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Area / Wilayah Semarang *</label>
                        <select name="area" required class="w-full border-3 border-black p-3 bg-white font-bold">
                            @foreach($areas as $ar)
                                <option value="{{ $ar }}" {{ old('area') == $ar ? 'selected' : '' }}>{{ $ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold mb-1">Teks Harga Tiket *</label>
                        <input type="text" name="price_range" value="{{ old('price_range') }}" required
                            placeholder="Misal: Rp 20.000"
                            class="w-full border-3 border-black p-3 focus:outline-none focus:bg-[#FFF9DB]">
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Kategori Budget *</label>
                        <select name="budget_tier" required class="w-full border-3 border-black p-3 bg-white text-sm font-bold">
                            @foreach($budgetTiers as $bt)
                                <option value="{{ $bt }}">{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Estimasi Angka (Rp)</label>
                        <input type="number" name="estimated_cost" value="{{ old('estimated_cost', 20000) }}" min="0" step="1000"
                            class="w-full border-3 border-black p-3 focus:outline-none focus:bg-[#FFF9DB]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold mb-1">Waktu Terbaik Berkunjung *</label>
                        <select name="best_time" required class="w-full border-3 border-black p-3 bg-white font-bold">
                            @foreach($bestTimes as $time)
                                <option value="{{ $time }}">{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Jam Operasional</label>
                        <input type="text" name="opening_hours" value="{{ old('opening_hours') }}"
                            placeholder="Misal: 08.00 - 21.00 WIB"
                            class="w-full border-3 border-black p-3 focus:outline-none focus:bg-[#FFF9DB]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-1">Alamat Lengkap</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                        placeholder="Contoh: Jl. Pemuda No.160, Sekayu, Kec. Semarang Tengah"
                        class="w-full border-3 border-black p-3 focus:outline-none focus:bg-[#FFF9DB]">
                </div>

                <div>
                    <label class="block font-bold mb-1">Link Foto Tempat (URL Gambar)</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}"
                        placeholder="https://..."
                        class="w-full border-3 border-black p-3 focus:outline-none focus:bg-[#FFF9DB]">
                </div>

                <div>
                    <label class="block font-bold mb-1">Kenapa Tempat Ini Layak Dikunjungi? *</label>
                    <textarea name="description" rows="4" required
                        placeholder="Ceritain vibe-nya, jam terbaik datang, atau tips parkir..."
                        class="w-full border-3 border-black p-3 focus:outline-none focus:bg-[#FFF9DB]">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="brutal-btn bg-[#FFDE59] w-full py-3 font-bold text-lg">
                    Posting Destinasi Sekarang ✦
                </button>
            </form>
        </div>
    </div>
@endsection