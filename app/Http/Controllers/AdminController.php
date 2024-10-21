<?php

namespace App\Http\Controllers;

use App\Models\Projects;
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
        /** @var \App\Models\User */
        $admin = Auth::user();

        $viewChart = $this->viewChartService->getProjectsIncome();

        $dashboard = Projects::all();
        $completed_projects = Projects::where('p_status', 'مكتمل')->get();
        $stopped_projects = Projects::where('p_status', 'معلق')->get();
        $progress_projects = Projects::where('p_status', 'قيد التنفيذ')->get();
        $support_projects = Projects::where('p_support', '1')->get();
        $benef_projects = Projects::where('p_type_beneficiaries', 'جهة')->get();


        return view('admin.index', [
            'admin' => $admin,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'completed_projects' => $completed_projects,
            'stopped_projects' => $stopped_projects,
            'progress_projects' => $progress_projects,
            'support_projects' => $support_projects,
            'benef_projects' => $benef_projects
        ]);
    }

    public function showUsers()
    {
        /** @var \App\Models\User */
        $admin = Auth::user();
        $users = User::all();
        $viewChart = $this->viewChartService->getProjectsIncome();

        return view('admin.users', ['users' => $users, 'admin' => $admin, 'chart' => $viewChart]);
    }
}
