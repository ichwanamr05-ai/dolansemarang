@extends('layouts.app')

@section('content')
    <div class="brutal-box bg-[#A6FAFF] p-6 mb-8">
        <span class="font-mono-code text-xs font-bold uppercase">Ruang Diskusi Traveler</span>
        <h1 class="text-3xl md:text-4xl font-bold mt-1">Komunitas Dolan Semarang</h1>
        <p class="text-sm mt-1">Tanya rute, kondisi cuaca, rekomendasi kuliner malam, atau berbagi cerita perjalanan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 space-y-6">
            <!-- Form Buat Thread -->
            <div class="brutal-box bg-[#FFDE59] p-6">
                <h2 class="text-xl font-bold mb-3">+ Buat Thread Baru</h2>
                <form action="{{ route('thread.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input type="text" name="author_name" required placeholder="Namamu" class="bg-white border-2 border-black p-2 text-sm">
                        <select name="tag" class="bg-white border-2 border-black p-2 text-sm font-bold">
                            <option value="TANYA DOLAN!">TANYA DOLAN!</option>
                            <option value="CERITA PERJALANA">CERITA PERJALANA</option>
                            <option value="TIPS KULINER">TIPS KULINER</option>
                        </select>
                        <input type="text" name="title" required placeholder="Judul pertanyaan / cerita" class="bg-white border-2 border-black p-2 text-sm">
                    </div>
                    <textarea name="body" rows="2" required placeholder="Tulis detail pertanyaan atau ceritamu..." class="w-full bg-white border-2 border-black p-2.5 text-sm"></textarea>
                    <button type="submit" class="brutal-btn bg-[#FF66C4] px-4 py-2 text-sm font-bold">Posting Thread →</button>
                </form>
            </div>

            <!-- Daftar Thread -->
            @forelse($threads as $thread)
                <div class="brutal-box bg-white p-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="bg-black text-[#CCFF00] px-2.5 py-0.5 text-xs font-mono-code font-bold">{{ $thread->tag }}</span>
                        <span class="font-mono-code text-xs text-gray-500">{{ $thread->author_name }} • {{ $thread->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ $thread->title }}</h3>
                    <p class="text-sm text-gray-800 mb-4">{{ $thread->body }}</p>

                    <!-- Balasan -->
                    <div class="space-y-2 mb-4 pl-3 border-l-3 border-black">
                        @foreach($thread->replies as $reply)
                            <div class="bg-[#FFFDF5] border-2 border-black p-2.5 text-xs">
                                <span class="font-bold">{{ $reply->author_name }}:</span>
                                <span>{{ $reply->reply_text }}</span>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('reply.store', $thread->id) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                        @csrf
                        <input type="text" name="author_name" required placeholder="Nama" class="border-2 border-black px-2.5 py-1.5 text-xs sm:w-32">
                        <input type="text" name="reply_text" required placeholder="Tulis balasan..." class="border-2 border-black px-2.5 py-1.5 text-xs flex-1">
                        <button type="submit" class="brutal-btn bg-[#CCFF00] px-3 py-1.5 text-xs font-bold">Balas</button>
                    </form>
                </div>
            @empty
                <div class="brutal-box bg-white p-8 text-center font-bold">Belum ada thread diskusi. Mulai yang pertama di atas!</div>
            @endforelse
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="brutal-box bg-white p-5">
                <h2 class="text-lg font-bold mb-3">Papan Lencana</h2>
                <div class="space-y-2 text-xs">
                    <div class="border-2 border-black p-2.5 bg-[#FFF9DB]"><strong>Pejalan Baru:</strong> ulasan pertama</div>
                    <div class="border-2 border-black p-2.5 bg-[#FFF9DB]"><strong>Penjelajah Aktif:</strong> 5+ ulasan</div>
                    <div class="border-2 border-black p-2.5 bg-[#CCFF00]"><strong>Legenda Dolan Semarang:</strong> 20+ ulasan atau 200+ terbantu</div>
                </div>
            </div>

            <div class="brutal-box bg-white p-5">
                <h2 class="text-lg font-bold mb-3">Kontributor Teratas</h2>
                @forelse($topContributors as $c)
                    <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-300 text-sm">
                        <span class="font-bold">{{ $c->user_name }}</span>
                        <span class="font-mono-code text-xs bg-[#FFDE59] border border-black px-2 py-0.5">{{ $c->total_reviews }} review</span>
                    </div>
                @empty
                    <p class="font-mono-code text-xs text-gray-500">Belum ada data kontributor.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection