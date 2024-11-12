<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Departments;
use App\Models\Positions;
use App\Models\PositionUser;
use App\Models\Powers;
use App\Models\PowersSections;
use App\Models\PowersUserSections;
use App\Models\Projects;
use App\Models\ProjectUserPower;
use App\Models\TypeBenef;
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


        return view('admin.index', [
            'user' => $user,
            'admin' => $admin,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'completed_projects' => $completed_projects,
            'stopped_projects' => $stopped_projects,
            'progress_projects' => $progress_projects,
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

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success_message', 'تم حذف الحساب بنجاح');
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

    public function showCreateUser()
    {
        $admin = Auth::user();
        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        return view('admin.users.create', [
            'admin' => $admin,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ]);
    }

    public function create(Request $request)
    {
        $admin = Auth::user();
        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $newUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password_confirmation'),
            'phone_number' => $request->input('phone-number'),
            'x' => $request->input('x'),
            'linkedin' => $request->input('linkedin'),
            'profile_image' => $request->file('profile-image'),
        ]);

        $department = Departments::where('d_name', $request->input('department'))->get();

        if (count($department) === 0) {
            Departments::create(['d_name' => $request->input('department')]);
        } else {
            $newPosition = Positions::create([
                'p_name' => $request->input('position'),
                'department_id' => $department->last()->id
            ]);
            PositionUser::create(['users_id' => $newUser->id, 'positions_id' => $newPosition->id]);
        }

        return back()->with('success_message', 'تم إضافة الحساب بنجاح');
    }

    public function showCreateProject($step = 1)
    {
        $admin = Auth::user();

        $typeBenef = TypeBenef::all();

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $data = session("project_step{$step}", []);

        switch ($step) {
            case 1:
                return view('admin.projects.create', [
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'typeBenef' => $typeBenef,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome
                ]);
            case 2:
                return view('admin.projects.create', [
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'typeBenef' => $typeBenef,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome
                ]);
                // Add cases for each step view
            default:
                return back();
        }
    }

    public function createProject(Request $request, $step)
    // {

    //     if (
    //         $request->input('project-name') === null || $request->input('start-project') === null ||
    //         $request->input('end-project') === null || $request->input('project-desription') === null ||
    //         $request->input('benef_number') === null
    //     ) {
    //         return back()->with('error_message', 'نرجوا إدخال البيانات الإجبارية (*)');
    //     } else {
    //         Projects::create([
    //             'p_name' => $request->input('project-name'),
    //             'p_date_start' => $request->input('start-project'),
    //             'p_date_end' => $request->input('end-project'),
    //             'p_remaining' => $request->input('project-remaining'),
    //             'p_description' => $request->input('project-desription'),
    //             'type_benef_id' => $supporter[0]->id,
    //             'p_num_beneficiaries' => $request->input('benef_number'),
    //             'p_duration' => $request->input('project-duration')
    //         ]);
    //         return back()->with('success_message', 'تم إضافة المشروع بنجاح');
    //     }
    // }
    {
        // Validate and store data in the session for each step
        if ($step == 1) {
            $supporter = TypeBenef::where('tb_name', $request->input('type-benef'))->get();

            $validated = [
                'p_name' => $request->input('project-name'),
                'p_date_start' => $request->input('start-project'),
                'p_date_end' => $request->input('end-project'),
                'p_remaining' => $request->input('project-remaining'),
                'p_description' => $request->input('project-desription'),
                'type_benef_id' => $supporter[0]->id,
                'p_num_beneficiaries' => $request->input('benef_number'),
                'p_duration' => $request->input('project-duration')
            ];
            session(['project_step1' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 2]);
        } elseif ($step == 2) {
            // Validation for step 2 (financial data) here
            $validated = $request->validate([
                // Add financial data fields validation here
            ]);
            session(['project_step2' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 3]);
        }
        // Continue adding elseif blocks for each step up to step 7
        elseif ($step == 7) {
            // Finalize and save project with all collected data
            $data = array_merge(
                session('project_step1', []),
                session('project_step2', []),
                // Merge other steps' data here
            );

            // Create the project with the combined data
            Projects::create($data);

            // Clear the session data after project creation
            session()->forget(['project_step1', 'project_step2', /* Add other steps here */]);

            return redirect()->route('admin.projects.index')->with('success', 'تم إنشاء المشروع بنجاح');
        }
    }
}
