
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::query();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $complaints = $query->latest()->paginate(10);
        
        return view('admin.complaints.index', compact('complaints'));
    }
    
    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }
    
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed'
        ]);
        
        $complaint->update([
            'status' => $request->status
        ]);
        
        return back()->with('success', 'تم تحديث حالة الشكوى بنجاح');
    }
    
    public function addNote(Request $request, Complaint $complaint)
    {
        $request->validate([
            'note' => 'required|string'
        ]);
        
        $notes = $complaint->notes ?? [];
        $notes[] = [
            'text' => $request->note,
            'date' => now()->format('Y-m-d H:i:s'),
            'user' => auth()->user()->name
        ];
        
        $complaint->update([
            'notes' => $notes
        ]);
        
        return back()->with('success', 'تم إضافة الملاحظة بنجاح');
    }
}
