<?php

namespace App\Http\Controllers;

use App\Models\ProjectPhases;
use App\Models\Projects;
use App\Models\ProjectSupporters;
use App\Models\ProjectUser;
use App\Services\ViewChartService;

class VisitorController extends Controller
{
    public function index()
    {
        $dashboard = [];

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
        $project = Projects::findOrFail($id);
        $dashboard = Projects::all();
        $phases = ProjectPhases::find($project->id);

        $supporter = $project->supporter()->first();

        $doneStages = $project->stages;
        $stages = $project->stage()->get()->map(function ($stage) {
            return ['stage_name' => $stage->stage_name];
        });

        $details = $project->details()->where('projects_id', $project->id)->first();

        if ($supporter) {
            $installment = $supporter->installments()->where('project_id', $project->id)->get();
        }

        $team = $project->members()->get()->map(function ($user) {
            return [
                'name' => $user->name,
                'role' => $user->pivot->role,
            ];
        });

        return view('dashboard.show', [
            'phases' => $phases,
            'project' => $project,
            'supporter' => $supporter,
            'projects' => $dashboard,
            'team' => $team,
            'details' => $details,
            'stages' => $stages,
            'doneStages' => $doneStages,
            'installment' => $installment,
        ]);
    }
}
