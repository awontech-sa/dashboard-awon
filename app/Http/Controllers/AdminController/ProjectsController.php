<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\TeamProject;
use App\Services\ViewChartService;


class ProjectsController extends Controller
{
    private ViewChartService $viewChartService;

    public function __construct(ViewChartService $viewChartService)
    {
        $this->viewChartService = $viewChartService;
    }


    public function index()
    {
        $viewChart = $this->viewChartService->getProjectsIncome();

        $dashboard = Projects::all();
        // $completed_projects = Projects::where('p_status', 'مكتمل')->get();
        // $stopped_projects = Projects::where('p_status', 'معلق')->get();
        // $progress_projects = Projects::where('p_status', 'قيد التنفيذ')->get();

        return view('dashboard.index', [
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            // 'completed_projects' => $completed_projects,
            // 'stopped_projects' => $stopped_projects,
            // 'progress_projects' => $progress_projects,
        ]);
    }

    public function techProjects($id)
    {
        $viewChart = $this->viewChartService->getProjectsIncome();
        $dashboard = Projects::all();
        $project = Projects::findOrFail($id);

        $membersWithRoles = TeamProject::join('members', 'team_project.members_id', '=', 'members.id')
            ->join('employee_roles', 'team_project.roles_id', '=', 'employee_roles.id')
            ->select('members.m_name', 'employee_roles.r_role as role_name')
            ->where('team_project.projects_id', $id)  // Assuming $id is the project ID
            ->distinct()
            ->get();

        return view('tech-projects.index', [
            'project' => $project,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'team' => $membersWithRoles
        ]);
    }
}
