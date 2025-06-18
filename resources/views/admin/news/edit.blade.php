
@extends('layouts.admin')

@section('title', 'تحرير الخبر')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تحرير الخبر</h1>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.news.update', $news->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان الخبر</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $news->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">محتوى الخبر</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10" required>{{ old('content', $news->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">صورة الخبر</label>
                            @if($news->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $news->image) }}" class="img-thumbnail" style="max-width: 200px;">
                                    <p class="text-muted small mt-1">الصورة الحالية</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <small class="text-muted">اترك فارغاً للاحتفاظ بالصورة الحالية</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">حالة النشر</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>مسودة</option>
                                <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>منشور</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                       value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    خبر مميز
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> حفظ التغييرات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// تطبيق محرر النصوص
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('content');
    // يمكن إضافة محرر نصوص متقدم هنا مثل TinyMCE أو CKEditor
});
</script>
@endsection
