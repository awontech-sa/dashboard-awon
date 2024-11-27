<?php

namespace App\Http\Controllers;

use App\Models\Projects;
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
}
