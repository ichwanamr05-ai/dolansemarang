@extends('layouts.app')

@section('content')
    <div class="brutal-box bg-white p-6 md:p-8 mb-8 flex flex-wrap justify-between items-center gap-4">
        <div>
            <span class="bg-[#FF66C4] border-2 border-black px-3 py-0.5 text-xs font-mono-code font-bold">
                ✓ {{ $level }}
            </span>
            <h1 class="text-3xl font-bold mt-2">Profil & Perencana Rute Dolan Semarang</h1>
            <p class="font-mono-code text-xs text-gray-600 mt-1">Rekap ulasan, poin kontribusi, rute searah, dan wishlist</p>
        </div>

        <div class="grid grid-cols-3 gap-3 text-center">
            <div class="brutal-box bg-[#FFDE59] px-4 py-2">
                <span class="block text-xl font-bold">{{ $totalReviews }}</span>
                <span class="font-mono-code text-[11px]">Review</span>
            </div>
            <div class="brutal-box bg-[#A6FAFF] px-4 py-2">
                <span class="block text-xl font-bold">{{ $totalHelpful }}</span>
                <span class="font-mono-code text-[11px]">Terbantu</span>
            </div>
            <div class="brutal-box bg-[#CCFF00] px-4 py-2">
                <span class="block text-xl font-bold">{{ $points }}</span>
                <span class="font-mono-code text-[11px]">Poin</span>
            </div>
        </div>
    </div>

    <!-- Rute Hari Ini & Estimasi Budget -->
    <div class="brutal-box bg-[#CCFF00] p-6 mb-8">
        <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
            <div>
                <h2 class="text-2xl font-bold">🗺️ Rute Dolan Hari Ini ({{ $routeItems->count() }} Spot)</h2>
                <p class="font-mono-code text-xs">Kumpulkan destinasi searah untuk melihat estimasi total tiket masuk.</p>
            </div>
            <div class="bg-black text-[#CCFF00] px-4 py-2 font-mono-code text-sm font-bold">
                Estimasi Total Budget: Rp {{ number_format($estimatedTotalBudget, 0, ',', '.') }}
            </div>
        </div>

        @if($routeItems->isEmpty())
            <div class="bg-white border-2 border-black p-4 text-sm">
                Belum ada destinasi di Rute Hari Ini. Buka halaman detail destinasi lalu klik <strong>+ Masukkan Rute Hari Ini</strong>.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($routeItems as $index => $r)
                    <div class="bg-white border-3 border-black p-4 flex flex-col justify-between">
                        <div>
                            <span class="bg-[#FFDE59] border border-black px-2 py-0.5 text-xs font-mono-code font-bold">
                                Stop #{{ $index + 1 }} • {{ $r->destination->area ?: 'Semarang' }}
                            </span>
                            <a href="{{ route('wisata.show', $r->destination_id) }}" class="block font-bold text-lg mt-2 underline">
                                {{ $r->destination->name }}
                            </a>
                            <p class="font-mono-code text-xs text-gray-600 mt-1">
                                {{ $r->destination->price_range }} • ⏰ {{ $r->destination->best_time }}
                            </p>
                        </div>
                        <form action="{{ route('wishlist.toggle', $r->destination_id) }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="status" value="route">
                            <button type="submit" class="font-mono-code text-xs underline text-gray-600 hover:text-black">
                                Hapus dari rute ✕
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7 space-y-4">
            <h2 class="text-2xl font-bold">Riwayat Ulasan ({{ $totalReviews }})</h2>
            @forelse($reviews as $rev)
                <div class="brutal-box bg-white p-5">
                    <div class="flex justify-between items-center mb-1">
                        <a href="{{ route('wisata.show', $rev->destination_id) }}" class="font-bold text-lg underline">
                            {{ $rev->destination->name ?? 'Destinasi' }}
                        </a>
                        <span class="bg-[#FFDE59] border-2 border-black px-2 py-0.5 text-xs font-bold">{{ $rev->rating }} ★</span>
                    </div>
                    <p class="font-mono-code text-xs text-gray-500 mb-2">oleh {{ $rev->user_name }} • {{ $rev->helpful_count }} terbantu</p>
                    <p class="text-sm text-gray-800">{{ $rev->comment }}</p>
                </div>
            @empty
                <div class="brutal-box bg-white p-8 text-center font-bold">Belum ada ulasan yang ditulis.</div>
            @endforelse
        </div>

        <div class="lg:col-span-5 space-y-6">
            <div class="brutal-box bg-[#FFF9DB] p-5">
                <h2 class="text-lg font-bold mb-3">Wishlist ({{ $wishlistItems->count() }})</h2>
                @forelse($wishlistItems as $w)
                    <div class="bg-white border-2 border-black p-2.5 mb-2 flex justify-between items-center text-sm">
                        <a href="{{ route('wisata.show', $w->destination_id) }}" class="font-bold underline">{{ $w->destination->name }}</a>
                        <span class="font-mono-code text-xs">{{ $w->destination->category }}</span>
                    </div>
                @empty
                    <p class="font-mono-code text-xs text-gray-600">Belum ada destinasi di wishlist.</p>
                @endforelse
            </div>

            <div class="brutal-box bg-white p-5">
                <h2 class="text-lg font-bold mb-3">Sudah Dikunjungi ({{ $visitedItems->count() }})</h2>
                @forelse($visitedItems as $v)
                    <div class="bg-[#A6FAFF] border-2 border-black p-2.5 mb-2 flex justify-between items-center text-sm">
                        <a href="{{ route('wisata.show', $v->destination_id) }}" class="font-bold underline">{{ $v->destination->name }}</a>
                        <span class="font-mono-code text-xs">✓ Selesai</span>
                    </div>
                @empty
                    <p class="font-mono-code text-xs text-gray-600">Belum ada destinasi yang ditandai dikunjungi.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection