<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\ProjectSupporters;
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
        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();
        $accounts = $this->permissionService->getAccountPermission($this->employee);
        $collection = $this->permissionService->getCollectionPermission($this->employee);

        $dashboard = Projects::with('stageOfProject')->get() ?? null;;

        $completed_projects = Projects::where('project_status', 'مكتمل')->get();
        $stopped_projects = Projects::where('project_status', 'معلق')->get();
        $progress_projects = Projects::where('project_status', 'قيد التنفيذ')->get();

        $supporter = ProjectSupporters::where('p_support_status', 'مدعوم')->get();
        $supporterComp = Projects::where('type_benef', 'جهة')->get();
        $supporterIndividual = Projects::where('type_benef', 'أفراد')->get();

        return view('employee.index', [
            'employee' => $this->employee,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'completed_projects' => $completed_projects,
            'stopped_projects' => $stopped_projects,
            'progress_projects' => $progress_projects,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
            'supporter' => $supporter,
            'supporterComp' => $supporterComp,
            'supporterIndividual' => $supporterIndividual,
            'accountsPermission' => $accounts->last(),
            'collectionPermission' => $collection->last(),
        ]);
    }
}
