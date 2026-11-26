<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolan Semarang — Direktori & Review Wisata</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #FFFDF5;
            background-image: radial-gradient(#000000 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .font-mono-code { font-family: 'Space Mono', monospace; }
        .brutal-box {
            border: 3px solid #000;
            box-shadow: 5px 5px 0px #000;
        }
        .brutal-btn {
            border: 3px solid #000;
            box-shadow: 4px 4px 0px #000;
            transition: all 0.12s ease;
        }
        .brutal-btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px #000;
        }
        .brutal-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0px #000;
        }
    </style>
</head>
<body class="text-black min-h-screen flex flex-col">

    <nav class="bg-[#FFDE59] border-b-4 border-black sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3.5 flex flex-wrap justify-between items-center gap-3">
            <div class="flex items-center gap-5 flex-wrap">
                <a href="{{ route('wisata.index') }}" class="flex items-center gap-2">
                    <span class="bg-black text-[#CCFF00] px-3 py-1 font-bold text-lg sm:text-xl tracking-tight -rotate-2 inline-block">
                        DOLAN SEMARANG ✦
                    </span>
                </a>

                <div class="flex items-center gap-2 sm:gap-4 text-sm font-bold">
                    <a href="{{ route('wisata.index') }}" class="hover:bg-white px-2 py-1 border-2 border-transparent hover:border-black">
                        Destinasi
                    </a>
                    <a href="{{ route('wisata.category', 'Alam') }}" class="hover:bg-white px-2 py-1 border-2 border-transparent hover:border-black">
                        Kategori
                    </a>
                    <a href="{{ route('guides.index') }}" class="hover:bg-white px-2 py-1 border-2 border-transparent hover:border-black">
                        Panduan
                    </a>
                    <a href="{{ route('community.index') }}" class="hover:bg-white px-2 py-1 border-2 border-transparent hover:border-black">
                        Komunitas
                    </a>
                    <a href="{{ route('profile.show') }}" class="hover:bg-white px-2 py-1 border-2 border-transparent hover:border-black">
                        Profil
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('onboarding.index') }}" class="brutal-btn bg-white text-black font-mono-code font-bold px-3 py-1.5 text-xs">
                    Pilih Minat
                </a>
                <a href="{{ route('wisata.create') }}" class="brutal-btn bg-[#FF66C4] text-black font-bold px-3.5 py-1.5 text-xs sm:text-sm">
                    + Rekomendasiin Tempat
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8 flex-1 w-full">
        @if(session('success'))
            <div class="brutal-box bg-[#CCFF00] p-4 mb-6 font-bold flex justify-between items-center">
                <span>⚡ {{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="brutal-box bg-[#FF66C4] p-4 mb-6 text-sm font-bold">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-black text-white border-t-4 border-black py-6 mt-12">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-2 text-sm font-mono-code">
            <p>DOLAN SEMARANG © 2026 — Direktori & review jujur wisata Semarang.</p>
            <p class="text-[#CCFF00]">Laravel + PostgreSQL</p>
        </div>
    </footer>

</body>
</html>