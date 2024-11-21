<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use App\Models\PowersUserSections;
use App\Models\User;
use App\Services\PermissionEmployeeService;
use App\Services\ViewChartService;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    private ViewChartService $viewChartService;
    private PermissionEmployeeService $permissionService;
    public $employee;

    public function __construct(ViewChartService $viewChartService, PermissionEmployeeService $permissionService)
    {
        $this->viewChartService = $viewChartService;
        $this->permissionService = $permissionService;

        /** @var \App\Models\User */
        $this->employee = Auth::user();
    }

    public function index()
    {
        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $accounts = $this->permissionService->getAccountPermission($this->employee);
        $collection = $this->permissionService->getCollectionPermission($this->employee);

        $users = User::with(['positions.department', 'projects'])->get();

        $permission = PowersUserSections::where('user_id', $this->employee->id)->where('powers_sections_id', 1)->get(['permission']);

        return view('employee.users.index', [
            'permission' => $permission,
            'accountsPermission' => $accounts->last(),
            'collectionPermission' => $collection->last(),
            'employee' => $this->employee,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
            'users' => $users
        ]);
    }
}
