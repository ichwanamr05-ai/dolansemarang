<?php

use App\Http\Controllers\DestinationController;
use Illuminate\Support\Facades\Route;

// Onboarding & Homepage
Route::get('/welcome', [DestinationController::class, 'welcome'])->name('onboarding.index');
Route::post('/welcome/preferences', [DestinationController::class, 'savePreferences'])->name('onboarding.save');
Route::get('/', [DestinationController::class, 'index'])->name('wisata.index');
Route::get('/acak-spot', [DestinationController::class, 'randomSpot'])->name('wisata.random');

// Kategori & Direktori Destinasi
Route::get('/destinasi', [DestinationController::class, 'index'])->name('wisata.all');
Route::get('/kategori/{category}', [DestinationController::class, 'byCategory'])->name('wisata.category');

// Tambah Destinasi, Detail, Semua Review & Form Tulis Review
Route::get('/wisata/create', [DestinationController::class, 'create'])->name('wisata.create');
Route::post('/wisata', [DestinationController::class, 'store'])->name('wisata.store');
Route::get('/wisata/{id}', [DestinationController::class, 'show'])->name('wisata.show');
Route::get('/wisata/{id}/review', [DestinationController::class, 'allReviews'])->name('wisata.reviews');
Route::get('/wisata/{id}/tulis-review', [DestinationController::class, 'writeReview'])->name('review.create');
Route::post('/wisata/{id}/review', [DestinationController::class, 'storeReview'])->name('review.store');
Route::post('/reviews/{reviewId}/helpful', [DestinationController::class, 'markHelpful'])->name('review.helpful');
Route::post('/reviews/{reviewId}/report', [DestinationController::class, 'reportReview'])->name('review.report');

// Panduan Perjalanan, Komunitas, dan Profil/Rute
Route::get('/panduan', [DestinationController::class, 'guides'])->name('guides.index');
Route::post('/panduan/{id}/like', [DestinationController::class, 'likeGuide'])->name('guides.like');

Route::get('/komunitas', [DestinationController::class, 'community'])->name('community.index');
Route::post('/komunitas/thread', [DestinationController::class, 'storeThread'])->name('thread.store');
Route::post('/komunitas/thread/{id}/reply', [DestinationController::class, 'storeReply'])->name('reply.store');
Route::post('/komunitas/thread/{id}/report', [DestinationController::class, 'reportThread'])->name('thread.report');

Route::get('/profil', [DestinationController::class, 'profile'])->name('profile.show');
Route::post('/wisata/{id}/wishlist', [DestinationController::class, 'toggleWishlist'])->name('wishlist.toggle');