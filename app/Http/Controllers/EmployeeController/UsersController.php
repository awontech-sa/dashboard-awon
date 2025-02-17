<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Positions;
use App\Models\PowersUserSections;
use App\Models\Projects;
use App\Models\User;
use App\Services\PermissionEmployeeService;
use App\Services\ViewChartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    private ViewChartService $viewChartService;
    private PermissionEmployeeService $permissionService;
    public $employee;

    public function __construct(ViewChartService $viewChartService, PermissionEmployeeService $permissionService)
    {
        $this->viewChartService = $viewChartService;
        $this->permissionService = $permissionService;

        /** @var \App\Models\User */
        $this->employee = Auth::user();
    }

    public function index()
    {
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $accounts = $this->permissionService->getAccountPermission($this->employee);
        $collection = $this->permissionService->getCollectionPermission($this->employee);

        $projects = Projects::all();

        $users = User::with(['positions.department', 'projects'])->get();

        $permission = PowersUserSections::where('user_id', $this->employee->id)->where('powers_sections_id', 1)->get(['permission']);

        return view('employee.users.index', [
            'permission' => $permission,
            'projects' => $projects,
            'accountsPermission' => $accounts,
            'collectionPermission' => $collection->last(),
            'employee' => $this->employee,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
            'users' => $users
        ]);
    }

    public function show($id)
    {
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $accounts = $this->permissionService->getAccountPermission($this->employee);
        $collection = $this->permissionService->getCollectionPermission($this->employee);

        $permission = PowersUserSections::where('user_id', $this->employee->id)->get(['permission']);

        $projects = Projects::all();

        $user = User::where('id', $id)->get();
        $userPosition = [];

        foreach ($user as $u) {
            $userPosition = $u->positions;
        }

        return view('employee.users.user', [
            'accountsPermission' => $accounts,
            'collectionPermission' => $collection->last(),
            "id" => $id,
            "user" => $user,
            'projects' => $projects,
            'permission' => $permission,
            "userPosition" => $userPosition,
            "employee" => $this->employee,
            "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
            "viewCurrentGrossIncome" => $viewCurrentGrossIncome
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success_message', 'تم حذف الحساب بنجاح');
    }

    public function showUpdateUser($id)
    {
        $user = User::with('positions')->findOrFail($id);

        $position = $user->positions->pluck("p_name");

        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $projects = Projects::all();

        $accounts = $this->permissionService->getAccountPermission($this->employee);
        $collection = $this->permissionService->getCollectionPermission($this->employee);

        return view('employee.users.update', [
            'accountsPermission' => $accounts,
            'collectionPermission' => $collection->last(),
            "position" => $position[0],
            "user" => $user,
            "id" => $id,
            "employee" => $this->employee,
            'projects' => $projects,
            "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
            "viewCurrentGrossIncome" => $viewCurrentGrossIncome
        ]);
    }

    public function update(SettingRequest $request)
    {
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
            $user->password = bcrypt($request->input('password'));
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
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ])->with('success_message', 'تم تحديث البيانات بنجاح');
    }
}
