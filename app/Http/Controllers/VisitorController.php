<?php

namespace App\Http\Controllers;

use App\Models\ProjectPhases;
use App\Models\Projects;
use App\Models\ProjectSupporters;

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
        $supporterIndividual = Projects::where('type_benef', 'أفراد')->sum('p_num_beneficiaries');

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

    public function show()
    {
        $projects = Projects::all();
        if (!empty($projects)) {
            $dashboard = Projects::with('stageOfProject')->take(4)->get();
        }

        return view('dashboard.percentage-projects', [
            'projects' => $projects,
            'dashboard' => $dashboard
        ]);
    }
}
