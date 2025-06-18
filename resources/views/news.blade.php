
@extends('layouts.app')

@section('title', 'الأخبار')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5 text-primary">الأخبار</h1>
            
            @if($news->count() > 0)
                <div class="row">
                    @foreach($news as $article)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-newspaper fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $article->title }}</h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                                    <div class="mt-auto">
                                        <small class="text-muted">{{ $article->created_at->format('Y/m/d') }}</small>
                                        <a href="{{ route('news.show', $article->id) }}" class="btn btn-primary btn-sm float-end">اقرأ المزيد</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $news->links() }}
                </div>
            @else
                <div class="text-center">
                    <i class="fas fa-newspaper fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">لا توجد أخبار حالياً</h3>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
