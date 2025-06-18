
@extends('layouts.admin')

@section('title', 'إدارة الشكاوى')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة الشكاوى</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-filter"></i> فلترة حسب الحالة
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?status=">جميع الشكاوى</a></li>
                <li><a class="dropdown-item" href="?status=pending">في الانتظار</a></li>
                <li><a class="dropdown-item" href="?status=in_progress">قيد المراجعة</a></li>
                <li><a class="dropdown-item" href="?status=resolved">تم الحل</a></li>
                <li><a class="dropdown-item" href="?status=closed">مغلقة</a></li>
            </ul>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>رقم الشكوى</th>
                            <th>الاسم</th>
                            <th>موضوع الشكوى</th>
                            <th>الحالة</th>
                            <th>تاريخ الإرسال</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                        <tr>
                            <td>#{{ $complaint->id }}</td>
                            <td>{{ $complaint->name }}</td>
                            <td>{{ Str::limit($complaint->subject, 50) }}</td>
                            <td>
                                <span class="badge bg-{{ $complaint->status_badge }}">
                                    {{ $complaint->status_text }}
                                </span>
                            </td>
                            <td>{{ $complaint->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.complaints.show', $complaint->id) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> عرض
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">لا توجد شكاوى</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($complaints->hasPages())
            <div class="d-flex justify-content-center">
                {{ $complaints->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
