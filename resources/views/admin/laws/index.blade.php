
@extends('layouts.admin')

@section('title', 'إدارة القوانين والتشريعات')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة القوانين والتشريعات</h1>
        <a href="{{ route('admin.laws.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة قانون جديد
        </a>
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
                            <th>العنوان</th>
                            <th>الفئة</th>
                            <th>رقم القانون</th>
                            <th>السنة</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">لا توجد قوانين</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
