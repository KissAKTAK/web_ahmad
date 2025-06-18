<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published'
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->summary = $request->summary;
        $news->content = $request->content;
        $news->is_featured = $request->has('is_featured');
        $news->status = $request->status;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('news', $filename, 'public');
            $news->image = $filename;
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'تم إضافة الخبر بنجاح');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published'
        ]);

        $news->title = $request->title;
        $news->summary = $request->summary;
        $news->content = $request->content;
        $news->is_featured = $request->has('is_featured');
        $news->status = $request->status;

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($news->image) {
                Storage::disk('public')->delete('news/' . $news->image);
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('news', $filename, 'public');
            $news->image = $filename;
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'تم تحديث الخبر بنجاح');
    }

    public function destroy(News $news)
    {
        // حذف الصورة إذا كانت موجودة
        if ($news->image) {
            Storage::disk('public')->delete('news/' . $news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'تم حذف الخبر بنجاح');
    }
}
