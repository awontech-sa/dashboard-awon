<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Positions;
use App\Models\Projects;
use App\Models\User;
use App\Services\PermissionEmployeeService;
use App\Services\ViewChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
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
        $user = User::with('positions')->findOrFail($this->employee->id);
        $dashboard = Projects::with('stageOfProject')->get() ?? null;;

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $accounts = $this->permissionService->getAccountPermission($this->employee);
        $collection = $this->permissionService->getCollectionPermission($this->employee);

        $position = $user->positions->pluck("p_name");

        return view('employee.setting', [
            'accountsPermission' => $accounts->last(),
            'collectionPermission' => $collection->last(),
            "position" => $position[0],
            'employee' => $this->employee,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome
        ]);
    }

    public function update(SettingRequest $request)
    {
        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $user = User::findOrFail($this->employee->id);

        $user->fill($request->only(['name', 'email', 'phone_number', 'x', 'linkedin']));

        if ($request->filled('position')) {
            foreach ($user->positions as $position) {
                Positions::where('p_name', $position->p_name)->update(['p_name' => $request->input('position')]);
            }
        }

        if ($request->filled('phone_number') || $request->filled('x') || $request->filled('linkedin')) {
            $user->phone_number = $request->input('phone_number');
            $user->x = $request->input('x');
            $user->linkedin = $request->input('linkedin');
        }

        if ($request->filled('password')) {
            if ($request->input('password') !== $request->input('password_confirmation')) {
                return back()->with('error_message', 'كلمة المرور التي أدخلتها غير متوافقة');
            }
            $user->password = bcrypt($request->input('password'));
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
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
