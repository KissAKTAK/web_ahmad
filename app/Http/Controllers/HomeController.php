<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Law;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $featuredNews = News::where('is_featured', true)
                           ->where('status', 'published')
                           ->latest()
                           ->take(3)
                           ->get();
        
        $latestNews = News::where('status', 'published')
                         ->latest()
                         ->take(6)
                         ->get();
        
        return view('home', compact('featuredNews', 'latestNews'));
    }

    public function news()
    {
        $news = News::where('status', 'published')
                   ->latest()
                   ->paginate(10);
        
        return view('news', compact('news'));
    }

    public function newsShow($id)
    {
        $newsItem = News::where('id', $id)
                       ->where('status', 'published')
                       ->firstOrFail();
        
        $relatedNews = News::where('status', 'published')
                          ->where('id', '!=', $id)
                          ->latest()
                          ->take(3)
                          ->get();
        
        return view('news-show', compact('newsItem', 'relatedNews'));
    }

    public function laws()
    {
        $laws = Law::where('status', 'active')
                  ->latest()
                  ->paginate(10);
        
        $categories = Law::where('status', 'active')
                        ->distinct()
                        ->pluck('category');
        
        return view('laws', compact('laws', 'categories'));
    }

    public function lawsSearch(Request $request)
    {
        $query = Law::where('status', 'active');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('law_number', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        
        $laws = $query->paginate(10);
        $categories = Law::where('status', 'active')
                        ->distinct()
                        ->pluck('category');
        
        return view('laws', compact('laws', 'categories'));
    }

    public function complaints()
    {
        return view('complaints');
    }

    public function complaintsStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'phone.required' => 'رقم الهاتف مطلوب',
            'subject.required' => 'موضوع الشكوى مطلوب',
            'message.required' => 'نص الشكوى مطلوب',
            'attachment.mimes' => 'نوع الملف غير مدعوم',
            'attachment.max' => 'حجم الملف كبير جداً'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $complaint = new Complaint();
        $complaint->name = $request->name;
        $complaint->email = $request->email;
        $complaint->phone = $request->phone;
        $complaint->subject = $request->subject;
        $complaint->message = $request->message;
        $complaint->status = 'pending';

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('complaints', $filename, 'public');
            $complaint->attachment = $filename;
        }

        $complaint->save();

        return back()->with('success', 'تم إرسال شكواكم بنجاح. سيتم التواصل معكم قريباً.');
    }
}
