
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Law;
use App\Models\Complaint;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $stats = [
            'total_news' => News::count(),
            'published_news' => News::where('status', 'published')->count(),
            'total_laws' => Law::count(),
            'pending_complaints' => Complaint::where('status', 'pending')->count(),
            'total_complaints' => Complaint::count(),
        ];

        $recentComplaints = Complaint::latest()->take(5)->get();
        $recentNews = News::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentComplaints', 'recentNews'));
    }
}
