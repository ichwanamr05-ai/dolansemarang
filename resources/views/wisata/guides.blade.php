@extends('layouts.app')

@section('content')
    <div class="brutal-box bg-[#FFDE59] p-6 mb-8">
        <span class="font-mono-code text-xs font-bold uppercase">Panduan & Itinerary</span>
        <h1 class="text-3xl md:text-4xl font-bold mt-1">Panduan Perjalanan Semarang</h1>
        <p class="text-sm mt-1">Rute harian, tips cuaca, dan rekomendasi jalan-jalan terkurasi untuk Semarang.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($guides as $guide)
            <div class="brutal-box bg-white p-6 flex flex-col justify-between">
                <div>
                    <span class="bg-[#CCFF00] border-2 border-black px-2.5 py-0.5 text-xs font-mono-code font-bold">{{ $guide->badge }}</span>
                    <h2 class="text-2xl font-bold mt-2 mb-2">{{ $guide->title }}</h2>
                    <p class="text-sm text-gray-700 mb-3">{{ $guide->excerpt }}</p>
                    <div class="bg-[#FFFDF5] border-2 border-black p-4 text-sm leading-relaxed mb-4 whitespace-pre-line">{{ $guide->content }}</div>
                </div>
                <div class="flex justify-between items-center pt-3 border-t-2 border-dashed border-gray-300">
                    <span class="font-mono-code text-xs text-gray-600">{{ $guide->author_name }} • {{ $guide->read_time }}</span>
                    <form action="{{ route('guides.like', $guide->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="brutal-btn bg-[#FF66C4] px-3 py-1 text-xs font-bold">
                            ♥ {{ $guide->likes_count }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full brutal-box bg-white p-8 text-center font-bold">
                Belum ada artikel panduan di database. Kamu bisa menambahkannya lewat seeder atau langsung di PostgreSQL.
            </div>
        @endforelse
    </div>
@endsection