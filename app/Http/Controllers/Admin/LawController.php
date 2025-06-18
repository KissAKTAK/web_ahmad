<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Law;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LawController extends Controller
{
    public function index()
    {
        $laws = Law::latest()->paginate(10);
        return view('admin.laws.index', compact('laws'));
    }

    public function create()
    {
        return view('admin.laws.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'law_number' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'status' => 'required|in:active,inactive'
        ]);

        $law = new Law();
        $law->title = $request->title;
        $law->law_number = $request->law_number;
        $law->year = $request->year;
        $law->category = $request->category;
        $law->description = $request->description;
        $law->content = $request->content;
        $law->status = $request->status;

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('laws', $filename, 'public');
            $law->pdf_file = $filename;
        }

        $law->save();

        return redirect()->route('admin.laws.index')->with('success', 'تم إضافة القانون بنجاح');
    }

    public function show(Law $law)
    {
        return view('admin.laws.show', compact('law'));
    }

    public function edit(Law $law)
    {
        return view('admin.laws.edit', compact('law'));
    }

    public function update(Request $request, Law $law)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'law_number' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'status' => 'required|in:active,inactive'
        ]);

        $law->title = $request->title;
        $law->law_number = $request->law_number;
        $law->year = $request->year;
        $law->category = $request->category;
        $law->description = $request->description;
        $law->content = $request->content;
        $law->status = $request->status;

        if ($request->hasFile('pdf_file')) {
            // حذف الملف القديم
            if ($law->pdf_file) {
                Storage::disk('public')->delete('laws/' . $law->pdf_file);
            }
            
            $file = $request->file('pdf_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('laws', $filename, 'public');
            $law->pdf_file = $filename;
        }

        $law->save();

        return redirect()->route('admin.laws.index')->with('success', 'تم تحديث القانون بنجاح');
    }

    public function destroy(Law $law)
    {
        // حذف ملف PDF إذا كان موجوداً
        if ($law->pdf_file) {
            Storage::disk('public')->delete('laws/' . $law->pdf_file);
        }

        $law->delete();

        return redirect()->route('admin.laws.index')->with('success', 'تم حذف القانون بنجاح');
    }
}
