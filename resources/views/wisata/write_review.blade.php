@extends('layouts.app')

@section('content')
    <a href="{{ route('wisata.show', $destination->id) }}" class="font-mono-code text-sm font-bold underline inline-block mb-4">
        ← Batal & Kembali ke {{ $destination->name }}
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 brutal-box bg-white p-6 md:p-8">
            <span class="bg-[#CCFF00] border-2 border-black px-2.5 py-0.5 text-xs font-mono-code font-bold">
                +50 POIN KONTRIBUTOR
            </span>
            <h1 class="text-3xl font-bold mt-2 mb-6">Bagikan Pengalamanmu di {{ $destination->name }}</h1>

            <form action="{{ route('review.store', $destination->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-sm mb-1">Nama Pengulas *</label>
                        <input type="text" name="user_name" required placeholder="Nama panggilanmu"
                            class="w-full border-3 border-black p-2.5">
                    </div>
                    <div>
                        <label class="block font-bold text-sm mb-1">Periode Kunjungan</label>
                        <input type="text" name="visit_period" placeholder="Misal: November 2026"
                            class="w-full border-3 border-black p-2.5">
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 bg-[#FFF9DB] border-3 border-black p-4">
                    <div>
                        <label class="block font-mono-code text-xs font-bold mb-1">Keseluruhan *</label>
                        <select name="rating" class="w-full border-2 border-black bg-white p-2 font-bold text-sm">
                            <option value="5">5 ★</option>
                            <option value="4">4 ★</option>
                            <option value="3">3 ★</option>
                            <option value="2">2 ★</option>
                            <option value="1">1 ★</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-mono-code text-xs font-bold mb-1">Pemandangan</label>
                        <input type="number" name="rating_scenery" min="1" max="5" value="5" class="w-full border-2 border-black bg-white p-2 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block font-mono-code text-xs font-bold mb-1">Akses</label>
                        <input type="number" name="rating_access" min="1" max="5" value="4" class="w-full border-2 border-black bg-white p-2 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block font-mono-code text-xs font-bold mb-1">Kebersihan</label>
                        <input type="number" name="rating_cleanliness" min="1" max="5" value="4" class="w-full border-2 border-black bg-white p-2 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block font-mono-code text-xs font-bold mb-1">Fasilitas</label>
                        <input type="number" name="rating_facilities" min="1" max="5" value="4" class="w-full border-2 border-black bg-white p-2 text-sm font-bold">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-sm mb-1">Link Foto Perjalanan (URL)</label>
                    <input type="url" name="photo_url" placeholder="https://..." class="w-full border-3 border-black p-2.5">
                </div>

                <div>
                    <label class="block font-bold text-sm mb-1">Ceritakan Pengalamanmu *</label>
                    <textarea name="comment" rows="5" required
                        placeholder="Tulis detail praktis: jam terbaik datang, harga tiket/makan, rute, dan tips..."
                        class="w-full border-3 border-black p-3"></textarea>
                </div>

                <button type="submit" class="brutal-btn bg-[#FF66C4] w-full py-3 font-bold text-base">
                    Kirim Review →
                </button>
            </form>
        </div>

        <div class="lg:col-span-4">
            <div class="brutal-box bg-[#A6FAFF] p-6 space-y-3">
                <h2 class="text-xl font-bold">Tips Review Bermanfaat</h2>
                <p class="text-sm bg-white border-2 border-black p-3"><strong>1. Detail praktis:</strong> cantumkan jam buka, kisaran biaya, dan rute dari area Semarang.</p>
                <p class="text-sm bg-white border-2 border-black p-3"><strong>2. Foto asli:</strong> sertakan foto suasana lapangan agar traveler lain punya gambaran nyata.</p>
                <p class="text-sm bg-white border-2 border-black p-3"><strong>3. Jujur & spesifik:</strong> ulasan spesifik jauh lebih membantu dibanding komentar umum.</p>
            </div>
        </div>
    </div>
@endsection