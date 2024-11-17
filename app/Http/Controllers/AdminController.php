<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Departments;
use App\Models\Positions;
use App\Models\PositionUser;
use App\Models\PowersUserSections;
use App\Models\Projects;
use App\Models\Stages;
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
        // $completed_projects = Projects::where('p_status', 'مكتمل')->get();
        // $stopped_projects = Projects::where('p_status', 'معلق')->get();
        // $progress_projects = Projects::where('p_status', 'قيد التنفيذ')->get();


        return view('admin.index', [
            'user' => $user,
            'admin' => $admin,
            'chart' => $viewChart,
            'dashboard' => $dashboard,
            // 'completed_projects' => $completed_projects,
            // 'stopped_projects' => $stopped_projects,
            // 'progress_projects' => $progress_projects,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
        ]);
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

        $projectStages = Stages::all();

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $data = session("project_step{$step}", []);

        switch ($step) {
            case 1:
                return view('admin.projects.create', [
                    'stages' => $projectStages,
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
                    'stages' => $projectStages,
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'typeBenef' => $typeBenef,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome
                ]);
            case 3:
                return view('admin.projects.create', [
                    'stages' => $projectStages,
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'typeBenef' => $typeBenef,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome
                ]);
            case 4:
                return view('admin.projects.create', [
                    'stages' => $projectStages,
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'typeBenef' => $typeBenef,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome
                ]);
            case 5:
                return view('admin.projects.create', [
                    'stages' => $projectStages,
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'typeBenef' => $typeBenef,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome
                ]);
            case 6:
                return view('admin.projects.create', [
                    'stages' => $projectStages,
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'typeBenef' => $typeBenef,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome
                ]);
            case 7:
                return view('admin.projects.create', [
                    'stages' => $projectStages,
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'typeBenef' => $typeBenef,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome
                ]);
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
            $supporters = [];
            $reportFiles = [];
            $countReport = 1;
            for ($i = 1; $i <= $request->input('number-support'); $i++) {
                dd($request->file(`installment-report-{$countReport}`));
                $supporters[] = [
                    'comp_support' => $request->input("comp-support-{$i}"),   //الجهة الداعمة
                    'project_income_total' => $request->input("project-income-total-{$i}"),   //إجمالي مبلغ الدعم
                    'payment_count' => $request->input("payment-count-{$i}"),   //عدد الدفعات
                    // 'report_files' => $reportFiles
                ];
            }
            dd("outside");
            // dd($request->input('buttonValue'));
            // session(['project_step2' => $validated]);
            // return redirect()->route('admin.create.project', ['step' => 3]);
        } elseif ($step == 3) {
            $validated = [
                'tech_offer' => $request->input('tech-offer'),
                'financial_offer' => $request->input('financial-offer'),
                'project_contract' => $request->input('project-contract'),
                'profile' => $request->input('profile'),
                'video' => $request->input('video'),
            ];
            session(['project_step3' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 4]);
        } elseif ($step == 4) {
            $validated = [
                'project_status' => $request->input('project-status'),
                'comment' => $request->input('comment')
            ];
            session(['project_step4' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 5]);
        } elseif ($step == 5) {
            // if (filled($request->input('stage-name')) && filled($request->input('stage-order'))) {
            //     Stages::create(['stage_name' => $request->input('stage-name'), 'stage_number' => $request->input('stage-order')]);
            // }
            // $stages = $request->input('stages');
            // if ($stages) {
            //     foreach ($stages as $s) {
            //         ProjectStages::create(['project_id' => 1, 'stage_id' => $s]);
            //     }
            // }
            $validated = [
                'project_status' => $request->input('project-status'),
                'comment' => $request->input('comment')
            ];
            session(['project_step5' => []]);
            return redirect()->route('admin.create.project', ['step' => 6]);
        } elseif ($step == 6) {
            $validated = [
                'program_language' => $request->input('program-language'),
                'framework' => $request->input('framework'),
                'github' => $request->input('github'),
                'link' => $request->input('link'),
                'android' => $request->input('android'),
                'link' => $request->input('link'),
                'ios' => $request->input('ios'),
                'dashboard' => $request->input('dashboard')
            ];
            session(['project_step6' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 7]);
        } elseif ($step == 7) {
            $data['general-data'] = session('project_step1');
            $data['financial-data'] = session('project_step2');
            dd($data['financial-data']);
            // Finalize and save project with all collected data
            // $data = array_merge(
            //     session('project_step1', []),
            //     session('project_step2', []),
            //     // Merge other steps' data here
            // );


            // Create the project with the combined data
            if ($data['general-data']) {
                Projects::create($data['general-data']);
            }

            // Clear the session data after project creation
            session()->forget(['project_step1', 'project_step2', /* Add other steps here */]);

            // return redirect()->route('admin.dashboard')->with('success', 'تم إنشاء المشروع بنجاح');
        }
    }

    protected function getFinancialData($request)
    {
        // Example: Get financial data based on the support type
        if ($request->input('support-type') == 'دعم كلي') {
            return [
                'num_entities' => $request->input('num-supporting-entities'),
                'total_cost' => $request->input('total-project-cost'),
                'installments' => $this->getInstallments($request), // Installments for full support
            ];
        } elseif ($request->input('support-type') == 'دعم جزئي') {
            return [
                'estimated_cost' => $request->input('estimated-project-cost'),
                'actual_cost' => $request->input('actual-project-cost'),
                'phases' => $this->getPhases($request), // Phases for partial support
            ];
        }
    }

    protected function getInstallments($request)
    {
        // Example: Gather installment data
        $installments = [];
        $numInstallments = $request->input('num-installments');
        for ($i = 1; $i <= $numInstallments; $i++) {
            $installments[] = [
                'installment_number' => $i,
                'amount' => $request->input("installment-{$i}-amount"),
                'receipt_status' => $request->input("installment-{$i}-receipt-status"),
                'receipt_proof' => $request->input("installment-{$i}-receipt-proof"),
            ];
        }
        return $installments;
    }

    protected function getPhases($request)
    {
        // Example: Gather phase data for partial support
        $phases = [];
        $numPhases = $request->input('num-phases');
        for ($i = 1; $i <= $numPhases; $i++) {
            $phases[] = [
                'phase_name' => $request->input("phase-{$i}-name"),
                'phase_cost' => $request->input("phase-{$i}-cost"),
                'disbursement_status' => $request->input("phase-{$i}-disbursement-status"),
                'disbursement_proof' => $request->input("phase-{$i}-disbursement-proof"),
            ];
        }
        return $phases;
    }

    public function finalCreateProject()
    {
        dd("hi");
    }
}
