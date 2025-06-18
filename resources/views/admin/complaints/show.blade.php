
@extends('layouts.admin')

@section('title', 'تفاصيل الشكوى')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تفاصيل الشكوى #{{ $complaint->id }}</h1>
        <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>معلومات الشكوى</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">الاسم:</th>
                            <td>{{ $complaint->name }}</td>
                        </tr>
                        <tr>
                            <th>البريد الإلكتروني:</th>
                            <td>{{ $complaint->email }}</td>
                        </tr>
                        <tr>
                            <th>رقم الهاتف:</th>
                            <td>{{ $complaint->phone }}</td>
                        </tr>
                        <tr>
                            <th>موضوع الشكوى:</th>
                            <td>{{ $complaint->subject }}</td>
                        </tr>
                        <tr>
                            <th>تاريخ الإرسال:</th>
                            <td>{{ $complaint->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @if($complaint->attachment)
                        <tr>
                            <th>المرفق:</th>
                            <td>
                                <a href="{{ asset('storage/complaints/' . $complaint->attachment) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i> تحميل المرفق
                                </a>
                            </td>
                        </tr>
                        @endif
                    </table>
                    
                    <h6 class="mt-4">نص الشكوى:</h6>
                    <div class="border p-3 bg-light">
                        {{ $complaint->message }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>إدارة الشكوى</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.complaints.update-status', $complaint->id) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">حالة الشكوى</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>قيد المراجعة</option>
                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>تم الحل</option>
                                <option value="closed" {{ $complaint->status == 'closed' ? 'selected' : '' }}>مغلقة</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> تحديث الحالة
                        </button>
                    </form>
                    
                    <hr>
                    
                    <form method="POST" action="{{ route('admin.complaints.add-note', $complaint->id) }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="note" class="form-label">إضافة ملاحظة</label>
                            <textarea class="form-control" id="note" name="note" rows="4" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus"></i> إضافة ملاحظة
                        </button>
                    </form>
                </div>
            </div>
            
            @if($complaint->notes && count($complaint->notes) > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5>الملاحظات</h5>
                </div>
                <div class="card-body">
                    @foreach($complaint->notes as $note)
                    <div class="border-bottom pb-2 mb-2">
                        <small class="text-muted">{{ $note['date'] }}</small>
                        <p class="mb-0">{{ $note['text'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
