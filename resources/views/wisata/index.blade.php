@extends('layouts.app')

@section('content')
    <!-- Hero Banner -->
    <div class="brutal-box bg-[#A6FAFF] p-6 md:p-8 mb-8">
        <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
            <span class="bg-[#FF66C4] border-2 border-black px-3 py-1 text-xs font-mono-code font-bold uppercase rotate-1">
                ★ Direktori & Review Wisata Semarang
            </span>
            <div class="flex flex-wrap items-center gap-2">
                @if(!empty($interests))
                    <span class="bg-[#CCFF00] border-2 border-black px-3 py-1 text-xs font-mono-code font-bold">
                        Minat: {{ implode(' • ', $interests) }}
                    </span>
                @endif
                <a href="{{ route('wisata.random', ['category' => request('category')]) }}"
                   class="brutal-btn bg-[#FFDE59] px-3 py-1 text-xs font-mono-code font-bold">
                    🎲 Bingung? Acak Spot!
                </a>
            </div>
        </div>

        <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-3">
            Mau Dolan ke Mana Hari Ini di Semarang?
        </h1>
        <p class="text-base md:text-lg max-w-2xl mb-6">
            Cek rating asli, bocoran harga tiket, kondisi lapangan terbaru, dan foto pengunjung sebelum berangkat biar nggak zonk!
        </p>

        <form action="{{ route('wisata.index') }}" method="GET" class="space-y-3">
            <div class="flex flex-col md:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari tempat, area, atau kata di ulasan (misal: parkir luas, sunset, Kota Lama)..."
                    class="flex-1 bg-white border-3 border-black px-4 py-3 font-medium focus:outline-none focus:bg-[#FFF9DB]">

                <button type="submit" class="brutal-btn bg-[#CCFF00] font-bold px-6 py-3">
                    Cari Spot →
                </button>
            </div>

            <!-- Filter Praktis Khas Semarang -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2.5">
                <select name="category" class="bg-white border-3 border-black px-3 py-2 text-xs font-bold">
                    <option value="">Kategori: Semua</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <select name="area" class="bg-white border-3 border-black px-3 py-2 text-xs font-bold">
                    <option value="">Area: Semua Semarang</option>
                    @foreach($areas as $ar)
                        <option value="{{ $ar }}" {{ request('area') == $ar ? 'selected' : '' }}>{{ $ar }}</option>
                    @endforeach
                </select>

                <select name="budget_tier" class="bg-white border-3 border-black px-3 py-2 text-xs font-bold">
                    <option value="">Budget: Semua</option>
                    @foreach($budgetTiers as $bt)
                        <option value="{{ $bt }}" {{ request('budget_tier') == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                    @endforeach
                </select>

                <select name="best_time" class="bg-white border-3 border-black px-3 py-2 text-xs font-bold">
                    <option value="">Waktu: Kapan Saja</option>
                    @foreach($bestTimes as $time)
                        <option value="{{ $time }}" {{ request('best_time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                    @endforeach
                </select>

                <select name="sort" class="bg-white border-3 border-black px-3 py-2 text-xs font-bold">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Urut: Terbaru</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                    <option value="terbanyak" {{ request('sort') == 'terbanyak' ? 'selected' : '' }}>Ulasan Terbanyak</option>
                    <option value="hemat" {{ request('sort') == 'hemat' ? 'selected' : '' }}>Paling Hemat</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Quick Category Pills -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-8">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('wisata.index') }}"
               class="brutal-btn px-3 py-1.5 text-sm font-bold {{ !request('category') ? 'bg-black text-white' : 'bg-white' }}">
                Semua ({{ $destinations->count() }})
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('wisata.category', $cat) }}"
                   class="brutal-btn px-3 py-1.5 text-sm font-bold bg-white hover:bg-[#FFDE59]">
                    #{{ $cat }} →
                </a>
            @endforeach
        </div>

        @if(request()->hasAny(['search', 'category', 'area', 'budget_tier', 'best_time']))
            <a href="{{ route('wisata.index') }}" class="font-mono-code text-xs font-bold underline">
                Reset Filter ✕
            </a>
        @endif
    </div>

    <!-- Rekomendasi Untukmu -->
    @if($recommended->isNotEmpty())
        <section class="mb-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Rekomendasi Untukmu ✦</h2>
                <a href="{{ route('onboarding.index') }}" class="font-mono-code text-xs font-bold underline">
                    Ubah preferensi minat →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($recommended as $rec)
                    @php
                        $recAvg = $rec->reviews->avg('rating');
                        $recCount = $rec->reviews->count();
                    @endphp
                    <a href="{{ route('wisata.show', $rec->id) }}" class="brutal-box bg-[#FFF9DB] p-4 flex gap-4 items-center hover:bg-[#FFDE59] transition">
                        <img src="{{ $rec->image_url ?: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=400&q=80' }}"
                             alt="{{ $rec->name }}" class="w-20 h-20 object-cover border-2 border-black shrink-0">
                        <div>
                            <span class="bg-black text-[#CCFF00] px-2 py-0.5 text-[11px] font-mono-code font-bold">{{ $rec->category }}</span>
                            <h3 class="font-bold text-base mt-1">{{ $rec->name }}</h3>
                            <p class="font-mono-code text-xs mt-1">
                                ★ {{ $recCount > 0 ? number_format($recAvg, 1) : 'Baru' }} • {{ $rec->best_time }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Grid Utama Destinasi -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Destinasi Semarang</h2>
            <a href="{{ route('profile.show') }}" class="font-mono-code text-xs font-bold underline">
                Lihat Rute Hari Ini & Wishlist →
            </a>
        </div>

        @if($destinations->isEmpty())
            <div class="brutal-box bg-white p-10 text-center">
                <p class="text-2xl font-bold mb-2">Belum ada spot wisata yang cocok dengan filter ini!</p>
                <p class="font-mono-code text-sm">Coba reset filter atau gunakan tombol <strong>+ Rekomendasiin Tempat</strong> di bagian atas.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($destinations as $item)
                    @php
                        $avg = $item->reviews->avg('rating');
                        $count = $item->reviews->count();
                        $latestCrowd = $item->reviews->first()?->crowd_status;
                    @endphp
                    <div class="brutal-box bg-white flex flex-col justify-between overflow-hidden">
                        <div>
                            <div class="relative border-b-3 border-black h-52 bg-gray-200">
                                <img src="{{ $item->image_url ?: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=800&q=80' }}"
                                     alt="{{ $item->name }}" class="w-full h-full object-cover">
                                <span class="absolute top-3 left-3 bg-[#FFDE59] border-2 border-black px-2.5 py-0.5 text-xs font-bold uppercase">
                                    {{ $item->category }}
                                </span>
                                <span class="absolute top-3 right-3 bg-white border-2 border-black px-2 py-0.5 text-[11px] font-mono-code font-bold">
                                    ⏰ {{ $item->best_time }}
                                </span>
                                <span class="absolute bottom-3 right-3 bg-black text-[#CCFF00] px-2.5 py-1 text-xs font-mono-code font-bold">
                                    {{ $item->price_range }}
                                </span>
                            </div>

                            <div class="p-5">
                                <div class="flex justify-between items-start gap-2 mb-2">
                                    <h3 class="text-xl font-bold leading-snug">{{ $item->name }}</h3>
                                    <span class="bg-[#FF66C4] border-2 border-black px-2 py-0.5 text-sm font-bold shrink-0">
                                        ★ {{ $count > 0 ? number_format($avg, 1) : 'Baru' }}
                                    </span>
                                </div>

                                <p class="font-mono-code text-xs text-gray-600 mb-2">
                                    📍 {{ $item->area ?: ($item->address ?: 'Semarang') }}
                                </p>

                                @if($latestCrowd)
                                    <span class="inline-block bg-[#A6FAFF] border border-black px-2 py-0.5 text-[11px] font-mono-code font-bold mb-2">
                                        Update: {{ $latestCrowd }}
                                    </span>
                                @endif

                                <p class="text-sm text-gray-800 line-clamp-3">
                                    {{ $item->description }}
                                </p>
                            </div>
                        </div>

                        <div class="px-5 pb-5 pt-2 flex justify-between items-center border-t-2 border-dashed border-gray-300">
                            <span class="font-mono-code text-xs font-bold">{{ $count }} ulasan</span>
                            <a href="{{ route('wisata.show', $item->id) }}" class="brutal-btn bg-[#CCFF00] text-xs font-bold px-3 py-2">
                                Lihat & Review →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Panduan Editor & Komunitas Teraktif -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-7 brutal-box bg-white p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Panduan & Itinerary Semarang</h2>
                <a href="{{ route('guides.index') }}" class="font-mono-code text-xs font-bold underline">Lihat semua ›</a>
            </div>
            <div class="space-y-3">
                @forelse($guides as $guide)
                    <div class="border-2 border-black p-3.5 bg-[#FFFDF5]">
                        <span class="bg-[#FFDE59] border border-black px-2 py-0.5 text-[11px] font-mono-code font-bold">{{ $guide->badge }}</span>
                        <h3 class="font-bold text-base mt-1">{{ $guide->title }}</h3>
                        <p class="text-xs text-gray-700 mt-1">{{ $guide->excerpt }}</p>
                        <p class="font-mono-code text-[11px] text-gray-500 mt-2">oleh {{ $guide->author_name }} • {{ $guide->read_time }}</p>
                    </div>
                @empty
                    <p class="font-mono-code text-xs text-gray-600">Jalankan seeder untuk menampilkan panduan perjalanan Semarang.</p>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-5 brutal-box bg-[#FFDE59] p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Komunitas Teraktif</h2>
                <a href="{{ route('community.index') }}" class="font-mono-code text-xs font-bold underline">Forum ›</a>
            </div>
            <div class="space-y-3">
                @forelse($topContributors as $idx => $contrib)
                    <div class="bg-white border-2 border-black p-3 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <span class="bg-black text-[#CCFF00] w-7 h-7 flex items-center justify-center font-mono-code font-bold text-xs">
                                #{{ $idx + 1 }}
                            </span>
                            <div>
                                <p class="font-bold text-sm">{{ $contrib->user_name }}</p>
                                <p class="font-mono-code text-xs text-gray-600">{{ $contrib->total_reviews }} review • {{ $contrib->total_helpful }} terbantu</p>
                            </div>
                        </div>
                        <span class="bg-[#FF66C4] border border-black px-2 py-0.5 text-[11px] font-bold">Aktif</span>
                    </div>
                @empty
                    <p class="font-mono-code text-xs">Jadilah kontributor ulasan pertama di Semarang!</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection