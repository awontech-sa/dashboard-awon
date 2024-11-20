<?php
return [
    'regex' => 'يجب أن تحتوي كلمة المرور على أحرف وأرقام ورموز خاصة (!، $، #، %).',
    'required' => 'يجب أن لا يكون :attribute فارغًا.',
    'image' => 'يجب أن يكون :attribute صورة.',
    'email' => 'يجب عليك إدخال :attribute صحيح.',
    'phone_number' => 'يجب أن يتكون :attribute من :max أرقام.',
    'name' => [
        'string' => 'يجب أن يكون :attribute نصًا.',
        'max' => 'يجب ألا يتجاوز :attribute :max حرفًا.',
    ],
    'password' => [
        'min' => 'يجب ألا تقل كلمة المرور عن :min أحرف.',
    ],
    'profile_image' => [
        'mimes' => 'يجب أن يكون :attribute من نوع: :values.',
        'max' => 'يجب ألا يتجاوز حجم :attribute :max كيلوبايت.',
    ],

    'attributes' => [
        'email' => 'بريد إلكتروني',
        'phone_number' => 'رقم الجوال',
        'name' => 'الاسم الشخصي',
        'password' => 'كلمة المرور',
        'profile_image' => 'الصورة الشخصية',
        'x' => 'الرابط',
        'linkedin' => 'رابط لينكد إن',
    ],
];
