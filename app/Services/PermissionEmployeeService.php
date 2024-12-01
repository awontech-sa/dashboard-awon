<?php

namespace App\Services;

use App\Models\PowersUserSections;

class PermissionEmployeeService
{
    public function getAccountPermission($employee)
    {
        $accounts = PowersUserSections::where('user_id', $employee->id)->where('powers_sections_id', 1)->get();

        return $accounts;
    }

    public function getCollectionPermission($employee)
    {
        $collection = PowersUserSections::where('user_id', $employee->id)->where('powers_sections_id', 2)->get();

        return $collection;
    }

    public function getTechTeamPermission($employee)
    {
        $techPermission = PowersUserSections::where('user_id', $employee->id)->where('powers_sections_id', 3)->get();

        return $techPermission;
    }
}
