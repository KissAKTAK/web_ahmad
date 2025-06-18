
@extends('layouts.admin')

@section('title', 'تعديل قانون')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تعديل قانون: {{ $law->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.laws.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> العودة للقائمة
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.laws.update', $law) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">عنوان القانون <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="{{ old('title', $law->title) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">وصف القانون</label>
                                    <div id="editor" style="height: 200px;">{!! old('description', $law->description) !!}</div>
                                    <input type="hidden" name="description" id="description">
                                </div>

                                <div class="form-group">
                                    <label for="content">محتوى القانون</label>
                                    <div id="content-editor" style="height: 400px;">{!! old('content', $law->content) !!}</div>
                                    <input type="hidden" name="content" id="content">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="law_number">رقم القانون <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="law_number" name="law_number" 
                                           value="{{ old('law_number', $law->law_number) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="year">سنة الإصدار <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="year" name="year" 
                                           value="{{ old('year', $law->year) }}" min="1900" max="{{ date('Y') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="category">التصنيف <span class="text-danger">*</span></label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="">اختر التصنيف</option>
                                        <option value="دستوري" {{ old('category', $law->category) == 'دستوري' ? 'selected' : '' }}>دستوري</option>
                                        <option value="جنائي" {{ old('category', $law->category) == 'جنائي' ? 'selected' : '' }}>جنائي</option>
                                        <option value="مدني" {{ old('category', $law->category) == 'مدني' ? 'selected' : '' }}>مدني</option>
                                        <option value="تجاري" {{ old('category', $law->category) == 'تجاري' ? 'selected' : '' }}>تجاري</option>
                                        <option value="إداري" {{ old('category', $law->category) == 'إداري' ? 'selected' : '' }}>إداري</option>
                                        <option value="عمالي" {{ old('category', $law->category) == 'عمالي' ? 'selected' : '' }}>عمالي</option>
                                        <option value="أخرى" {{ old('category', $law->category) == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="pdf_file">ملف PDF (اختياري)</label>
                                    <input type="file" class="form-control-file" id="pdf_file" name="pdf_file" accept=".pdf">
                                    @if($law->pdf_file)
                                        <small class="form-text text-muted">
                                            الملف الحالي: <a href="{{ Storage::url('laws/' . $law->pdf_file) }}" target="_blank">عرض الملف</a>
                                        </small>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="status">حالة النشر</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active" {{ old('status', $law->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="inactive" {{ old('status', $law->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> حفظ التعديلات
                        </button>
                        <a href="{{ route('admin.laws.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script>
$(document).ready(function() {
    // محرر الوصف
    var descriptionQuill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{'list': 'ordered'}, {'list': 'bullet'}],
                ['link']
            ]
        }
    });

    // محرر المحتوى
    var contentQuill = new Quill('#content-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{'header': [1, 2, 3, false]}],
                ['bold', 'italic', 'underline', 'strike'],
                [{'list': 'ordered'}, {'list': 'bullet'}],
                [{'indent': '-1'}, {'indent': '+1'}],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // تحديث القيم المخفية عند الإرسال
    $('form').on('submit', function() {
        $('#description').val(descriptionQuill.root.innerHTML);
        $('#content').val(contentQuill.root.innerHTML);
    });
});
</script>
@endpush
@endsection
