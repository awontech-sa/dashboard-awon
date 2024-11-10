<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Positions;
use App\Models\Powers;
use App\Models\PowersSections;
use App\Models\PowersUserSections;
use App\Models\Projects;
use App\Models\ProjectUserPower;
use App\Models\User;
use App\Services\ViewChartService;
use Illuminate\Http\Request;
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

        $user = User::with('positions')->findOrFail($admin->id);

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $position = $user->positions->pluck("p_name");

        return view('setting', [
            "position" => $position[0],
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

        $user->fill($request->only(['name', 'email', 'phone_number', 'x', 'linkedin']));

        if ($request->filled('position')) {
            foreach ($user->positions as $position) {
                Positions::where('p_name', $position->p_name)->update(['p_name' => $request->input('position')]);
            }
        }

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
            'position' => $position->p_name ?? null,
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

        $users = User::with(['positions.department', 'projects'])->get();

        $adminPermission = PowersUserSections::where('user_id', $admin->id)->first();

        return view('admin.users.index', [
            'admin' => $admin,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
            'users' => $users,
            'adminPermission' => $adminPermission
        ]);
    }

    public function showUser($id)
    {
        /** @var \App\Models\User */
        $admin = Auth::user();

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $user = User::with(['positions'])->where('id', $id)->get();
        $userPosition = [];

        foreach ($user as $u) {
            $userPosition = $u->positions;
        }

        return view('admin.users.user', [
            "id" => $id,
            "user" => $user,
            "userPosition" => $userPosition,
            "admin" => $admin,
            "chart" => $viewChart,
            "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
            "viewCurrentGrossIncome" => $viewCurrentGrossIncome
        ]);
    }

    public function showPowers($id)
    {
        $admin = Auth::user();

        $user = User::with(['powers', 'powersSections'])->find($id);

        $projects = Projects::all();

        $id = $user->id;

        $userPermissions = [];

        foreach ($user->powers as $power) {
            $sectionId = $power->pivot->powers_sections_id;

            $section = PowersSections::find($sectionId);

            $userPermissions[] = [
                'section_id' => $sectionId,
                'permission' => $power->p_name,
                'section' => $section ? $section->ps_name : 'Unknown section'
            ];
        }

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();
        return view('admin.powers', [
            'projects' => $projects,
            'id' => $id,
            'admin' => $admin,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
            'userPermissions' => $userPermissions
        ]);
    }

    public function updatePowers(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $sectionId = $request->input('section_id');
        $selectedPermission = $request->input('permission');

        $permission = Powers::where('p_name', $selectedPermission)->first();

        if ($permission && PowersSections::find($sectionId)) {
            $powersUserSection = PowersUserSections::where('user_id', $user->id)->where('powers_sections_id', $sectionId)->first();

            if ($powersUserSection) {
                $powersUserSection->update(['powers_id' => $permission->id]);
            }
        }
        return back()->with('success_message', 'تم تحديث البيانات بنجاح');
    }

    public function storeTechProjectsPower(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $permissions = Powers::whereIn('p_name', ['تعديل', 'حذف'])->get();

        if ($request->action === 'add') {
            foreach ($request->project_ids as $projectId) {
                foreach ($permissions as $permission) {
                    ProjectUserPower::firstOrCreate([
                        'user_id' => $user->id,
                        'project_id' => $projectId,
                        'powers_id' => $permission->id,
                    ]);
                }
            }
        } elseif ($request->action === 'remove') {
            ProjectUserPower::where('user_id', $user->id)
                ->whereIn('project_id', $request->project_ids)
                ->delete();
        }
    }

    public function showUpdateUser($id)
    {
        $admin = Auth::user();

        $user = User::with('positions')->findOrFail($id);

        $position = $user->positions->pluck("p_name");

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        return view('admin.users.update', [
            "position" => $position[0],
            "user" => $user,
            "id" => $id,
            "admin" => $admin,
            "chart" => $viewChart,
            "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
            "viewCurrentGrossIncome" => $viewCurrentGrossIncome
        ]);
    }

    public function updateUser(Request $request)
    {
        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $user = User::with('positions')->findOrFail($request->id);

        if ($request->filled('position')) {
            foreach ($user->positions as $position) {
                Positions::where('p_name', $position->p_name)->update(['p_name' => $request->input('position')]);
            }
        }


        $user->fill($request->only(['name', 'email', 'phone_number', 'x', 'linkedin']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('profile-image')) {
            $file = $request->file('profile-image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $user->profile_image = Storage::disk('digitalocean')->putFileAs('profile', $file, $filename);
        }

        $user->save();

        return back()->withInput([
            'position' => $position->p_name ?? null,
            'admin' => $user,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ])->with('success_message', 'تم تحديث البيانات بنجاح');
    }
}
