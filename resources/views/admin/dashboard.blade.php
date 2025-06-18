
@extends('layouts.admin')

@section('title', 'لوحة الإدارة')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card" style="border-left-color: #007bff;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">إجمالي الأخبار</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_news'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card" style="border-left-color: #28a745;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">الأخبار المنشورة</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['published_news'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card" style="border-left-color: #17a2b8;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">إجمالي القوانين</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_laws'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card" style="border-left-color: #ffc107;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">الشكاوى المعلقة</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_complaints'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">آخر الأخبار</h6>
            </div>
            <div class="card-body">
                @if($recentNews->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($recentNews as $news)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ Str::limit($news->title, 50) }}</h6>
                            <small class="text-muted">{{ $news->created_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            <span class="badge bg-{{ $news->status == 'published' ? 'success' : 'warning' }}">
                                {{ $news->status == 'published' ? 'منشور' : 'مسودة' }}
                            </span>
                            @if($news->is_featured)
                            <span class="badge bg-info">مميز</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.news.index') }}" class="btn btn-primary btn-sm">عرض جميع الأخبار</a>
                </div>
                @else
                <p class="text-center text-muted">لا توجد أخبار حتى الآن</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">آخر الشكاوى</h6>
            </div>
            <div class="card-body">
                @if($recentComplaints->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($recentComplaints as $complaint)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $complaint->name }}</h6>
                                <small class="text-muted">{{ Str::limit($complaint->subject, 30) }}</small>
                            </div>
                            <span class="badge bg-{{ $complaint->status_color }}">
                                {{ match($complaint->status) {
                                    'pending' => 'معلقة',
                                    'in_progress' => 'قيد المعالجة',
                                    'resolved' => 'محلولة',
                                    'closed' => 'مغلقة',
                                    default => $complaint->status
                                } }}
                            </span>
                        </div>
                        <small class="text-muted">{{ $complaint->created_at->diffForHumans() }}</small>
                    </div>
                    @endforeach
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.complaints.index') }}" class="btn btn-primary btn-sm">عرض جميع الشكاوى</a>
                </div>
                @else
                <p class="text-center text-muted">لا توجد شكاوى حتى الآن</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">إجراءات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-plus-circle mb-2 d-block"></i>
                            إضافة خبر جديد
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.laws.create') }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-plus-circle mb-2 d-block"></i>
                            إضافة قانون جديد
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.complaints.index') }}" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-eye mb-2 d-block"></i>
                            مراجعة الشكاوى
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-info btn-lg w-100">
                            <i class="fas fa-external-link-alt mb-2 d-block"></i>
                            معاينة الموقع
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
