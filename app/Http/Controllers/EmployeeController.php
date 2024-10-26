<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\User;
use App\Services\ViewChartService;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    private ViewChartService $viewChartService;

    public function __construct(ViewChartService $viewChartService)
    {
        $this->viewChartService = $viewChartService;
    }

    public function index()
    {
        /** @var \App\Models\User */
        $employee = Auth::user();

        $viewChart = $this->viewChartService->getProjectsIncome();

        $dashboard = Projects::all();
        $completed_projects = Projects::where('p_status', 'مكتمل')->get();
        $stopped_projects = Projects::where('p_status', 'معلق')->get();
        $progress_projects = Projects::where('p_status', 'قيد التنفيذ')->get();
        $support_projects = Projects::where('p_support', '1')->get();
        $benef_projects = Projects::where('p_type_beneficiaries', 'جهة')->get();


        return view('employee.index', [
            'employee' => $employee,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'completed_projects' => $completed_projects,
            'stopped_projects' => $stopped_projects,
            'progress_projects' => $progress_projects,
            'support_projects' => $support_projects,
            'benef_projects' => $benef_projects
        ]);
    }

    public function show()
    {
        $user = Auth::user();
        $projects = $user->projects; // This will give you a collection of the user's projects
        $progress_projects = $user->projects->where('p_status', 'قيد التنفيذ');
        $completed_projects = $user->projects->where('p_status', 'مكتمل');
        $stopped_projects = $user->projects->where('p_status', 'معلق');

        


        $viewChart = $this->viewChartService->getProjectsIncome();


        return view('employee.profile', ['employee' => $user, 'project' => $projects,  'chart' => $viewChart,
        'progress_projects' => $progress_projects, 'completed_projects' => $completed_projects, 'stopped_projects' => $stopped_projects]);
    }
}
