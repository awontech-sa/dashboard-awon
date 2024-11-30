<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\ProjectPhases;
use App\Models\Projects;
use App\Models\ProjectSupporters;
use App\Models\ProjectUser;
use App\Models\Stages;
use App\Models\User;
use App\Services\ViewChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $users = User::all();
        $projects = Projects::all();

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
                    'projects' => $projects,
                    "chart" => $viewChart,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users
                ]);
            case 2:
                return view('admin.projects.create', [
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users
                ]);
            case 3:
                return view('admin.projects.create', [
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users
                ]);
            case 4:
                return view('admin.projects.create', [
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users
                ]);
            case 5:
                return view('admin.projects.create', [
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users
                ]);
            case 6:
                return view('admin.projects.create', [
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users
                ]);
            case 7:
                return view('admin.projects.create', [
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
                    "chart" => $viewChart,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users
                ]);
            default:
                return back();
        }
    }

    public function create(Request $request, $step)
    {
        if ($step == 1) {
            if (
                $request->input('project-name') === null || $request->input('start-project') === null ||
                $request->input('end-project') === null ||  $request->input('project-description') === null
                || $request->input('benef_number') === null
            ) {
                return back()->with('error_message', 'نرجوا إدخال البيانات الإجبارية (*)');
            } else {
                $validated = [
                    'p_name' => $request->input('project-name'),    //اسم المشروع
                    'p_num_beneficiaries' => $request->input('benef_number'),     //عدد المستفيدين
                    'p_date_start' => $request->input('start-project'),    //تاريخ بداية المشروع
                    'p_date_end' => $request->input('end-project'),    //تاريخ نهاية المشروع
                    'p_remaining' => $request->input('project-remaining'),     //المدة المتبقية
                    'p_description' => $request->input('project-description'),    //عن المشروع
                    'p_duration' => $request->input('project-duration'),      //مدة المشروع
                    'type_benef' => $request->input('type-benef'),     //نوع المستفيدين من المشروع
                ];
                session(['project_step1' => $validated]);
                return redirect()->route('admin.create.project', ['step' => 2]);
            }
        } elseif ($step == 2) {
            $validated = [];
            $reportFiles = [];
            $paymentFiles = [];
            $receiptProof = [];
            $disbursementProof = [];

            switch ($request->input('support-status')) {
                case 'مدعوم':
                    switch ($request->input('support-type')) {
                        case 'كلي':
                            if ($request->input('number-support') === null) {
                                $validated = [
                                    'p_support_type' => $request->input('support-type'),    //كلي أو جزئي
                                    'p_support_status' => $request->input('support-status')
                                ];
                            } else {
                                for ($i = 1; $i <= $request->input('number-support'); $i++) {
                                    if ($request->input("payment-count-{$i}") !== null) {
                                        for ($j = 1; $j <= $request->input("payment-count-{$i}"); $j++) {
                                            if ($request->hasFile("installment_files_{$i}_{$j}")) {
                                                $file = $request->file("installment_files_{$i}_{$j}");
                                                $fileName = time() . '.' . $file->getClientOriginalExtension();
                                                $receiptProof[] = [
                                                    'installment_amount' => $request->input("installment_amount_{$i}_{$j}") ?? 0,  //قيمة الدفعة
                                                    'installment_receipt_status' => $request->input("installment_status_{$i}_{$j}") ?? false,  //حالة استلام الدفعة
                                                    'receipt_proof' => Storage::disk('digitalocean')->putFileAs('receipts', $file, $fileName) ?? null
                                                ];
                                            }
                                        }
                                    }

                                    for ($j = 1; $j <= $request->input('countReport'); $j++) {
                                        if ($request->input('countReport') !== 0) {
                                            if ($request->hasFile("installment-report-{$j}")) {
                                                $file = $request->file("installment-report-{$j}");
                                                $fileName = time() . '.' . $file->getClientOriginalExtension();
                                                $reportFiles[] = Storage::disk('digitalocean')->putFileAs('reports', $file, $fileName) ?? null;
                                            }
                                        }
                                    }

                                    if ($request->input('paymentCountFiles') !== 0) {
                                        for ($k = 1; $k <= $request->input('paymentCountFiles'); $k++) {
                                            if ($request->hasFile("payment-report-{$k}")) {
                                                $file = $request->file("payment-report-{$k}");
                                                $fileName = time() . '.' . $file->getClientOriginalExtension();
                                                $paymentFiles[] = Storage::disk('digitalocean')->putFileAs('payments', $file, $fileName) ?? null;
                                            }
                                        }
                                    }
                                    $validated = [
                                        'supporter_number' => $request->input('number-support') ?? 0,
                                        'p_support_type' => $request->input('support-type') ?? null,      //كلي أو جزئي
                                        'p_support_status' => $request->input('support-status') ?? null,   //مدعوم أو غير مدعوم
                                        'total_cost' => $request->input('project-income') ?? null,  //إجمالي تكلفة المشروع
                                        'supporter_name' => $request->input("comp-support-{$i}") ?? null,   //الجهة الداعمة
                                        'support_amount' => $request->input("project-income-total-{$i}") ?? 0,   //إجمالي مبلغ الدعم
                                        'installments_count' => $request->input("payment-count-{$i}") ?? 0,   //عدد الدفعات
                                        'installments' => $receiptProof ?? [],
                                        'report_files' => $reportFiles ?? [],  //ملفات التقارير
                                        'payment_order_files' => $paymentFiles ?? []  //ملفات أوامر الصرف
                                    ];
                                }
                            }

                            break;
                        case 'جزئي':
                            if ($request->input('number-support') === null) {
                                $validated = [
                                    'p_support_type' => $request->input('support-type'),    //كلي أو جزئي
                                    'p_support_status' => $request->input('support-status')
                                ];
                            } else {
                                for ($i = 1; $i <= $request->input('number-support'); $i++) {
                                    if ($request->input("payment-count-{$i}") !== null) {
                                        for ($j = 1; $j <= $request->input("payment-count-{$i}"); $j++) {
                                            if ($request->hasFile("installment_files_{$i}_{$j}")) {
                                                $file = $request->file("installment_files_{$i}_{$j}");
                                                $fileName = time() . '.' . $file->getClientOriginalExtension();
                                                $receiptProof[] = [
                                                    'installment_amount' => $request->input("installment_amount_{$i}_{$j}") ?? 0,  //قيمة الدفعة
                                                    'installment_receipt_status' => $request->input("installment_status_{$i}_{$j}") ?? false,  //حالة استلام الدفعة
                                                    'receipt_proof' => Storage::disk('digitalocean')->putFileAs('receipts', $file, $fileName) ?? null
                                                ];
                                            }
                                        }
                                    }

                                    if ($request->input('countReport') !== 0) {
                                        for ($j = 1; $j <= $request->input('countReport'); $j++) {
                                            if ($request->hasFile("installment-report-{$j}")) {
                                                $file = $request->file("installment-report-{$j}");
                                                $fileName = time() . '.' . $file->getClientOriginalExtension();
                                                $reportFiles[] = Storage::disk('digitalocean')->putFileAs('reports', $file, $fileName);
                                            }
                                        }
                                    }

                                    if ($request->input('paymentCountFiles') !== 0) {
                                        for ($k = 1; $k <= $request->input('paymentCountFiles'); $k++) {
                                            if ($request->hasFile("payment-report-{$k}")) {
                                                $file = $request->file("payment-report-{$k}");
                                                $fileName = time() . '.' . $file->getClientOriginalExtension();
                                                $paymentFiles[] = Storage::disk('digitalocean')->putFileAs('payments', $file, $fileName);
                                            }
                                        }
                                    }

                                    if ($request->input("stages-count-{$i}") !== null) {
                                        for ($j = 1; $j <= $request->input("stages-count-{$i}"); $j++) {
                                            if ($request->hasFile("stages_files_{$i}_{$j}")) {
                                                $file = $request->file("stages_files_{$i}_{$j}");
                                                $fileName = time() . '.' . $file->getClientOriginalExtension();
                                                $disbursementProof[] = [
                                                    'expected_cost' => $request->input("project-expected-income-{$i}") ?? 0,  //تكلفة المشروع المتوقعة
                                                    'actual_cost' => $request->input("project-expected-real-{$i}") ?? 0,  //تكلفة المشروع الفعلية
                                                    'phase_cost' => $request->input("stages_amount_{$i}_{$j}") ?? 0,  //تكلفة المرحلة
                                                    'disbursement_status' => $request->input("stages_status_{$i}_{$j}") ?? false,  //حالة الصرف
                                                    'disbursement_proof' => Storage::disk('digitalocean')->putFileAs('proofs', $file, $fileName) ?? null
                                                ];
                                            }
                                        }
                                    }

                                    $validated = [
                                        'supporter_number' => $request->input('number-support') ?? 0,
                                        'p_support_type' => $request->input('support-type') ?? null,    //كلي أو جزئي
                                        'p_support_status' => $request->input('support-status') ?? false,
                                        'total_cost' => $request->input('project-income') ?? 0,  //إجمالي تكلفة المشروع
                                        'comp_support' => $request->input("comp-support-{$i}") ?? null,   //الجهة الداعمة
                                        'project_income_total' => $request->input("project-income-total-{$i}") ?? 0,   //إجمالي مبلغ الدعم
                                        'payment_count' => $request->input("payment-count-{$i}") ?? 0,   //عدد الدفعات
                                        'installments' => $receiptProof ?? [],
                                        'report_files' => $reportFiles ?? [],  //ملفات التقارير
                                        'payment_order_files' => $paymentFiles ?? [],  //ملفات أوامر الصرف
                                        'project_phases' => $disbursementProof ?? [], //ملفات إثبات الصرف
                                    ];
                                }
                            }
                            break;
                        default:
                            return back();
                    }
                    session(['project_step2' => $validated]);
                    return redirect()->route('admin.create.project', ['step' => 3]);
                    break;
                case 'غير مدعوم':
                    switch ($request->input('supporter')) {
                        case 'جهة خارجية':
                            if ($request->input("num-not-support") !== 0) {
                                for ($i = 1; $i <= $request->input("num-not-support"); $i++) {
                                    if ($request->hasFile("installment_files_0_{$i}")) {
                                        $file = $request->file("installment_files_0_{$i}");
                                        $fileName = time() . '.' . $file->getClientOriginalExtension();
                                        $receiptProof[] = [
                                            'installment_amount' => $request->input("installment_amount_0_{$i}") ?? 0,  //قيمة الدفعة
                                            'installment_receipt_status' => $request->input("installment_status_0_{$i}") ?? false,  //حالة استلام الدفعة
                                            'receipt_proof' => Storage::disk('digitalocean')->putFileAs('receipts', $file, $fileName) ?? null,
                                        ];
                                    }
                                    $receiptProof[] = [
                                        'installment_amount' => $request->input("installment_amount_0_{$i}") ?? 0,  //قيمة الدفعة
                                        'installment_receipt_status' => $request->input("installment_status_0_{$i}") ?? false
                                    ];
                                }
                            }

                            $validated = [
                                'supporter_name' => $request->input("comp-name") ?? null,  //اسم الجهة الداعمة
                                'total_cost' => $request->input("income-project") ?? 0,  //التكلفة الإجمالية
                                'installments_count' => $request->input("num-not-support") ?? 0,  //عدد الدفعات
                                'installments' => $receiptProof ?? [],
                                'p_support_status' => $request->input('support-status') ?? false,
                                'p_support_type' => $request->input('supporter') ?? null
                            ];
                            break;
                        case 'عون التقنية':
                            if ($request->input("stages-count-not-support") !== 0) {
                                for ($i = 1; $i <= $request->input("stages-count-not-support"); $i++) {
                                    if ($request->hasFile("stages_files_0_{$i}")) {
                                        $file = $request->file("stages_files_0_{$i}");
                                        $fileName = time() . '.' . $file->getClientOriginalExtension();
                                        $disbursementProof[] = [
                                            'phase_cost' => $request->input("stages_amount_0_{$i}") ?? 0,
                                            'disbursement_status' => $request->input("stages_status_0_{$i}") ?? false,  //حالة الصرف
                                            'disbursement_proof' => Storage::disk('digitalocean')->putFileAs('proofs', $file, $fileName) ?? null
                                        ];
                                    }
                                }
                            }

                            $validated = [
                                'expected_cost' => $request->input('project-expected-income-not-support') ?? 0.00,  //تكلفة المشرع المتوقعة
                                'actual_cost' => $request->input('project-real-income-not-support') ?? 0.00,
                                'project_phases' => $disbursementProof ?? [],
                                'p_support_status' => $request->input('support-status') ?? null,
                                'p_support_type' => $request->input('supporter') ?? null
                            ];
                            break;
                    }
                    session(['project_step2' => $validated]);
                    return redirect()->route('admin.create.project', ['step' => 3]);
                    break;
                default:
                    return back();
            }
        } elseif ($step == 3) {
            $validated = [];
            if ($request->hasFile('attachment-file')) {
                foreach ($request->file('attachment-file') as $key => $file) {
                    if ($file->isValid()) {
                        $fileName = time() . '.' . $key . '.' . $file->getClientOriginalExtension();
                        $validated[] = [
                            'file' => Storage::disk('digitalocean')->putFileAs('attachment', $file, $fileName) ?? null,
                            'file_name' => $request->input('file-name')[$key] ?? null
                        ];
                    }
                }
            }
            session(['project_step3' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 4]);
        } elseif ($step == 4) {
            $validated = [
                'project_status' => $request->input('project-status') ?? null,
                'comment' => $request->input('comment') ?? null
            ];
            session(['project_step4' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 5]);
        } elseif ($step == 5) {
            $validated = [
                'all-stages' => $request->input('array-stages'),
                'stages-done' => $request->input('stages-done')
            ];
            session(['project_step5' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 6]);
        } elseif ($step == 6) {
            $validated = [
                'program_language' => $request->input('program-language'),
                'framework' => $request->input('framework'),
                'github' => $request->input('github'),
                'link' => $request->input('link'),
                'ios' => $request->input('ios'),
                'android' => $request->input('android'),
                'dashboard' => $request->input('dashboard')
            ];
            session(['project_step6' => $validated]);
            return redirect()->route('admin.create.project', ['step' => 7]);
        } elseif ($step == 7) {
            $validated = [
                'role' => $request->input('array-members'),
                'project_manager' => $request->input('manager'),
                'sub_project_manager' => $request->input('sub-manager')
            ];
            session(['project_step7' => $validated]);

            $data['general-data'] = session('project_step1');
            $data['financial-data'] = session('project_step2');
            $data['attachment'] = session('project_step3');
            $data['status'] = session('project_step4');
            $data['level'] = session('project_step5');
            $data['code'] = session('project_step6');
            $data['team'] = session('project_step7');
            if (!empty($data['general-data'])) {
                $project = Projects::create($data['general-data']);

                if (!empty($data['financial-data'])) {
                    $reportFiles = isset($data['financial-data']["report_files"])
                        ? json_encode(array_map(fn($report) => ['report' => $report], $data['financial-data']["report_files"]))
                        : '[]';

                    $paymentOrderFiles = isset($data['financial-data']["payment_order_files"])
                        ? json_encode(array_map(fn($order) => ['payment_order' => $order], $data['financial-data']["payment_order_files"]))
                        : '[]';

                    $supporter = $project->supporter()->create([
                        'supporter_name' => $data['financial-data']["supporter_name"] ?? null,
                        'support_amount' => $data['financial-data']["support_amount"] ?? 0.00,
                        'installments_count' => $data['financial-data']["installments_count"] ?? 0,
                        'report_files' => $reportFiles,
                        'payment_order_files' => $paymentOrderFiles,
                        'p_support_type' => $data['financial-data']['p_support_type'] ?? null,
                        'p_support_status' => $data['financial-data']['p_support_status'] ?? null,
                        'supporter_number' => $data['financial-data']["supporter_number"] ?? 0
                    ]);
                    
                    Projects::where('id', $project->id)->update(['total_cost' => is_numeric(trim($data['financial-data']["total_cost"] ?? ''))
                        ? trim($data['financial-data']["total_cost"] ?? '') : null]);
                    if (!empty($data['financial-data']["installments"])) {
                        foreach ($data['financial-data']["installments"] as $installmentProject) {
                            $supporter->Installments()->create([
                                'project_id' => $project->id,
                                'installment_amount' => $installmentProject["installment_amount"] ?? 0,
                                'installment_receipt_status' => ($installmentProject['installment_receipt_status'] === "on") ? true : false,
                                'receipt_proof' => $installmentProject["receipt_proof"] ?? null,
                            ]);
                        }
                    }

                    if (!empty($data['financial-data']['project_phases'])) {
                        Projects::where('id', $project->id)->update([
                            'expected_cost' => $data['financial-data']['expected_cost'] ?? 0,
                            'actual_cost' => $data['financial-data']['actual_cost'] ?? 0
                        ]);
                        ProjectSupporters::where('project_id', $project->id)->update([
                            'p_support_type' => $data['financial-data']['p_support_type'] ?? null,
                            'p_support_status' => $data['financial-data']['p_support_status'] ?? null
                        ]);

                        foreach ($data['financial-data']['project_phases'] as $phase) {
                            ProjectPhases::create([
                                'project_id' => $project->id,
                                'phase_cost' => $phase['phase_cost'] ?? 0,
                                'disbursement_status' => ($phase['disbursement_status'] === 'on') ? true : false,
                                'disbursement_proof' => $phase['disbursement_proof']
                            ]);
                        }
                    }
                }

                if (!empty($data['attachment'])) {
                    foreach ($data['attachment'] as $attachment) {
                        $file = $request->file($attachment["file_name"]);
                        $project->files()->create([
                            'file' => $attachment["file"],
                            'file_name' => $attachment["file_name"],
                        ]);
                    }
                }

                if (!empty($data['status'])) {
                    Projects::where('id', $project->id)->update([
                        'project_status' => $data['status']['project_status'],
                        'comment' => $data['status']['comment']
                    ]);
                }

                if ($data['level']['all-stages'] !== null) {
                    foreach (json_decode($data['level']['all-stages']) as $level) {
                        Stages::create([
                            'stage_name' => $level->stage_name,
                            'stage_number' => $level->stage_number
                        ]);
                    }

                    if ($data['level']['stages-done'] !== null) {
                        foreach (json_decode($data['level']['stages-done']) as $done) {
                            $stageDone = Stages::where('stage_name', $done->stage_name)->first();
                            if ($stageDone) {
                                $project->stages()->attach($stageDone->id);
                            }
                        }
                    }
                }

                if (!empty($data['code'])) {
                    $project->details()->create([
                        'program_language' => $data['code']['program_language'],
                        "framework" => $data['code']['framework'],
                        "github" => $data['code']['github'],
                        "link" => $data['code']['link'],
                        "ios" => $data['code']['ios'],
                        "android" => $data['code']['android'],
                        "dashboard" => $data['code']['dashboard']
                    ]);
                }

                if (!empty($data['team'])) {
                    if ($data['team']['role'] !== '[]') {
                        $roles = json_decode($data['team']['role']);
                        $role = array_map(fn($r) => ['roles' => $r], $roles);

                        if (count($role) !== 0) {
                            foreach ($roles as $user) {
                                ProjectUser::create([
                                    'role' => $user->role,
                                    'user_id' => $user->id,
                                    'projects_id' => $project->id,
                                    'project_manager' => $data['team']['project_manager'],
                                    'sub_project_manager' => $data['team']['sub_project_manager']
                                ]);
                            }
                        }
                    } else {
                        $user = User::select('id')->where('name', $data['team']['project_manager'])->first();
                        if ($user) {
                            ProjectUser::create([
                                'user_id' => $user->id,
                                'projects_id' => $project->id,
                                'project_manager' => $data['team']['project_manager'],
                                'sub_project_manager' => $data['team']['sub_project_manager']
                            ]);
                        }
                    }
                }
            }
            session()->forget(['project_step1', 'project_step2', 'project_step3', 'project_step4', 'project_step5', 'project_step6', 'project_step7']);

            return redirect()->route('admin.dashboard')->with('success', 'تم إنشاء المشروع بنجاح');
        }
    }

    public function show($id)
    {
        $admin = Auth::user();
        $users = User::all();
        $project = Projects::findOrFail($id);
        $projects = Projects::all();
        $phases = ProjectPhases::find($project->id);
        $files = $project->files()->where('projects_id', $project->id)->get();

        $supporter = $project->supporter()->first();

        $stages = $project->stages;

        $details = $project->details()->where('projects_id', $project->id)->first();

        $installment = $supporter->installments()->where('project_id', $project->id)->get();

        $team = $project->members()->get()->map(function ($user) {
            return [
                'name' => $user->name,
                'role' => $user->pivot->role,
            ];
        });

        $bigBoss = ProjectUser::select('project_manager', 'sub_project_manager')->where('projects_id', $project->id)->first();

        $viewChart = $this->viewChartService->getProjectsIncome();
        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        return view('admin.projects.project.show', [
            "admin" => $admin,
            'phases' => $phases,
            'project' => $project,
            "chart" => $viewChart,
            'supporter' => $supporter,
            'projects' => $projects,
            'files' => $files,
            'team' => $team,
            'details' => $details,
            'stages' => $stages,
            'bigBoss' => $bigBoss,
            'installment' => $installment,
            "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
            "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
            'users' => $users
        ]);
    }

    public function destroy($id)
    {
        $project = Projects::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.dashboard')->with('success_message', 'تم حذف المشروع بنجاح');
    }
}
