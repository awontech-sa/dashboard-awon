<?php

namespace App\Http\Controllers;

use App\Models\ProjectPhases;
use App\Models\Projects;
use App\Models\ProjectSupporters;
use App\Models\ProjectUser;
use App\Services\ViewChartService;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    private ViewChartService $viewChartService;

    public function __construct(ViewChartService $viewChartService)
    {
        $this->viewChartService = $viewChartService;
    }


    public function index()
    {
        $viewChart = $this->viewChartService->getProjectsIncome();

        $dashboard = Projects::with('stageOfProject')->get() ?? null;;

        $completed_projects = Projects::where('project_status', 'مكتمل')->get();
        $stopped_projects = Projects::where('project_status', 'معلق')->get();
        $progress_projects = Projects::where('project_status', 'قيد التنفيذ')->get();

        $supporter = ProjectSupporters::where('p_support_status', 'مدعوم')->get();
        $supporterComp = Projects::where('type_benef', 'جهة')->get();
        $supporterIndividual = Projects::where('type_benef', 'أفراد')->get();

        return view('dashboard.index', [
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'completed_projects' => $completed_projects,
            'stopped_projects' => $stopped_projects,
            'progress_projects' => $progress_projects,
            'supporter' => $supporter,
            'supporterComp' => $supporterComp,
            'supporterIndividual' => $supporterIndividual
        ]);
    }

    public function show($id)
    {
        $viewChart = $this->viewChartService->getProjectsIncome();

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

        return view('dashboard.show', [
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
        ]);
    }
}
