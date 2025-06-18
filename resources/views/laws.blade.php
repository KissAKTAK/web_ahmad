
@extends('layouts.app')

@section('title', 'القوانين والتشريعات')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5 text-primary">القوانين والتشريعات</h1>
            
            <!-- نموذج البحث -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('laws.search') }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="text" name="search" class="form-control" placeholder="البحث في القوانين..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <select name="category" class="form-control">
                                    <option value="">جميع الفئات</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="number" name="year" class="form-control" placeholder="السنة" value="{{ request('year') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-primary w-100">بحث</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            @if($laws->count() > 0)
                <div class="row">
                    @foreach($laws as $law)
                        <div class="col-12 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h5 class="card-title text-primary">{{ $law->title }}</h5>
                                            <p class="card-text">{{ Str::limit($law->description, 200) }}</p>
                                            <div class="d-flex gap-3">
                                                <span class="badge bg-secondary">{{ $law->category }}</span>
                                                <span class="badge bg-info">رقم {{ $law->law_number }}</span>
                                                <span class="badge bg-warning">{{ $law->year }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            @if($law->pdf_file)
                                                <a href="{{ asset('storage/' . $law->pdf_file) }}" class="btn btn-success" target="_blank">
                                                    <i class="fas fa-file-pdf"></i> تحميل PDF
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $laws->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center">
                    <i class="fas fa-gavel fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">لا توجد قوانين مطابقة لبحثك</h3>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
