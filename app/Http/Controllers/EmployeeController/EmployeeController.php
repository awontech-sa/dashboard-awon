<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Services\PermissionEmployeeService;
use App\Services\ViewChartService;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
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
        $accounts = $this->permissionService->getAccountPermission($this->employee);
        $collection = $this->permissionService->getCollectionPermission($this->employee);

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $dashboard = Projects::all();
        // $completed_projects = Projects::where('p_status', 'مكتمل')->get();
        // $stopped_projects = Projects::where('p_status', 'معلق')->get();
        // $progress_projects = Projects::where('p_status', 'قيد التنفيذ')->get();


        return view('employee.index', [
            'employee' => $this->employee,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'accountsPermission' => $accounts->last(),
            'collectionPermission' => $collection->last(),
            // 'completed_projects' => $completed_projects,
            // 'stopped_projects' => $stopped_projects,
            // 'progress_projects' => $progress_projects,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
        ]);
    }
}
