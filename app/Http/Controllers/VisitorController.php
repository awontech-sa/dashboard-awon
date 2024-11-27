<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\ProjectSupporters;
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

        $dashboard = Projects::with('stageOfProject')->get();

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
}
