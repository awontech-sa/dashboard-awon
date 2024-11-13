<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case notYet = 'لم يتم البدء';
    case inProgress = 'قيد التنفيذ';
    case wait = 'معلق';
    case completed = 'مكتمل';
}
