@extends('layouts.app')

@section('content')
    <div class="brutal-box bg-[#FFDE59] p-6 mb-6">
        <span class="font-mono-code text-xs font-bold uppercase">Direktori Kategori</span>
        <h1 class="text-3xl md:text-4xl font-bold mt-1">Kategori: {{ $activeCategory }}</h1>
        <p class="font-mono-code text-xs mt-1">{{ $destinations->count() }} destinasi tersedia di Semarang</p>
    </div>

    <div class="flex flex-wrap justify-between items-center gap-3 mb-8">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('wisata.category', 'Semua') }}"
               class="brutal-btn px-3 py-1.5 text-sm font-bold {{ $activeCategory === 'Semua' ? 'bg-black text-white' : 'bg-white' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('wisata.category', $cat) }}"
                   class="brutal-btn px-3 py-1.5 text-sm font-bold {{ $activeCategory === $cat ? 'bg-[#FF66C4]' : 'bg-white' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('wisata.category', $activeCategory) }}" class="flex gap-2">
            <select name="sort" onchange="this.form.submit()" class="border-3 border-black bg-white px-3 py-1.5 text-sm font-bold">
                <option value="rating" {{ $sort == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                <option value="terbanyak" {{ $sort == 'terbanyak' ? 'selected' : '' }}>Ulasan Terbanyak</option>
                <option value="terbaru" {{ $sort == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
            </select>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($destinations as $item)
            @php
                $avg = $item->reviews->avg('rating');
                $count = $item->reviews->count();
            @endphp
            <div class="brutal-box bg-white flex flex-col justify-between overflow-hidden">
                <div>
                    <div class="relative border-b-3 border-black h-48 bg-gray-200">
                        <img src="{{ $item->image_url ?: 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=800&q=80' }}"
                             alt="{{ $item->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-[#A6FAFF] border-2 border-black px-2 py-0.5 text-xs font-bold">{{ $item->category }}</span>
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start gap-2 mb-1">
                            <h2 class="text-xl font-bold">{{ $item->name }}</h2>
                            <span class="bg-[#CCFF00] border-2 border-black px-2 py-0.5 text-xs font-bold">
                                ★ {{ $count > 0 ? number_format($avg, 1) : 'Baru' }}
                            </span>
                        </div>
                        <p class="font-mono-code text-xs text-gray-600 mb-2">{{ $item->price_range }}</p>
                        <p class="text-sm text-gray-800 line-clamp-3">{{ $item->description }}</p>
                    </div>
                </div>
                <div class="p-5 pt-0">
                    <a href="{{ route('wisata.show', $item->id) }}" class="brutal-btn bg-[#FFDE59] w-full block text-center py-2 text-sm font-bold">
                        Buka Detail & Review →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full brutal-box bg-white p-8 text-center font-bold">
                Belum ada destinasi pada kategori {{ $activeCategory }}.
            </div>
        @endforelse
    </div>
@endsection