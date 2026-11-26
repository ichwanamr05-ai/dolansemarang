@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap justify-between items-center gap-3 mb-5">
        <a href="{{ route('wisata.index') }}" class="font-mono-code text-sm font-bold underline">
            ← Kembali ke Semua Destinasi
        </a>
        <div class="flex gap-2">
            <a href="{{ route('wisata.reviews', $destination->id) }}" class="brutal-btn bg-white text-xs font-bold px-3 py-2">
                Lihat Semua Ulasan ({{ $destination->reviews->count() }})
            </a>
            <a href="{{ route('review.create', $destination->id) }}" class="brutal-btn bg-[#FF66C4] text-xs font-bold px-3 py-2">
                + Form Review Lengkap
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="brutal-box bg-white overflow-hidden mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="border-b-3 md:border-b-0 md:border-r-3 border-black bg-gray-100 min-h-[320px]">
                <img src="{{ $destination->image_url ?: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=900&q=80' }}"
                     alt="{{ $destination->name }}" class="w-full h-full object-cover">
            </div>

            <div class="p-6 md:p-8 flex flex-col justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="bg-[#FFDE59] border-2 border-black px-3 py-0.5 text-xs font-bold uppercase">
                            {{ $destination->category }}
                        </span>
                        <span class="bg-black text-[#CCFF00] px-3 py-0.5 text-xs font-mono-code font-bold">
                            {{ $destination->price_range }}
                        </span>
                        <span class="bg-[#FFF9DB] border-2 border-black px-2.5 py-0.5 text-xs font-mono-code font-bold">
                            ⏰ {{ $destination->best_time }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $destination->name }}</h1>
                    <p class="font-mono-code text-xs text-gray-700 mb-3">
                        📍 {{ $destination->area ?: 'Semarang' }} {{ $destination->address ? '— ' . $destination->address : '' }}
                    </p>

                    <div class="bg-[#FFFDF5] border-2 border-black p-3 mb-4 font-mono-code text-xs space-y-1">
                        <p><strong>Jam Buka:</strong> {{ $destination->opening_hours ?: 'Cek ulasan terbaru pengunjung' }}</p>
                        <p><strong>Kategori Budget:</strong> {{ $destination->budget_tier }}</p>
                    </div>

                    <p class="text-base leading-relaxed text-gray-800 mb-6">
                        {{ $destination->description }}
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="brutal-box bg-[#A6FAFF] p-4 flex items-center justify-between">
                        <div>
                            <span class="block font-mono-code text-xs uppercase font-bold">Skor Komunitas</span>
                            <span class="text-3xl font-bold">
                                {{ $destination->reviews->count() > 0 ? number_format($avgRating, 1) : '0.0' }} / 5.0 ★
                            </span>
                        </div>
                        <span class="bg-white border-2 border-black px-3 py-1 font-mono-code text-xs font-bold">
                            Dari {{ $destination->reviews->count() }} Ulasan
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <form action="{{ route('wishlist.toggle', $destination->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="route">
                            <button type="submit" class="brutal-btn {{ $isInRoute ? 'bg-[#FF66C4]' : 'bg-[#CCFF00]' }} text-xs font-bold px-3.5 py-2">
                                {{ $isInRoute ? '✓ Ada di Rute Hari Ini' : '+ Masukkan Rute Hari Ini' }}
                            </button>
                        </form>

                        <form action="{{ route('wishlist.toggle', $destination->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="wishlist">
                            <button type="submit" class="brutal-btn {{ $isWishlisted ? 'bg-[#FFDE59]' : 'bg-white' }} text-xs font-bold px-3.5 py-2">
                                {{ $isWishlisted ? '★ Di Wishlist' : '+ Wishlist' }}
                            </button>
                        </form>

                        <form action="{{ route('wishlist.toggle', $destination->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="visited">
                            <button type="submit" class="brutal-btn {{ $isVisited ? 'bg-black text-white' : 'bg-white' }} text-xs font-bold px-3.5 py-2">
                                {{ $isVisited ? '✓ Sudah Dikunjungi' : 'Tandai Dikunjungi' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Skor 4 Aspek -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        @foreach($aspectAverages as $label => $score)
            <div class="brutal-box bg-white p-4">
                <span class="font-mono-code text-xs text-gray-600 block">{{ $label }}</span>
                <span class="text-2xl font-bold">{{ $destination->reviews->count() > 0 ? number_format($score, 1) : '-' }} / 5.0</span>
            </div>
        @endforeach
    </div>

    <!-- Section Review & Form -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-5">
            <div class="brutal-box bg-[#FFDE59] p-6 sticky top-24">
                <h2 class="text-2xl font-bold mb-1">Drop Review Jujurmu ✍️</h2>
                <p class="font-mono-code text-xs mb-4">Bagikan skor & kondisi lapangan terbaru!</p>

                <form action="{{ route('review.store', $destination->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="block text-xs font-bold mb-1">Nama / Panggilanmu *</label>
                            <input type="text" name="user_name" required placeholder="Misal: Rara"
                                class="w-full bg-white border-3 border-black p-2 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold mb-1">Kondisi Lapangan</label>
                            <select name="crowd_status" class="w-full bg-white border-3 border-black p-2 text-xs font-bold">
                                <option value="Sepi / Nyaman">Sepi / Nyaman</option>
                                <option value="Ramai Lancar">Ramai Lancar</option>
                                <option value="Padat / Antre">Padat / Antre</option>
                                <option value="Ada Update Harga/Jam">Ada Update Harga/Jam</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="block text-xs font-bold mb-1">Rating Utama *</label>
                            <select name="rating" required class="w-full bg-white border-3 border-black p-2 text-xs font-bold">
                                <option value="5">★★★★★ (5/5)</option>
                                <option value="4">★★★★☆ (4/5)</option>
                                <option value="3">★★★☆☆ (3/5)</option>
                                <option value="2">★★☆☆☆ (2/5)</option>
                                <option value="1">★☆☆☆☆ (1/5)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold mb-1">Waktu Kunjungan</label>
                            <input type="text" name="visit_period" placeholder="Misal: Nov 2026"
                                class="w-full bg-white border-3 border-black p-2 text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block font-mono-code text-[11px] font-bold mb-0.5">Pemandangan (1-5)</label>
                            <input type="number" name="rating_scenery" min="1" max="5" value="5"
                                class="w-full bg-white border-2 border-black p-1.5 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block font-mono-code text-[11px] font-bold mb-0.5">Akses (1-5)</label>
                            <input type="number" name="rating_access" min="1" max="5" value="4"
                                class="w-full bg-white border-2 border-black p-1.5 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block font-mono-code text-[11px] font-bold mb-0.5">Kebersihan (1-5)</label>
                            <input type="number" name="rating_cleanliness" min="1" max="5" value="4"
                                class="w-full bg-white border-2 border-black p-1.5 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block font-mono-code text-[11px] font-bold mb-0.5">Fasilitas (1-5)</label>
                            <input type="number" name="rating_facilities" min="1" max="5" value="4"
                                class="w-full bg-white border-2 border-black p-1.5 text-xs font-bold">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1">Link Foto Ulasan (Opsional)</label>
                        <input type="url" name="photo_url" placeholder="https://..."
                            class="w-full bg-white border-3 border-black p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1">Ulasan & Tips *</label>
                        <textarea name="comment" rows="3" required
                            placeholder="Gimana suasananya, makanannya, atau spot fotonya?"
                            class="w-full bg-white border-3 border-black p-2.5 text-sm"></textarea>
                    </div>

                    <button type="submit" class="brutal-btn bg-[#FF66C4] w-full py-2.5 font-bold">
                        Kirim Ulasan →
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-7 space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold">Kata Pengunjung ({{ $destination->reviews->count() }})</h2>
                <a href="{{ route('wisata.reviews', $destination->id) }}" class="font-mono-code text-xs font-bold underline">
                    Filter & breakdown rating ›
                </a>
            </div>

            @forelse($destination->reviews as $rev)
                <div class="brutal-box bg-white p-5">
                    <div class="flex justify-between items-start gap-2 mb-2">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-bold text-lg">{{ $rev->user_name }}</span>
                                @if($rev->crowd_status)
                                    <span class="bg-[#A6FAFF] border border-black px-2 py-0.5 text-[11px] font-mono-code font-bold">
                                        {{ $rev->crowd_status }}
                                    </span>
                                @endif
                            </div>
                            <span class="font-mono-code text-xs text-gray-500 block">
                                {{ $rev->visit_period ? $rev->visit_period . ' • ' : '' }}{{ $rev->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <span class="bg-[#CCFF00] border-2 border-black px-2.5 py-1 text-sm font-bold">
                            {{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', 5 - $rev->rating) }}
                        </span>
                    </div>

                    <p class="text-gray-800 text-sm leading-relaxed mb-3">{{ $rev->comment }}</p>

                    @if($rev->photo_url)
                        <img src="{{ $rev->photo_url }}" alt="Foto ulasan {{ $rev->user_name }}"
                             class="w-40 h-40 object-cover border-2 border-black mb-3">
                    @endif

                    <div class="pt-2 border-t-2 border-dashed border-gray-200 flex justify-between items-center gap-2">
                        <span class="font-mono-code text-xs text-gray-600">
                            {{ $rev->helpful_count }} orang merasa terbantu
                        </span>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('review.helpful', $rev->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="brutal-btn bg-[#FFF9DB] px-2.5 py-1 text-xs font-bold">
                                    👍 Terbantu
                                </button>
                            </form>
                            <form action="{{ route('review.report', $rev->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="font-mono-code text-[11px] text-gray-500 underline hover:text-black">
                                    Laporkan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="brutal-box bg-white p-8 text-center">
                    <p class="font-bold text-lg">Belum ada ulasan di sini.</p>
                    <p class="font-mono-code text-xs text-gray-600">Tulis ulasan pertamamu di kotak sebelah kiri!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection