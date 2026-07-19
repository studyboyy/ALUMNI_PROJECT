<?php

use App\Http\Controllers\AlumniExportController;
use App\Http\Controllers\CampusSearchController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\TracerStudyExportController;
use App\Livewire\Pages\Admin\AlumniManager;
use App\Livewire\Pages\Admin\Dashboard;
use App\Livewire\Pages\Admin\FaqManager;
use App\Livewire\Pages\Admin\ForumChat as AdminForumChat;
use App\Livewire\Pages\Admin\HomepageManager;
use App\Livewire\Pages\Admin\JobApproval;
use App\Livewire\Pages\Admin\MediaManager;
use App\Livewire\Pages\Admin\NewsManager;
use App\Livewire\Pages\Admin\OrganizationManager;
use App\Livewire\Pages\Admin\ProfileManager;
use App\Livewire\Pages\Admin\TestimoniManager;
use App\Livewire\Pages\Admin\ThemeManager;
use App\Livewire\Pages\Admin\TracerStudyManager;
use App\Livewire\Pages\Admin\WorkProgramManager;
use App\Livewire\Pages\Alumni\Dashboard as AlumniDashboard;
use App\Livewire\Pages\Alumni\ForumChat as AlumniForumChat;
use App\Livewire\Pages\Alumni\Index as AlumniIndex;
use App\Livewire\Pages\Alumni\Show as AlumniShow;
use App\Livewire\Pages\Alumni\SubmitJob as AlumniSubmitJob;
use App\Livewire\Pages\Alumni\UpdateProfile as AlumniUpdateProfile;
use App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Auth\Register;
use App\Livewire\Pages\Career\Index as CareerIndex;
use App\Livewire\Pages\Career\Show as CareerShow;
use App\Livewire\Pages\Contact\Index as ContactIndex;
use App\Livewire\Pages\Gallery\Index as GalleryIndex;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\News\Index as NewsIndex;
use App\Livewire\Pages\News\Show as NewsShow;
use App\Livewire\Pages\Profile\Index as ProfileIndex;
use App\Livewire\Pages\TracerStudy\Index as TracerStudyIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/profil', ProfileIndex::class)->name('profile.index');
Route::get('/data-alumni', AlumniIndex::class)->name('alumni.index');
Route::get('/data-alumni/{alumniProfile:slug}', AlumniShow::class)->name('alumni.show');
Route::get('/tracer-study', TracerStudyIndex::class)->name('tracer-study.index');
Route::get('/berita-agenda', NewsIndex::class)->name('news.index');
Route::get('/berita-agenda/{newsArticle:slug}', NewsShow::class)->name('news.show');
Route::get('/galeri', GalleryIndex::class)->name('gallery.index');
Route::get('/karier-kolaborasi', CareerIndex::class)->name('career.index');
Route::get('/karier-kolaborasi/{careerOpportunity:slug}', CareerShow::class)->name('career.show');
Route::get('/kontak-bantuan', ContactIndex::class)->name('contact.index');
Route::get('/api/campuses', CampusSearchController::class)->name('api.campuses');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/daftar-alumni', Register::class)->name('register');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/alumni/dashboard', AlumniDashboard::class)->name('alumni.dashboard');
    Route::get('/alumni/forum', AlumniForumChat::class)->name('alumni.forum');
    Route::get('/alumni/submit-lowongan', AlumniSubmitJob::class)->name('alumni.submit-job');
    Route::get('/alumni/update-profil', AlumniUpdateProfile::class)->name('alumni.update-profile');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/homepage', HomepageManager::class)->name('homepage');
    Route::get('/profil-kontak', ProfileManager::class)->name('profile');
    Route::get('/kontak', ProfileManager::class)->name('contact');
    Route::get('/alumni', AlumniManager::class)->name('alumni');
    Route::get('/alumni/export', [AlumniExportController::class, 'export'])->name('alumni.export');
    Route::get('/forum', AdminForumChat::class)->name('forum');
    Route::get('/lowongan', JobApproval::class)->name('jobs');
    Route::get('/berita', NewsManager::class)->name('news');
    Route::get('/media', MediaManager::class)->name('media');
    Route::get('/tema', ThemeManager::class)->name('theme');
    Route::get('/tracer-study', TracerStudyManager::class)->name('tracer-study');
    Route::get('/tracer-study/export', [TracerStudyExportController::class, 'export'])->name('tracer-study.export');
    Route::get('/organisasi', OrganizationManager::class)->name('organisation');
    Route::get('/program-kerja', WorkProgramManager::class)->name('work-programs');
    Route::get('/faq', FaqManager::class)->name('faq');
    Route::get('/testimoni', TestimoniManager::class)->name('testimoni');
    Route::post('/upload-image', [ImageUploadController::class, 'uploadForEditor'])->name('upload-image');
});
