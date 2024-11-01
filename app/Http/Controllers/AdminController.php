<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Projects;
use App\Models\User;
use App\Services\ViewChartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $user = User::with('positions')->get();

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
            'user' => $user,
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

    public function updateSetting(UserRequest $request)
    {
        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $admin = Auth::user();
        $user = User::findOrFail($admin->id);

        // Use fill for simple fields
        $user->fill($request->only(['name', 'email', 'position', 'phone_number', 'x', 'linkedin']));

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Handle profile image upload
        if ($request->hasFile('profile-image')) {
            $file = $request->file('profile-image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $user->profile_image = Storage::disk('digitalocean')->putFileAs('profile', $file, $filename);
        }

        $user->save();

        return back()->withInput([
            'admin' => $user,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ])->with('success_message', 'تم تحديث البيانات بنجاح');
    }

    public function showUsers()
    {
        $admin = Auth::user();

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        // $users = User::all();
        $users = User::with(['positions.department', 'projects'])->get();
        // dd($users);
        return view('admin.users', [
            'admin' => $admin,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
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
