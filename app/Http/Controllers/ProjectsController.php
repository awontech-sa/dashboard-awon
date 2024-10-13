<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Roles;
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
        $completed_projects = Projects::where('p_status', 'مكتمل')->get();
        $stopped_projects = Projects::where('p_status', 'معلق')->get();
        $progress_projects = Projects::where('p_status', 'قيد التنفيذ')->get();
        $support_projects = Projects::where('p_support', '1')->get();
        $benef_projects = Projects::where('p_type_beneficiaries', 'جهة')->get();

        return view('dashboard.index', [
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'completed_projects' => $completed_projects,
            'stopped_projects' => $stopped_projects,
            'progress_projects' => $progress_projects,
            'support_projects' => $support_projects,
            'benef_projects' => $benef_projects
        ]);
    }

    public function techProjects($id)
    {
        $viewChart = $this->viewChartService->getProjectsIncome();
        $dashboard = Projects::all();
        $project = Projects::findOrFail($id);

        // Get members with their roles where the project ID matches the given ID
        // $membersWithRoles = $project->members()
        //     ->distinct()  // Add distinct to avoid duplication
        //     ->with(['roles' => function ($query) use ($id) {
        //         $query->where('team_project.projects_id', $id);
        //     }])
        //     ->get();
        // $membersWithRoles = $project->members()
        //     ->select('members.id', 'members.m_name') // Select only necessary columns
        //     ->with(['roles' => function ($query) use ($id) {
        //         $query->select('roles.id', 'roles.r_role') // Select only necessary columns from roles
        //             ->where('team_project.projects_id', $id);
        //     }])
        //     ->distinct() // Ensure distinct members and roles are fetched
        //     ->get();
        $membersWithRoles = TeamProject::join('members', 'team_project.members_id', '=', 'members.id')
            ->join('roles', 'team_project.roles_id', '=', 'roles.id')
            ->select('members.m_name', 'roles.r_role as role_name')
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
