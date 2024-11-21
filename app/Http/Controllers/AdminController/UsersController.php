<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewUserRequest;
use App\Models\Departments;
use App\Models\Positions;
use App\Models\PositionUser;
use App\Models\PowersUserSections;
use App\Models\User;
use App\Services\ViewChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
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

        $users = User::with(['positions.department', 'projects'])->get();

        $adminPermission = PowersUserSections::where('user_id', $admin->id)->where('powers_sections_id', 1)->get(['permission']);

        return view('admin.users.index', [
            'admin' => $admin,
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
            'users' => $users,
            'adminPermission' => $adminPermission
        ]);
    }

    public function show($id)
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

    public function update(Request $request)
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
            'chart' => $viewChart,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ])->with('success_message', 'تم تحديث البيانات بنجاح');
    }

    public function showCreateUser()
    {
        /** @var \App\Models\User */
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

    public function create(NewUserRequest $request)
    {
        $data = $request->validated();

        $emailExist = User::where('email', $request->input("email"))->get();
        if (count($emailExist) !== 0) {
            return back()->with('error_message', 'الحساب مضاف مسبقًا');
        } else {
            $newUser = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'phone_number' => $data['phone_number'] ?? '',
                'x' => $data['x'] ?? '',
                'linkedin' => $data['linkedin'] ?? '',
                'profile_image' => $data['profile_image'] ?? '',
            ]);
            $newUser->assignRole('Employee');
        }

        $department = Departments::where('d_name', $request->input('department'))->get();

        if (count($department) === 0) {   //department not exist
            $newDepartment = Departments::create(['d_name' => $request->input('department')]);
            $newPosition = Positions::create([
                'p_name' => $request->input('position'),
                'department_id' => $newDepartment->id
            ]);
            PositionUser::create(['users_id' => $newUser->id, 'positions_id' => $newPosition->id]);
        } else {
            $newPosition = Positions::create([
                'p_name' => $request->input('position'),
                'department_id' => $department->last()->id
            ]);
            PositionUser::create(['users_id' => $newUser->id, 'positions_id' => $newPosition->id]);
        }

        return back()->with('success_message', 'تم إضافة الحساب بنجاح');
    }
}
