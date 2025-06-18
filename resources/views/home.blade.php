
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">النيابة العامة اليمنية</h1>
                <p class="lead mb-4">العدالة والقانون أساس بناء الدولة. نعمل على تطبيق القانون وحماية حقوق المواطنين</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('laws') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-gavel me-2"></i>
                        القوانين والتشريعات
                    </a>
                    <a href="{{ route('complaints') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-comment-dots me-2"></i>
                        تقديم شكوى
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://via.placeholder.com/500x400/1e3c72/ffffff?text=شعار+النيابة+العامة" alt="شعار النيابة العامة" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">خدماتنا</h2>
                <p class="text-muted">نقدم مجموعة شاملة من الخدمات القانونية والقضائية</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin-bottom: 20px;">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                        <h5 class="card-title">الأخبار والإعلانات</h5>
                        <p class="card-text">آخر الأخبار والإعلانات الرسمية من النيابة العامة</p>
                        <a href="{{ route('news') }}" class="btn btn-primary">عرض الأخبار</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin-bottom: 20px;">
                            <i class="fas fa-balance-scale fa-2x"></i>
                        </div>
                        <h5 class="card-title">القوانين والتشريعات</h5>
                        <p class="card-text">البحث في القوانين والتشريعات اليمنية المعمول بها</p>
                        <a href="{{ route('laws') }}" class="btn btn-success">البحث في القوانين</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin-bottom: 20px;">
                            <i class="fas fa-comment-dots fa-2x"></i>
                        </div>
                        <h5 class="card-title">تقديم الشكاوى</h5>
                        <p class="card-text">تقديم الشكاوى والبلاغات للنيابة العامة</p>
                        <a href="{{ route('complaints') }}" class="btn btn-warning">تقديم شكوى</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured News -->
@if($featuredNews->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">أخبار مميزة</h2>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($featuredNews as $news)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 news-card">
                    @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" class="card-img-top" alt="{{ $news->title }}">
                    @endif
                    <div class="card-body">
                        <span class="badge badge-featured mb-2">مميز</span>
                        <h5 class="card-title">{{ $news->title }}</h5>
                        <p class="card-text">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $news->created_at->format('Y/m/d') }}</small>
                            <a href="{{ route('news.show', $news->id) }}" class="btn btn-sm btn-primary">قراءة المزيد</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest News -->
@if($latestNews->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">آخر الأخبار</h2>
                <a href="{{ route('news') }}" class="btn btn-outline-primary">عرض جميع الأخبار</a>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($latestNews as $news)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 news-card">
                    @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" class="card-img-top" alt="{{ $news->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $news->title }}</h5>
                        <p class="card-text">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $news->created_at->format('Y/m/d') }}</small>
                            <a href="{{ route('news.show', $news->id) }}" class="btn btn-sm btn-primary">قراءة المزيد</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Recent Laws -->
@if($recentLaws->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">أحدث القوانين</h2>
                <a href="{{ route('laws') }}" class="btn btn-outline-primary">عرض جميع القوانين</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="list-group">
                    @foreach($recentLaws as $law)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $law->title }}</h6>
                            <small>{{ $law->year }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit($law->description, 100) }}</p>
                        <small>رقم القانون: {{ $law->law_number }} | التصنيف: {{ $law->category }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
