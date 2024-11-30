<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\ProjectSupporters;
use App\Models\User;
use App\Services\ViewChartService;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private ViewChartService $viewChartService;

    public function __construct(ViewChartService $viewChartService)
    {
        $this->viewChartService = $viewChartService;
    }

    public function index()
    {
        $dashboard = [];
        /** @var \App\Models\User */
        $admin = Auth::user();

        $user = User::with('positions')->get();

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $projects = Projects::all();
        if (!empty($projects)) {
            $dashboard = Projects::with('stageOfProject')->first()->take(4)->get();
        }

        $completed_projects = Projects::where('project_status', 'مكتمل')->get();
        $stopped_projects = Projects::where('project_status', 'معلق')->get();
        $progress_projects = Projects::where('project_status', 'قيد التنفيذ')->get();

        $supporter = ProjectSupporters::where('p_support_status', 'مدعوم')->get();
        $supporterComp = Projects::where('type_benef', 'جهة')->get();
        $supporterIndividual = Projects::where('type_benef', 'أفراد')->get();

        return view('admin.index', [
            'user' => $user,
            'admin' => $admin,
            'projects' => $projects,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'completed_projects' => $completed_projects,
            'stopped_projects' => $stopped_projects,
            'progress_projects' => $progress_projects,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
            'supporter' => $supporter,
            'supporterComp' => $supporterComp,
            'supporterIndividual' => $supporterIndividual
        ]);
    }

    public function show()
    {
        $dashboard = [];
        $admin = Auth::user();

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $projects = Projects::all();
        if (!empty($projects)) {
            $dashboard = Projects::with('stageOfProject')->first()->take(4)->get();
        }

        return view('admin.percentage-projects', [
            'admin' => $admin,
            'chart' => $viewChart,
            'projects' => $projects,
            'dashboard' => $dashboard,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
        ]);
    }
}
