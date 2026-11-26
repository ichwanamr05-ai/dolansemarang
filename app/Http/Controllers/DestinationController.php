<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Guide;
use App\Models\Review;
use App\Models\Thread;
use App\Models\ThreadReply;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    private array $categories = ['Alam', 'Pantai', 'Kuliner', 'Sejarah', 'Keluarga', 'Hidden Gems'];
    private array $areas = ['Semarang Tengah / Kota Lama', 'Semarang Barat', 'Semarang Selatan / Tembalang', 'Semarang Utara', 'Ungaran / Bandungan'];
    private array $budgetTiers = ['Gratis / Parkir Aja', 'Hemat (< Rp 25rb)', 'Menengah (Rp 25rb - 75rb)', 'Sultan (> Rp 75rb)'];
    private array $bestTimes = ['Pagi / Sunrise', 'Siang / Anti-Hujan', 'Sore / Sunset', 'Malam / Kulineran', 'Fleksibel'];

    public function welcome()
    {
        return view('wisata.welcome', [
            'categories' => $this->categories,
            'selectedInterests' => session('user_interests', []),
        ]);
    }

    public function savePreferences(Request $request)
    {
        if ($request->has('skip')) {
            session()->forget('user_interests');
            return redirect()->route('wisata.index')->with('success', 'Menampilkan direktori lengkap Dolan Semarang.');
        }

        $validated = $request->validate([
            'interests' => 'required|array|min:1|max:6',
            'interests.*' => 'string',
        ]);

        session(['user_interests' => $validated['interests']]);

        return redirect()->route('wisata.index')
            ->with('success', 'Homepage disesuaikan dengan minatmu: ' . implode(', ', $validated['interests']) . '!');
    }

    public function index(Request $request)
    {
        $query = Destination::with(['reviews' => fn($q) => $q->where('is_flagged', false)])
            ->withAvg(['reviews' => fn($q) => $q->where('is_flagged', false)], 'rating')
            ->withCount(['reviews' => fn($q) => $q->where('is_flagged', false)]);

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'ilike', $term)
                  ->orWhere('address', 'ilike', $term)
                  ->orWhere('area', 'ilike', $term)
                  ->orWhere('description', 'ilike', $term)
                  ->orWhereHas('reviews', fn($rq) => $rq->where('is_flagged', false)->where('comment', 'ilike', $term));
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }
        if ($request->filled('budget_tier')) {
            $query->where('budget_tier', $request->budget_tier);
        }
        if ($request->filled('best_time')) {
            $query->where('best_time', $request->best_time);
        }

        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'rating' => $query->orderByDesc('reviews_avg_rating'),
            'terbanyak' => $query->orderByDesc('reviews_count'),
            'hemat' => $query->orderBy('estimated_cost'),
            default => $query->latest(),
        };

        $destinations = $query->get();

        $interests = session('user_interests', []);
        $recommended = Destination::with('reviews')->withAvg('reviews', 'rating')
            ->when(!empty($interests), fn($q) => $q->whereIn('category', $interests))
            ->orderByDesc('reviews_avg_rating')
            ->take(3)
            ->get();

        if ($recommended->isEmpty()) {
            $recommended = Destination::with('reviews')->withAvg('reviews', 'rating')->take(3)->get();
        }

        $guides = Guide::latest()->take(2)->get();

        $topContributors = Review::where('is_flagged', false)
            ->selectRaw('user_name, COUNT(*) as total_reviews, COALESCE(SUM(helpful_count), 0) as total_helpful')
            ->groupBy('user_name')
            ->orderByDesc('total_reviews')
            ->take(3)
            ->get();

        return view('wisata.index', [
            'destinations' => $destinations,
            'recommended' => $recommended,
            'guides' => $guides,
            'topContributors' => $topContributors,
            'categories' => $this->categories,
            'areas' => $this->areas,
            'budgetTiers' => $this->budgetTiers,
            'bestTimes' => $this->bestTimes,
            'interests' => $interests,
        ]);
    }

    public function randomSpot(Request $request)
    {
        $spot = Destination::when($request->filled('category'), fn($q) => $q->where('category', $request->category))
            ->inRandomOrder()
            ->first();

        if (!$spot) {
            return redirect()->route('wisata.index')->with('success', 'Belum ada destinasi untuk diacak.');
        }

        return redirect()->route('wisata.show', $spot->id)
            ->with('success', '🎲 Kejutan Dolan Semarang! Ini spot pilihan acak untukmu hari ini.');
    }

    public function byCategory(Request $request, string $category)
    {
        $query = Destination::with('reviews')->withAvg('reviews', 'rating')->withCount('reviews');

        if ($category !== 'Semua') {
            $query->where('category', $category);
        }

        $sort = $request->get('sort', 'rating');
        match ($sort) {
            'terbanyak' => $query->orderByDesc('reviews_count'),
            'terbaru' => $query->latest(),
            default => $query->orderByDesc('reviews_avg_rating'),
        };

        return view('wisata.category', [
            'destinations' => $query->get(),
            'activeCategory' => $category,
            'categories' => $this->categories,
            'sort' => $sort,
        ]);
    }

    public function create()
    {
        return view('wisata.create', [
            'categories' => $this->categories,
            'areas' => $this->areas,
            'budgetTiers' => $this->budgetTiers,
            'bestTimes' => $this->bestTimes,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price_range' => 'required|string|max:100',
            'budget_tier' => 'required|string|max:100',
            'estimated_cost' => 'nullable|integer|min:0',
            'best_time' => 'required|string|max:100',
            'opening_hours' => 'nullable|string|max:100',
            'description' => 'required|string',
            'address' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:120',
            'image_url' => 'nullable|url',
        ]);

        $validated['estimated_cost'] = $validated['estimated_cost'] ?? 0;

        $destination = Destination::create($validated);

        return redirect()->route('wisata.show', $destination->id)
            ->with('success', 'Destinasi baru berhasil masuk direktori Dolan Semarang!');
    }

    public function show($id)
    {
        $destination = Destination::with(['reviews' => fn($q) => $q->where('is_flagged', false)->latest()])->findOrFail($id);
        $reviews = $destination->reviews;

        $avgRating = $reviews->avg('rating') ?? 0;
        $aspectAverages = [
            'Pemandangan' => $reviews->avg('rating_scenery') ?? $avgRating,
            'Akses' => $reviews->avg('rating_access') ?? $avgRating,
            'Kebersihan' => $reviews->avg('rating_cleanliness') ?? $avgRating,
            'Fasilitas' => $reviews->avg('rating_facilities') ?? $avgRating,
        ];

        $isWishlisted = Wishlist::where('destination_id', $destination->id)->where('status', 'wishlist')->exists();
        $isInRoute = Wishlist::where('destination_id', $destination->id)->where('status', 'route')->exists();
        $isVisited = Wishlist::where('destination_id', $destination->id)->where('status', 'visited')->exists();

        return view('wisata.show', compact('destination', 'avgRating', 'aspectAverages', 'isWishlisted', 'isInRoute', 'isVisited'));
    }

    public function allReviews(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        $sort = $request->get('sort', 'helpful');

        $reviewsQuery = Review::where('destination_id', $destination->id)->where('is_flagged', false);
        match ($sort) {
            'terbaru' => $reviewsQuery->latest(),
            'rating' => $reviewsQuery->orderByDesc('rating')->latest(),
            default => $reviewsQuery->orderByDesc('helpful_count')->latest(),
        };

        $reviews = $reviewsQuery->get();
        $totalCount = $reviews->count();
        $avgRating = $reviews->avg('rating') ?? 0;

        $breakdown = [];
        for ($star = 5; $star >= 1; $star--) {
            $count = $reviews->where('rating', $star)->count();
            $breakdown[$star] = [
                'count' => $count,
                'percent' => $totalCount > 0 ? round(($count / $totalCount) * 100) : 0,
            ];
        }

        return view('wisata.reviews', compact('destination', 'reviews', 'avgRating', 'totalCount', 'breakdown', 'sort'));
    }

    public function writeReview($id)
    {
        $destination = Destination::findOrFail($id);
        return view('wisata.write_review', compact('destination'));
    }

    public function storeReview(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'rating_scenery' => 'nullable|integer|min:1|max:5',
            'rating_access' => 'nullable|integer|min:1|max:5',
            'rating_cleanliness' => 'nullable|integer|min:1|max:5',
            'rating_facilities' => 'nullable|integer|min:1|max:5',
            'visit_period' => 'nullable|string|max:100',
            'crowd_status' => 'nullable|string|max:100',
            'comment' => 'required|string',
            'photo_url' => 'nullable|url',
        ]);

        $validated['destination_id'] = $destination->id;
        $validated['rating_scenery'] = $validated['rating_scenery'] ?? $validated['rating'];
        $validated['rating_access'] = $validated['rating_access'] ?? $validated['rating'];
        $validated['rating_cleanliness'] = $validated['rating_cleanliness'] ?? $validated['rating'];
        $validated['rating_facilities'] = $validated['rating_facilities'] ?? $validated['rating'];

        Review::create($validated);

        return redirect()->route('wisata.show', $destination->id)
            ->with('success', 'Review jujurmu berhasil diposting (+50 poin kontributor)!');
    }

    public function markHelpful($reviewId)
    {
        Review::findOrFail($reviewId)->increment('helpful_count');
        return back()->with('success', 'Makasih! Ulasan ditandai terbantu.');
    }

    public function reportReview($reviewId)
    {
        Review::findOrFail($reviewId)->update(['is_flagged' => true]);
        return back()->with('success', 'Ulasan disembunyikan untuk moderasi komunitas.');
    }

    public function guides()
    {
        $guides = Guide::latest()->get();
        return view('wisata.guides', compact('guides'));
    }

    public function likeGuide($id)
    {
        Guide::findOrFail($id)->increment('likes_count');
        return back()->with('success', 'Panduan disukai!');
    }

    public function community()
    {
        $threads = Thread::where('is_flagged', false)
            ->with(['replies' => fn($q) => $q->latest()])
            ->latest()
            ->get();

        $topContributors = Review::where('is_flagged', false)
            ->selectRaw('user_name, COUNT(*) as total_reviews, COALESCE(SUM(helpful_count), 0) as total_helpful')
            ->groupBy('user_name')
            ->orderByDesc('total_reviews')
            ->take(5)
            ->get();

        return view('wisata.community', compact('threads', 'topContributors'));
    }

    public function storeThread(Request $request)
    {
        $validated = $request->validate([
            'tag' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'author_name' => 'required|string|max:100',
        ]);

        Thread::create($validated);

        return back()->with('success', 'Thread baru berhasil diposting ke Komunitas Dolan Semarang!');
    }

    public function storeReply(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'reply_text' => 'required|string',
        ]);

        $validated['thread_id'] = $thread->id;
        ThreadReply::create($validated);

        return back()->with('success', 'Balasanmu sudah terkirim!');
    }

    public function reportThread($id)
    {
        Thread::findOrFail($id)->update(['is_flagged' => true]);
        return back()->with('success', 'Thread disembunyikan untuk moderasi.');
    }

    public function toggleWishlist(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        $status = $request->input('status', 'wishlist');

        $labels = [
            'wishlist' => 'Wishlist',
            'route' => 'Rute Hari Ini',
            'visited' => 'Sudah Dikunjungi',
        ];

        $existing = Wishlist::where('destination_id', $destination->id)->where('status', $status)->first();
        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Dihapus dari daftar ' . ($labels[$status] ?? 'Koleksi') . '.');
        }

        Wishlist::create([
            'destination_id' => $destination->id,
            'user_name' => $request->input('user_name', 'Rara'),
            'status' => $status,
        ]);

        return back()->with('success', 'Berhasil disimpan ke ' . ($labels[$status] ?? 'Koleksi') . '!');
    }

    public function profile()
    {
        $reviews = Review::where('is_flagged', false)->with('destination')->latest()->get();
        $totalReviews = $reviews->count();
        $totalHelpful = $reviews->sum('helpful_count');
        $points = ($totalReviews * 50) + ($totalHelpful * 5);

        $level = match (true) {
            $totalReviews >= 20 || $totalHelpful >= 200 => 'Legenda Dolan Semarang',
            $totalReviews >= 5 => 'Penjelajah Aktif',
            default => 'Pejalan Baru',
        };

        $routeItems = Wishlist::with('destination')->where('status', 'route')->latest()->get();
        $estimatedTotalBudget = $routeItems->sum(fn($item) => $item->destination->estimated_cost ?? 0);

        $wishlistItems = Wishlist::with('destination')->where('status', 'wishlist')->latest()->get();
        $visitedItems = Wishlist::with('destination')->where('status', 'visited')->latest()->get();

        return view('wisata.profile', compact(
            'reviews',
            'totalReviews',
            'totalHelpful',
            'points',
            'level',
            'routeItems',
            'estimatedTotalBudget',
            'wishlistItems',
            'visitedItems'
        ));
    }
}