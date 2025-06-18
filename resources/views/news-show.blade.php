
@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <article class="card shadow">
                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->title }}" style="height: 400px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h1 class="card-title text-primary">{{ $article->title }}</h1>
                    <div class="text-muted mb-3">
                        <i class="fas fa-calendar"></i> {{ $article->created_at->format('Y/m/d') }}
                    </div>
                    <div class="content">
                        {!! $article->content !!}
                    </div>
                </div>
            </article>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">أخبار ذات صلة</h5>
                </div>
                <div class="card-body">
                    @if($relatedNews->count() > 0)
                        @foreach($relatedNews as $related)
                            <div class="border-bottom pb-2 mb-2">
                                <h6><a href="{{ route('news.show', $related->id) }}" class="text-decoration-none">{{ $related->title }}</a></h6>
                                <small class="text-muted">{{ $related->created_at->format('Y/m/d') }}</small>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">لا توجد أخبار ذات صلة</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
