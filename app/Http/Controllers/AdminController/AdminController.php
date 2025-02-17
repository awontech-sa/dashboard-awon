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
        $stages = [];
        /** @var \App\Models\User */
        $admin = Auth::user();

        $user = User::with('positions')->get();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

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

        return view('admin.index', [
            'user' => $user,
            'admin' => $admin,
            'projects' => $projects,
            'dashboard' => $dashboard,
            'stages' => $stages,
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

        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $projects = Projects::all();
        if (!empty($projects)) {
            $dashboard = Projects::with('stageOfProject')->take(4)->get();
        }

        return view('admin.percentage-projects', [
            'admin' => $admin,
            'projects' => $projects,
            'dashboard' => $dashboard,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
        ]);
    }

    public function showIncome()
    {
        $admin = Auth::user();
        $projects = Projects::all();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        return view('admin.projects-income', [
            'projects' => $projects,
            'admin' => $admin,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ]);
    }
}
