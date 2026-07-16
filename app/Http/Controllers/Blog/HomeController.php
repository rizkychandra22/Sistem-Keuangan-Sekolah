<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BeritaSekolah;
use App\Models\ContactSekolah;
use App\Models\GalleryEvent;
use App\Models\GalleryLomba;
use App\Models\GalleryPariwisata;
use App\Models\GalleryPerpisahan;
use App\Models\Guru;
use App\Models\Prestasi;
use App\Models\programkerja;
use App\Models\Sambutan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required',
        ],[
            'search.required' => 'Form pencarian tidak boleh kosong...!!!',
        ]);

        $keyword = $request->search;
        $prestasiSearch = Prestasi::where('judul', 'like', '%' . $keyword . '%')
                            ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
                            ->orderBy('created_at', 'desc')
                            ->get();

        $eventSearch = GalleryEvent::where('title', 'like', '%' . $keyword . '%')
                                    ->orWhere('subtitle', 'like', '%' . $keyword . '%')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        $lombaSearch = GalleryLomba::where('title', 'like', '%' . $keyword . '%')
                                    ->orWhere('subtitle', 'like', '%' . $keyword . '%')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        $pariwisataSearch = GalleryPariwisata::where('title', 'like', '%' . $keyword . '%')
                                            ->orWhere('subtitle', 'like', '%' . $keyword . '%')
                                            ->orderBy('created_at', 'desc')
                                            ->get();

        $perpisahanSearch = GalleryPerpisahan::where('title', 'like', '%' . $keyword . '%')
                                            ->orWhere('subtitle', 'like', '%' . $keyword . '%')
                                            ->orderBy('created_at', 'desc')
                                            ->get();

        $beritaSearch = BeritaSekolah::where('judul', 'like', '%' . $keyword . '%')
                                    ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        $results = $prestasiSearch->merge($eventSearch)
                                ->merge($lombaSearch)
                                ->merge($pariwisataSearch)
                                ->merge($perpisahanSearch)
                                ->merge($beritaSearch);
                            
        $contact_sekolahs = ContactSekolah::all();
        return view('blog.search', compact('keyword', 'results', 'contact_sekolahs'));
    }

    public function index()
    {
        // Mengambil postingan website dari database dengan query builder
        $gurus = Guru::all();
        $prestasis = Prestasi::all();
        $gallery_lombas = GalleryLomba::all();
        $gallery_events = GalleryEvent::all();
        $gallery_pariwisatas = GalleryPariwisata::all();
        $gallery_perpisahans = GalleryPerpisahan::all();
        $contact_sekolahs = ContactSekolah::all();

        return view('blog.index', compact('gurus', 'prestasis', 'gallery_lombas', 'gallery_events', 'gallery_pariwisatas', 'gallery_perpisahans', 'contact_sekolahs'));
    }
    public function info()
    {
        // Mengambil postingan website dari database dengan query builder
        $sambutans = Sambutan::all();
        $contact_sekolahs = ContactSekolah::all();
        $programkerjas = programkerja::all();
        $berita_sekolahs = BeritaSekolah::all();

        return view('blog.informasi-sekolah', compact('sambutans', 'contact_sekolahs', 'programkerjas', 'berita_sekolahs'));
    }
}
