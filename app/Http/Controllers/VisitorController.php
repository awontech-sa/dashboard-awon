<?php

namespace App\Http\Controllers;

use App\Models\ProjectPhases;
use App\Models\Projects;
use App\Models\ProjectSupporters;
use App\Models\ProjectUser;
use App\Services\ViewChartService;

class VisitorController extends Controller
{
    private ViewChartService $viewChartService;

    public function __construct(ViewChartService $viewChartService)
    {
        $this->viewChartService = $viewChartService;
    }


    public function index()
    {
        $dashboard = [];

        $viewChart = $this->viewChartService->getProjectsIncome();

        $projects = Projects::all();
        if (!empty($projects)) {
            $dashboard = Projects::with('stageOfProject', 'stage')->take(4)->get();
        }

        $completed_projects = Projects::where('project_status', 'مكتمل')->get();
        $stopped_projects = Projects::where('project_status', 'معلق')->get();
        $progress_projects = Projects::where('project_status', 'قيد التنفيذ')->get();

        $supporter = ProjectSupporters::where('p_support_status', 'مدعوم')->get();
        $supporterComp = Projects::where('type_benef', 'جهة')->get();
        $supporterIndividual = Projects::where('type_benef', 'أفراد')->get();

        return view('dashboard.index', [
            'projects' => $projects,
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

        $doneStages = $project->stages;
        $stages = $project->stage()->get()->map(function($stage) {
            return ['stage_name' => $stage->stage_name];
        });

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
            'projects' => $dashboard,
            'files' => $files,
            'team' => $team,
            'details' => $details,
            'stages' => $stages,
            'doneStages' => $doneStages,
            'bigBoss' => $bigBoss,
            'installment' => $installment,
        ]);
    }

    public function showPercentage()
    {
        $viewChart = $this->viewChartService->getProjectsIncome();

        $projects = Projects::all();
        if (!empty($projects)) {
            $dashboard = Projects::with('stageOfProject')->take(4)->get();
        }

        return view('dashboard.percentage-projects', [
            'chart' => $viewChart,
            'projects' => $projects,
            'dashboard' => $dashboard,
        ]);
    }
}
