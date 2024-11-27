<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use App\Models\ProjectPhases;
use App\Models\Projects;
use App\Models\ProjectUser;
use App\Services\PermissionEmployeeService;
use App\Services\ViewChartService;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
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
    public function show($id)
    {
        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();
        $accounts = $this->permissionService->getAccountPermission($this->employee);
        $collection = $this->permissionService->getCollectionPermission($this->employee);

        $project = Projects::findOrFail($id);
        $dashboard = Projects::all();
        $phases = ProjectPhases::find($project->id);
        $files = $project->files()->where('projects_id', $project->id)->get();

        $supporter = $project->supporter()->first();

        $stages = $project->stages;

        $details = $project->details()->where('projects_id', $project->id)->first();

        $installment = $supporter->installments()->where('project_id', $project->id)->get();

        $team = $project->members()->get()->map(function ($user) {
            return [
                'name' => $user->name,
                'role' => $user->pivot->role,
            ];
        });

        $bigBoss = ProjectUser::select('project_manager', 'sub_project_manager')->where('projects_id', $project->id)->first();

        return view('employee.project.show', [
            'accountsPermission' => $accounts->last(),
            'collectionPermission' => $collection->last(),
            'employee' => $this->employee,
            'chart' => $viewChart,
            'phases' => $phases,
            'project' => $project,
            "chart" => $viewChart,
            'supporter' => $supporter,
            'dashboard' => $dashboard,
            'files' => $files,
            'team' => $team,
            'details' => $details,
            'stages' => $stages,
            'bigBoss' => $bigBoss,
            'installment' => $installment,
            "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
            "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
        ]);
    }
}
