<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فرم شکایت جدید</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            margin: 8px 0;
            font-size: 14px;
        }
        p strong {
            color: #555;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>فرم شکایت جدید ثبت شد</h2>
        <p><strong>نام و نام خانوادگی:</strong> {{ $data['first_name_last_name'] ?? '' }}</p>
        <p><strong>کد ملی:</strong> {{ $data['national_code'] ?? '' }}</p>
        <p><strong>موبایل:</strong> {{ $data['mobile'] ?? '' }}</p>
        <p><strong>شماره VIN خودرو:</strong> {{ $data['vin'] ?? '' }}</p>
        <p><strong>نام واحد صنفی:</strong> {{ $data['business_name'] ?? '' }}</p>
        <p><strong>نام مدیر واحد صنفی:</strong> {{ $data['manager_name'] ?? '' }}</p>
        <p><strong>استان:</strong> {{ $data['state'] ?? '' }}</p>
        <p><strong>شهر:</strong> {{ $data['city'] ?? '' }}</p>
        <p><strong>آدرس:</strong> {{ $data['address'] ?? '' }}</p>
        <p><strong>نوع مرکز:</strong> {{ $data['center_type'] ?? '' }}</p>
        <p><strong>موضوع شکایت:</strong> {{ $data['complaint_subject'] ?? '' }}</p>
        <p><strong>تاریخ مراجعه:</strong> {{ $data['visit_date'] ?? '' }}</p>
        <p><strong>توضیحات:</strong> {{ $data['description'] ?? '' }}</p>
    </div>
</body>
</html>
