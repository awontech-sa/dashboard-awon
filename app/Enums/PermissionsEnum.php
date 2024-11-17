<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    case watch = 'مشاهدة';
    case edit = 'تعديل';
    case delete = 'حذف';
}
