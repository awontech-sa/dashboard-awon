<?php

namespace App\Http\Controllers;

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

        $project_team = TeamProject::where('project_id', '=', $project->id)->get();

        return view('tech-projects.index', [
            'project' => $project,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'team' => $project_team
        ]);
    }
}
