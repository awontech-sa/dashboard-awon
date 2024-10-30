<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\User;
use App\Services\ViewChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

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
            'benef_projects' => $benef_projects,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
        ]);
    }

    public function showSetting()
    {
        /** @var \App\Models\User */
        $admin = Auth::user();

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();



        return view('setting', [
            'admin' => $admin,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ]);
    }

    public function updateSetting(Request $request)
    {
        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        /** @var \App\Models\User */
        $admin = Auth::user();

        $user = User::FindOrFail($admin->id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->position = $request->input('position');
        $user->phone_number = $request->input('phone-number');
        $user->x = $request->input('x');
        $user->linkedin = $request->input('linkedin');

        if ($request->has('profile-image')) {
            $file = $request->file('profile-image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            // $path= 'profile/';
            // $file->move($path, $filename);

            $user->profile_image = Storage::disk('digitalocean')->putFileAs('profile', $file, $filename);

            // $user->profile_image = $path.$filename;
        }

        $user->save();

        return view('setting', [
            'admin' => $user,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ]);
    }

    public function showUsers()
    {
        $admin = Auth::user();

        $viewChart = $this->viewChartService->getProjectsIncome();

        $users = User::all();
        return view('admin.users', [
            'admin' => $admin,
            'chart' => $viewChart,
            'users' => $users
        ]);
    }

    public function showPowers()
    {
        $admin = Auth::user();
        $viewChart = $this->viewChartService->getProjectsIncome();
        return view('admin.powers', ['admin' => $admin, 'chart' => $viewChart]);
    }
}
