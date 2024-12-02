<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\Stages;
use App\Services\PermissionEmployeeService;
use App\Services\ViewChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private ViewChartService $viewChartService;
    private PermissionEmployeeService $permissionService;
    public $employee;

    public function __construct(ViewChartService $viewChartService, PermissionEmployeeService $permissionService)
    {
        $this->viewChartService = $viewChartService;
        $this->permissionService = $permissionService;

        // /** @var \App\Models\User */
        $this->employee = Auth::user();
    }
    public function index()
    {
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();
        $accounts = $this->permissionService->getAccountPermission($this->employee);
        $collection = $this->permissionService->getCollectionPermission($this->employee);

        $projects = $this->employee->projects->unique('id');
        $inProgressProjects = $this->employee->projects->where('project_status', 'قيد التنفيذ');
        $completedProjects = $this->employee->projects->where('project_status', 'مكتمل');
        $stoppedProjects = $this->employee->projects->where('project_status', 'معلق');
        $dashboard = Projects::with('stageOfProject')->get();

        $stages = [];
        foreach ($projects as $project) {
            $stages = Projects::with('stageOfProject')->where('id', $project->id)->get();
        }

        return view('employee.profile', [
            'employee' => $this->employee,
            'projects' => $projects,
            'stages' => $stages,
            'dashboard' => $dashboard,
            'stoppedProjects' => $stoppedProjects,
            'completedProjects' => $completedProjects,
            'inProgressProjects' => $inProgressProjects,
            'accountsPermission' => $accounts->last(),
            'collectionPermission' => $collection->last(),
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ]);
    }
}
