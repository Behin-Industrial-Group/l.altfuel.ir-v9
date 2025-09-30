@extends('layouts.welcome')

@section('content')
    <div class="container">


        <div class="register-box card p-2">
            <h2 style="text-align: center">فرم ثبت شکایت</h2>
            <hr>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>نام و نام خانوادگی:</label>
                    <input type="text" name="first_name_last_name" class="form-control"
                        value="{{ old('first_name_last_name') }}" required>
                </div>
                <div class="form-group">
                    <label>کد ملی:</label>
                    <input type="text" name="national_code" class="form-control" value="{{ old('national_code') }}"
                        required>
                </div>
                <div class="form-group">
                    <label>موبایل:</label>
                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" required>
                </div>
                <div class="form-group">
                    <label>شماره VIN خودرو:</label>
                    <small>شماره وین در برگ سبز خودرو و در کارت خودرو ثبت است. در کارت خودروهای قدیمی پشت کارت به صورت عمودی و در کارت خودروهای جدید جلوی کارت ثبت و جلوی آن نوشته شده</small>
                    <input type="text" name="vin" class="form-control" value="{{ old('vin') }}">
                </div>
                <div class="form-group">
                    <label>نام واحد صنفی:</label>
                    <input type="text" name="business_name" class="form-control" value="{{ old('business_name') }}"
                        required>
                </div>
                <div class="form-group">
                    <label>نام مدیر واحد صنفی:</label>
                    <input type="text" name="manager_name" class="form-control" value="{{ old('manager_name') }}"
                        required>
                </div>
                <div class="form-group">
                    <label>استان:</label>
                    <input type="text" name="state" class="form-control" value="{{ old('state') }}" required>
                </div>
                <div class="form-group">
                    <label>شهر:</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                </div>
                <div class="form-group">
                    <label>آدرس:</label>
                    <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
                </div>
                <div class="form-group">
                    <label>نوع مرکز:</label>
                    <select name="center_type" id="center_type">
                        <option value="مرکز خدمات فنی" {{ old('center_type') == 'مرکز خدمات فنی' ? 'selected' : '' }}>خدمات
                            فنی (پرفشار)</option>
                        <option value="آزمایشگاه هیدرواستاتیک"
                            {{ old('center_type') == 'آزمایشگاه هیدرواستاتیک' ? 'selected' : '' }}>آزمایشگاه هیدرواستاتیک
                        </option>
                        <option value="مرکز کم فشار" {{ old('center_type') == 'مرکز کم فشار' ? 'selected' : '' }}>کم فشار
                        </option>
                        <option value="نمیدانم" {{ old('center_type') == 'نمیدانم' ? 'selected' : '' }}>نمیدانم</option>
                    </select>

                </div>
                <div class="form-group">
                    <label>موضوع شکایت:</label>
                    <select name="complaint_subject" id="complaint_subject">
                        <option value="ارجاع از معاینه فنی"
                            {{ old('complaint_subject') == 'ارجاع از معاینه فنی' ? 'selected' : '' }}>ارجاع از معاینه فنی
                        </option>
                        <option value="تبدیل یا تعویض مخزن دولتی"
                            {{ old('complaint_subject') == 'تبدیل یا تعویض مخزن دولتی' ? 'selected' : '' }}>تبدیل یا تعویض
                            مخزن دولتی</option>
                        <option value="تبدیل یا درخواست گواهی سلامت آزاد"
                            {{ old('complaint_subject') == 'تبدیل یا درخواست گواهی سلامت آزاد' ? 'selected' : '' }}>تبدیل
                            یا درخواست گواهی سلامت آزاد</option>
                        <option value="تعمیر سیستم گازسوز"
                            {{ old('complaint_subject') == 'تعمیر سیستم گازسوز' ? 'selected' : '' }}>تعمیر سیستم گازسوز
                        </option>
                    </select>

                </div>
                <div class="form-group">
                    <label>تاریخ مراجعه:</label>
                    <input type="text" name="visit_date" class="form-control persian-date"
                        value="{{ old('visit_date') }}" required>
                </div>
                <div class="form-group">
                    <label>توضیحات:</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>پیوست:</label>
                    <input type="file" name="file" id="">
                </div>
                <button type="submit" class="btn btn-primary">ثبت شکایت</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        initial_view()
    </script>
@endsection
