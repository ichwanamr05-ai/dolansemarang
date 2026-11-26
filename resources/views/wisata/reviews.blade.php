@extends('layouts.app')

@section('content')
    <a href="{{ route('wisata.show', $destination->id) }}" class="font-mono-code text-sm font-bold underline inline-block mb-4">
        ← Kembali ke Detail {{ $destination->name }}
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4">
            <div class="brutal-box bg-white p-6">
                <h1 class="text-2xl font-bold mb-1">Review {{ $destination->name }}</h1>
                <p class="text-4xl font-bold mt-2">{{ $totalCount > 0 ? number_format($avgRating, 1) : '0.0' }} <span class="text-lg font-mono-code">/ 5.0</span></p>
                <p class="font-mono-code text-xs text-gray-600 mb-5">{{ $totalCount }} ulasan pengunjung</p>

                <div class="space-y-2 mb-6">
                    @foreach($breakdown as $star => $data)
                        <div class="flex items-center gap-2 text-xs font-mono-code">
                            <span class="w-8 font-bold">{{ $star }}★</span>
                            <div class="flex-1 h-4 border-2 border-black bg-gray-100">
                                <div class="h-full bg-[#FFDE59]" style="width: {{ $data['percent'] }}%"></div>
                            </div>
                            <span class="w-10 text-right">{{ $data['percent'] }}%</span>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('review.create', $destination->id) }}" class="brutal-btn bg-[#FF66C4] w-full block text-center py-2.5 font-bold text-sm">
                    + Tulis Review untuk {{ $destination->name }}
                </a>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-4">
            <div class="flex flex-wrap justify-between items-center gap-2">
                <h2 class="text-xl font-bold">Daftar Ulasan</h2>
                <div class="flex gap-2">
                    @foreach(['helpful' => 'Paling Membantu', 'terbaru' => 'Terbaru', 'rating' => 'Rating Tertinggi'] as $key => $label)
                        <a href="{{ route('wisata.reviews', ['id' => $destination->id, 'sort' => $key]) }}"
                           class="brutal-btn px-3 py-1 text-xs font-bold {{ $sort === $key ? 'bg-[#CCFF00]' : 'bg-white' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            @forelse($reviews as $rev)
                <div class="brutal-box bg-white p-5">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-bold text-base">{{ $rev->user_name }}</p>
                            <p class="font-mono-code text-xs text-gray-500">{{ $rev->visit_period ?: $rev->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="bg-[#FFDE59] border-2 border-black px-2.5 py-0.5 text-sm font-bold">
                            {{ str_repeat('★', $rev->rating) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-800 mb-3">{{ $rev->comment }}</p>
                    @if($rev->photo_url)
                        <img src="{{ $rev->photo_url }}" alt="Foto review" class="w-36 h-36 object-cover border-2 border-black mb-3">
                    @endif
                    <div class="flex justify-between items-center pt-2 border-t border-dashed border-gray-300">
                        <span class="font-mono-code text-xs">{{ $rev->helpful_count }} terbantu</span>
                        <form action="{{ route('review.helpful', $rev->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="brutal-btn bg-[#FFF9DB] px-2.5 py-1 text-xs font-bold">👍 Terbantu</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="brutal-box bg-white p-8 text-center font-bold">Belum ada ulasan.</div>
            @endforelse
        </div>
    </div>
@endsection