<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\ProjectSupporters;
use App\Models\Stages;
use App\Models\TypeBenef;
use App\Services\ViewChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    private ViewChartService $viewChartService;

    public function __construct(ViewChartService $viewChartService)
    {
        $this->viewChartService = $viewChartService;
    }

    public function index($step = 1)
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

    public function create(Request $request, $step)
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
                'p_description' => $request->input('project-description'),
                'type_benef_id' => $supporter[0]->id,
                'p_num_beneficiaries' => $request->input('benef_number'),
                'p_duration' => $request->input('project-duration')
            ];
            session(['project_step1' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 2]);
        } elseif ($step == 2) {
            $validated = [];
            $reportFiles = [];
            $paymentFiles = [];

            for ($i = 1; $i <= $request->input('number-support'); $i++) {
                for ($j = 1; $j <= $request->input('countReport'); $j++) {
                    $reportFiles[] = [$request->input("installment-report-{$j}")];
                }
                for ($k = 1; $k <= $request->input('paymentCountFiles'); $k++) {
                    $paymentFiles[] = [$request->input("payment-report-{$k}")];
                }
                $validated[] = [
                    'comp_support' => $request->input("comp-support-{$i}"),   //الجهة الداعمة
                    'project_income_total' => $request->input("project-income-total-{$i}"),   //إجمالي مبلغ الدعم
                    'payment_count' => $request->input("payment-count-{$i}"),   //عدد الدفعات
                    'report_files' => $reportFiles,
                    'payment_order_files' => $paymentFiles
                ];
            }

            session(['project_step2' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 3]);
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

            foreach ($data['financial-data'][0]['payment_order_files'] as $key => $files) {
                $array[$key]['pyament-file'] = $files[0];
            }
            $paymentFiles = json_encode($array);

            if($data['financial-data']) {
                ProjectSupporters::create(['project_id' => 6, 'payment_order_files' => $paymentFiles]);
            }

            // Clear the session data after project creation
            session()->forget(['project_step1', 'project_step2', /* Add other steps here */]);

            return redirect()->route('admin.dashboard')->with('success', 'تم إنشاء المشروع بنجاح');
        }
    }
}
