<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Installments;
use App\Models\ProjectDetails;
use App\Models\ProjectFiles;
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
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users
                ]);
            case 2:
                return view('admin.projects.create', [
                    'step' => $step,
                    'data' => $data,
                    "admin" => $admin,
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
            $supporter = [];

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
                                            } else {
                                                $receiptProof[] = [
                                                    'installment_amount' => $request->input("installment_amount_{$i}_{$j}") ?? 0,  //قيمة الدفعة
                                                    'installment_receipt_status' => $request->input("installment_status_{$i}_{$j}") ?? false,  //حالة استلام الدفعة
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
                                    $supporter[] = [
                                        'supporter_name' => $request->input("comp-support-{$i}") ?? null,   //الجهة الداعمة
                                        'support_amount' => $request->input("project-income-total-{$i}") ?? 0,   //إجمالي مبلغ الدعم
                                        'installments_count' => $request->input("payment-count-{$i}") ?? 0,   //عدد الدفعات
                                        'installments' => $receiptProof ?? [],
                                        'report_files' => $reportFiles ?? [],  //ملفات التقارير
                                        'payment_order_files' => $paymentFiles ?? []  //ملفات أوامر الصرف
                                    ];

                                    $validated = [
                                        'supporter_number' => $request->input('number-support') ?? 0,
                                        'p_support_type' => $request->input('support-type') ?? null,      //كلي أو جزئي
                                        'p_support_status' => $request->input('support-status') ?? null,   //مدعوم أو غير مدعوم
                                        'total_cost' => $request->input('project-income') ?? null,  //إجمالي تكلفة المشروع
                                        'supporters' => $supporter
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
                                            } else {
                                                $receiptProof[] = [
                                                    'installment_amount' => $request->input("installment_amount_{$i}_{$j}") ?? 0,  //قيمة الدفعة
                                                    'installment_receipt_status' => $request->input("installment_status_{$i}_{$j}") ?? false,  //حالة استلام الدفعة
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
                                            } else {
                                                $disbursementProof[] = [
                                                    'expected_cost' => $request->input("project-expected-income-{$i}") ?? 0,  //تكلفة المشروع المتوقعة
                                                    'actual_cost' => $request->input("project-expected-real-{$i}") ?? 0,  //تكلفة المشروع الفعلية
                                                    'phase_cost' => $request->input("stages_amount_{$i}_{$j}") ?? 0,  //تكلفة المرحلة
                                                    'disbursement_status' => $request->input("stages_status_{$i}_{$j}") ?? false,  //حالة الصرف
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
                                for ($i = 1; $i <= $request->input("num-not-support"); $i++) {    //2
                                    if ($request->hasFile("installment_files_0_{$i}")) {
                                        $file = $request->file("installment_files_0_{$i}");
                                        $fileName = time() . '.' . $file->getClientOriginalExtension();
                                        $receiptProof[] = [
                                            'installment_amount' => $request->input("installment_amount_0_{$i}") ?? 0,  //قيمة الدفعة
                                            'installment_receipt_status' => $request->input("installment_status_0_{$i}") ?? false,  //حالة استلام الدفعة
                                            'receipt_proof' => Storage::disk('digitalocean')->putFileAs('receipts', $file, $fileName) ?? null,
                                        ];
                                    } else {
                                        $receiptProof[] = [
                                            'installment_amount' => $request->input("installment_amount_0_{$i}") ?? 0,  //قيمة الدفعة
                                            'installment_receipt_status' => $request->input("installment_status_0_{$i}") ?? false
                                        ];
                                    }
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
                                    } else {
                                        $disbursementProof[] = [
                                            'phase_cost' => $request->input("stages_amount_0_{$i}") ?? 0,
                                            'disbursement_status' => $request->input("stages_status_0_{$i}") ?? false,  //حالة الصرف
                                        ];
                                    }
                                }
                            }

                            $validated = [
                                'stages_count' => $request->input('stages-count-not-support') ?? 0,
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
                        $fileName = time() . '-' . $key . '.' . $file->getClientOriginalExtension();
                        $validated[] = [
                            'file' => Storage::disk('digitalocean')->putFileAs('attachment', $file, $fileName) ?? null,
                            'file_name' => $request->input('file-name')[$key] ?? null,
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
                'project_manager' => $request->input('managers'),
                'sub_project_manager' => $request->input('sub-managers')
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

                    if (isset($data['financial-data']['supporters'])) {
                        foreach ($data['financial-data']['supporters'] as $supporter) {
                            $s = $project->supporter()->create([
                                'supporter_name' => $supporter["supporter_name"] ?? null,
                                'support_amount' => $supporter["support_amount"] ?? 0.00,
                                'installments_count' => $supporter["installments_count"] ?? 0,
                                'report_files' => $reportFiles,
                                'payment_order_files' => $paymentOrderFiles,
                                'p_support_type' => $data['financial-data']['p_support_type'] ?? null,
                                'p_support_status' => $data['financial-data']['p_support_status'] ?? null,
                                'supporter_number' => $data['financial-data']["supporter_number"] ?? 0
                            ]);

                            if (!empty($supporter['installments'])) {
                                foreach ($supporter['installments'] as $installmentProject) {
                                    $project->supporter()->create(['supporter_name' => $supporter["supporter_name"]]);
                                    $s->installments()->create([
                                        'project_id' => $project->id,
                                        'installment_amount' => $installmentProject["installment_amount"] ?? 0,
                                        'installment_receipt_status' => ($installmentProject['installment_receipt_status'] === "on") ? true : false,
                                        'receipt_proof' => $installmentProject["receipt_proof"] ?? null,
                                    ]);
                                }
                            }
                        }
                    }

                    if (!empty($data['financial-data']["installments"])) {
                        $supporter = $project->supporter()->create([
                            'supporter_name' => $data['financial-data']['supporter_name'],
                            'p_support_status' => $data['financial-data']['p_support_status'],
                            'p_support_type' => $data['financial-data']['p_support_type'],
                            'installments_count' => $data['financial-data']['installments_count']
                        ]);
                        foreach ($data['financial-data']["installments"] as $installmentProject) {
                            $supporter->installments()->create([
                                'project_id' => $project->id,
                                'installment_amount' => $installmentProject["installment_amount"] ?? 0,
                                'installment_receipt_status' => ($installmentProject['installment_receipt_status'] === "on") ? true : false,
                                'receipt_proof' => $installmentProject["receipt_proof"] ?? null,
                            ]);
                        }
                        Projects::where('id', $project->id)->update(['total_cost' => is_numeric(trim($data['financial-data']["total_cost"] ?? ''))
                            ? trim($data['financial-data']["total_cost"] ?? '') : null]);
                    }

                    if (!empty($data['financial-data']['project_phases'])) {
                        Projects::where('id', $project->id)->update([
                            'expected_cost' => $data['financial-data']['expected_cost'] ?? 0,
                            'actual_cost' => $data['financial-data']['actual_cost'] ?? 0
                        ]);
                        $project->supporter()->create([
                            'p_support_type' => $data['financial-data']['p_support_type'] ?? null,
                            'p_support_status' => $data['financial-data']['p_support_status'] ?? null
                        ]);
                        foreach ($data['financial-data']['project_phases'] as $phase) {
                            ProjectPhases::create([
                                'stages_count' => $data['financial-data']['stages_count'],
                                'project_id' => $project->id,
                                'phase_cost' => $phase['phase_cost'] ?? 0,
                                'disbursement_status' => ($phase['disbursement_status'] === 'on') ? true : false,
                                'disbursement_proof' => $phase['disbursement_proof'] ?? ''
                            ]);
                        }
                    }
                    // else {
                    //     Projects::where('id', $project->id)->update([
                    //         'expected_cost' => $data['financial-data']['expected_cost'] ?? 0,
                    //         'actual_cost' => $data['financial-data']['actual_cost'] ?? 0
                    //     ]);
                    //     $project->supporter()->update([
                    //         'p_support_type' => $data['financial-data']['p_support_type'] ?? null,
                    //         'p_support_status' => $data['financial-data']['p_support_status'] ?? null
                    //     ]);
                    // }
                }

                if (!empty($data['attachment'])) {
                    foreach ($data['attachment'] as $attachment) {
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
                            'stage_number' => $level->stage_number,
                            'projects_id' => $project->id
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
                                    'projects_id' => $project->id
                                ]);
                            }
                        }
                    }

                    if ($data['team']['project_manager'] !== '[]') {
                        $managers = json_decode($data['team']['project_manager']);
                        $manager = array_map(fn($m) => ['manager' => $m], $managers);

                        if (count($manager) !== 0) {
                            foreach ($managers as $user) {
                                ProjectUser::create([
                                    'role' => $user->role,
                                    'user_id' => $user->id,
                                    'projects_id' => $project->id
                                ]);
                            }
                        }
                    }

                    if ($data['team']['sub_project_manager'] !== '[]') {
                        $subManagers = json_decode($data['team']['sub_project_manager']);
                        $subManager = array_map(fn($sm) => ['sub-manager' => $sm], $subManagers);

                        if (count($subManager) !== 0) {
                            foreach ($subManagers as $user) {
                                ProjectUser::create([
                                    'role' => $user->role,
                                    'user_id' => $user->id,
                                    'projects_id' => $project->id
                                ]);
                            }
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

        $supporter = $project->supporter()->get();

        $doneStages = $project->stages;
        $stages = $project->stage()->get()->map(function ($stage) {
            return ['stage_name' => $stage->stage_name];
        });

        $details = $project->details()->where('projects_id', $project->id)->first();

        $installment = Installments::where('project_id', $project->id)->get()->groupBy('project_supporters_id');

        $team = $project->members()->get()->map(function ($user) {
            return [
                'name' => $user->name,
                'role' => $user->pivot->role,
            ];
        });

        $phases = ProjectPhases::where('project_id', $id)->get();

        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        return view('admin.projects.project.show', [
            "admin" => $admin,
            'phases' => $phases,
            'project' => $project,
            'supporter' => $supporter,
            'projects' => $projects,
            'files' => $files,
            'doneStages' => $doneStages,
            'team' => $team,
            'details' => $details,
            'stages' => $stages,
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

    public function updateShow($step = 1, $id)
    {
        $dashboard = [];
        $admin = Auth::user();
        $users = User::all();
        $projects = Projects::all();

        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();

        $installment = Installments::where('project_id', $id)->get()->groupBy('project_supporters_id');

        $phases = ProjectPhases::where('project_id', $id)->get();

        $team = Projects::find($id)->members()->get()->map(function ($user) {
            return [
                'name' => $user->name,
                'role' => $user->pivot->role,
                'id' => $user->id
            ];
        });

        if (!empty($projects)) {
            $dashboard = Projects::with('stageOfProject', 'supporter', 'stage', 'files', 'details')->where('id', $id)->get();
        }

        $data = session("project_step{$step}", []);

        switch ($step) {
            case 1:
                return view('admin.projects.project.update.update', [
                    'step' => $step,
                    'dashboard' => $dashboard,
                    'data' => $data,
                    "admin" => $admin,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users,
                    'installment' => $installment,
                    'phases' => $phases,
                    'team' => $team
                ]);
            case 2:
                return view('admin.projects.project.update.update', [
                    'step' => $step,
                    'dashboard' => $dashboard,
                    'data' => $data,
                    "admin" => $admin,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users,
                    'installment' => $installment,
                    'phases' => $phases,
                    'team' => $team
                ]);
            case 3:
                return view('admin.projects.project.update.update', [
                    'step' => $step,
                    'dashboard' => $dashboard,
                    'data' => $data,
                    "admin" => $admin,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users,
                    'installment' => $installment,
                    'phases' => $phases,
                    'team' => $team
                ]);
            case 4:
                return view('admin.projects.project.update.update', [
                    'step' => $step,
                    'dashboard' => $dashboard,
                    'data' => $data,
                    "admin" => $admin,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users,
                    'installment' => $installment,
                    'phases' => $phases,
                    'team' => $team
                ]);
            case 5:
                return view('admin.projects.project.update.update', [
                    'step' => $step,
                    'dashboard' => $dashboard,
                    'data' => $data,
                    "admin" => $admin,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users,
                    'installment' => $installment,
                    'phases' => $phases,
                    'team' => $team
                ]);
            case 6:
                return view('admin.projects.project.update.update', [
                    'step' => $step,
                    'dashboard' => $dashboard,
                    'data' => $data,
                    "admin" => $admin,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users,
                    'installment' => $installment,
                    'phases' => $phases,
                    'team' => $team
                ]);
            case 7:
                return view('admin.projects.project.update.update', [
                    'step' => $step,
                    'dashboard' => $dashboard,
                    'data' => $data,
                    "admin" => $admin,
                    'projects' => $projects,
                    "viewGrossAnnualIncome" => $viewGrossAnnualIncome,
                    "viewCurrentGrossIncome" => $viewCurrentGrossIncome,
                    'users' => $users,
                    'installment' => $installment,
                    'phases' => $phases,
                    'team' => $team
                ]);
            default:
                return back();
        }
    }

    public function update(Request $request, $step, $id)
    {
        if ($step == 1) {
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
            return redirect()->route('admin.update.project', ['step' => 2, 'id' => $id]);
        } elseif ($step == 2) {
            $validated = [];
            $reportFiles = [];
            $paymentFiles = [];
            $receiptProof = [];
            $disbursementProof = [];
            $supporters = [];

            switch ($request->input('support-status')) {
                case 'مدعوم':
                    switch ($request->input('support-type')) {
                        case 'كلي':
                            if ($request->input('number-support') === 0) {
                                $validated = [
                                    'p_support_type' => $request->input('support-type'),    //كلي أو جزئي
                                    'p_support_status' => $request->input('support-status')
                                ];
                            } else {
                                for ($i = 1; $i <= $request->input('number-support'); $i++) {   //عدد الجهات الداعمة
                                    $receiptProof = [];
                                    if ($request->input("payment-count-{$i}") !== 0) {    //عدد الدفعات
                                        for ($j = 1; $j <= $request->input("payment-count-{$i}"); $j++) {
                                            if ($request->hasFile("payments.{$i}.{$j}.proof")) {
                                                $file = $request->file("payments.{$i}.{$j}.proof");
                                                $fileName = time() . '.' . $file->getClientOriginalExtension();
                                                $receiptProof[] = [
                                                    'amount' => $request->input("payments.{$i}.{$j}.amount") ?? 0,  //قيمة الدفعة
                                                    'status' => $request->input("payments.{$i}.{$j}.status") ?? false,  //حالة استلام الدفعة
                                                    'proof' => Storage::disk('digitalocean')->putFileAs('receipts', $file, $fileName) ?? null
                                                ];
                                            } else {
                                                $receiptProof[] = [
                                                    'amount' => $request->input("payments.{$i}.{$j}.amount") ?? 0,  //قيمة الدفعة
                                                    'status' => $request->input("payments.{$i}.{$j}.status") ?? false,  //حالة استلام الدفعة
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
                                    $supporters[] = [
                                        'supporter_name' => $request->input("comp-support-{$i}") ?? null,   //الجهة الداعمة
                                        'support_amount' => $request->input("project-income-total-{$i}") ?? 0,   //إجمالي مبلغ الدعم
                                        'installments_count' => $request->input("payment-count-{$i}") ?? 0,   //عدد الدفعات
                                        'installments' => $receiptProof ?? [],
                                        'report_files' => $reportFiles ?? [],  //ملفات التقارير
                                        'payment_order_files' => $paymentFiles ?? []  //ملفات أوامر الصرف
                                    ];
                                }
                                $validated = [
                                    'supporter_number' => $request->input('number-support') ?? 0,
                                    'p_support_type' => $request->input('support-type') ?? null,      //كلي أو جزئي
                                    'p_support_status' => $request->input('support-status') ?? null,   //مدعوم أو غير مدعوم
                                    'total_cost' => $request->input('project-income') ?? null,  //إجمالي تكلفة المشروع
                                    'supporters' => $supporters
                                ];
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
                                            } else {
                                                $receiptProof[] = [
                                                    'installment_amount' => $request->input("installment_amount_{$i}_{$j}") ?? 0,  //قيمة الدفعة
                                                    'installment_receipt_status' => $request->input("installment_status_{$i}_{$j}") ?? false,  //حالة استلام الدفعة
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
                                            } else {
                                                $disbursementProof[] = [
                                                    'expected_cost' => $request->input("project-expected-income-{$i}") ?? 0,  //تكلفة المشروع المتوقعة
                                                    'actual_cost' => $request->input("project-expected-real-{$i}") ?? 0,  //تكلفة المشروع الفعلية
                                                    'phase_cost' => $request->input("stages_amount_{$i}_{$j}") ?? 0,  //تكلفة المرحلة
                                                    'disbursement_status' => $request->input("stages_status_{$i}_{$j}") ?? false,  //حالة الصرف
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
                    return redirect()->route('admin.update.project', ['step' => 3, 'id' => $id]);
                    break;
                case 'غير مدعوم':
                    switch ($request->input('supporter')) {
                        case 'جهة خارجية':
                            if ($request->input("num-not-support") !== 0) {
                                for ($i = 0; $i < $request->input("num-not-support"); $i++) {
                                    if ($request->hasFile("installments.{$i}.proof")) {
                                        $file = $request->file("installments.{$i}.proof");
                                        $fileName = time() . '_' . $i . '.' . $file->getClientOriginalExtension();
                                        $receiptProof[] = [
                                            'amount' => $request->input("installments.{$i}.amount") ?? 0,  //قيمة الدفعة
                                            'status' => $request->input("installments.{$i}.status") ?? false,  //حالة استلام الدفعة
                                            'proof' => Storage::disk('digitalocean')->putFileAs('receipts', $file, $fileName) ?? null
                                        ];
                                    } else {
                                        $receiptProof[] = [
                                            'amount' => $request->input("installments.{$i}.amount") ?? 0,  //قيمة الدفعة
                                            'status' => $request->input("installments.{$i}.status") ?? false,  //حالة استلام الدفعة
                                        ];
                                    }
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
                                for ($i = 0; $i < $request->input("stages-count-not-support"); $i++) {
                                    if ($request->hasFile("phases.{$i}.proof")) {
                                        $file = $request->file("phases.{$i}.proof");
                                        $fileName = time() . '.' . $file->getClientOriginalExtension();
                                        $disbursementProof[] = [
                                            'amount' => $request->input("phases.{$i}.amount") ?? 0,
                                            'status' => $request->input("phases.{$i}.status") ?? false,  //حالة الصرف
                                            'proof' => Storage::disk('digitalocean')->putFileAs('proofs', $file, $fileName) ?? null
                                        ];
                                    } else {
                                        $disbursementProof[] = [
                                            'amount' => $request->input("phases.{$i}.amount") ?? 0,
                                            'status' => $request->input("phases.{$i}.status") ?? false  //حالة الصرف
                                        ];
                                    }
                                }
                            }

                            $validated = [
                                'stages_count' => $request->input('stages-count-not-support') ?? 0,
                                'expected_cost' => $request->input('project-expected-income-not-support') ?? 0.00,  //تكلفة المشرع المتوقعة
                                'actual_cost' => $request->input('project-real-income-not-support') ?? 0.00,
                                'project_phases' => $disbursementProof ?? [],
                                'p_support_status' => $request->input('support-status') ?? null,
                                'p_support_type' => $request->input('supporter') ?? null
                            ];
                            break;
                    }
                    session(['project_step2' => $validated]);
                    return redirect()->route('admin.update.project', ['step' => 3, 'id' => $id]);
                    break;
                default:
                    return back();
            }
            return redirect()->route('admin.update.project', ['step' => 3, 'id' => $id]);
        } elseif ($step == 3) {
            $validated = [];

            if ($request->hasFile('attachment-file')) {
                foreach ($request->file('attachment-file') as $key => $file) {
                    if ($file->isValid()) {
                        $fileName = time() . '-' . $key . '.' . $file->getClientOriginalExtension();
                        $filePath = Storage::disk('digitalocean')->putFileAs('attachment', $file, $fileName);
                        $validated[] = [
                            'file' => $filePath ?? null,
                            'file_name' => $request->input('file-name')[$key] ?? null,
                        ];
                    }
                }
            } else if ($request->has('deleted_files')) {
                foreach ($request->input('deleted_files') as $fileId) {
                    $fileRecord = ProjectFiles::find($fileId);
                    if ($fileRecord) {
                        Storage::disk('digitalocean')->delete($fileRecord->file);
                        $fileRecord->delete();
                    }
                    $validated = $fileRecord;
                }
            }
            session(['project_step3' => $validated]);
            return redirect()->route('admin.update.project', ['step' => 4, 'id' => $id]);
        } elseif ($step == 4) {
            $validated = [
                'project_status' => $request->input('project-status') ?? null,
                'comment' => $request->input('comment') ?? null
            ];
            session(['project_step4' => $validated]);
            return redirect()->route('admin.update.project', ['step' => 5, 'id' => $id]);
        } elseif ($step == 5) {
            $validated = [
                'all-stages' => $request->input('array-stages'),
                'stages-done' => $request->input('stages-done'),
                'stages-removed' => $request->input('stages-removed'),
                'stages-add' => $request->input('stages-add')
            ];
            session(['project_step5' => $validated]);
            return redirect()->route('admin.update.project', ['step' => 6, 'id' => $id]);
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
            return redirect()->route('admin.update.project', ['step' => 7, 'id' => $id]);
        } elseif ($step == 7) {
            $validated = [
                'members' => $request->input('array-members'),
                'delete_members' => $request->input('delete-members'),
                'project_manager' => $request->input('managers'),
                'sub_project_manager' => $request->input('sub-managers')
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
                Projects::where('id', $id)->update($data['general-data']);
                $project = Projects::findOrFail($id);

                if (!empty($data['financial-data'])) {
                    $reportFiles = isset($data['financial-data']["report_files"])
                        ? json_encode(array_map(fn($report) => ['report' => $report], $data['financial-data']["report_files"]))
                        : '[]';

                    $paymentOrderFiles = isset($data['financial-data']["payment_order_files"])
                        ? json_encode(array_map(fn($order) => ['payment_order' => $order], $data['financial-data']["payment_order_files"]))
                        : '[]';

                    if (isset($data['financial-data']['supporters'])) {
                        $submittedSupporters = $data['financial-data']['supporters'];
                        $currentSupporters = $project->supporter()->get();
                        foreach ($submittedSupporters as $index => $supporter) {
                            $existingSupporter = $currentSupporters->skip($index)->first();
                            if ($existingSupporter) {
                                $existingSupporter->update([
                                    'supporter_name' => $supporter["supporter_name"] ?? null,
                                    'support_amount' => $supporter["support_amount"] ?? 0.00,
                                    'installments_count' => $supporter["installments_count"] ?? 0,
                                    'report_files' => $reportFiles,
                                    'payment_order_files' => $paymentOrderFiles,
                                    'p_support_type' => $data['financial-data']['p_support_type'] ?? null,
                                    'p_support_status' => $data['financial-data']['p_support_status'] ?? null,
                                    'supporter_number' => $data['financial-data']["supporter_number"] ?? 0,
                                ]);
                            } else {
                                $project->supporter()->create([
                                    'supporter_name' => $supporter["supporter_name"] ?? null,
                                    'support_amount' => $supporter["support_amount"] ?? 0.00,
                                    'installments_count' => $supporter["installments_count"] ?? 0,
                                    'report_files' => $reportFiles,
                                    'payment_order_files' => $paymentOrderFiles,
                                    'p_support_type' => $data['financial-data']['p_support_type'] ?? null,
                                    'p_support_status' => $data['financial-data']['p_support_status'] ?? null,
                                    'supporter_number' => $data['financial-data']["supporter_number"] ?? 0,
                                ]);
                            }
                            if (!empty($supporter["installments"])) {
                                $currentSupporter = ProjectSupporters::where('projects_id', $id)
                                    ->where('supporter_name', $supporter["supporter_name"])
                                    ->first();
                                if (!$currentSupporter) {
                                    continue;
                                }
                                $existingInstallments = $currentSupporter->installments;
                                foreach ($supporter["installments"] as $index => $installmentProject) {
                                    $existingInstallment = $existingInstallments->where('installment_number', $index + 1)->first();
                                    $installmentData = [
                                        'project_id' => $id,
                                        'installment_number' => $index + 1,
                                        'installment_amount' => $installmentProject["amount"] ?? 0,
                                        'installment_receipt_status' => isset($installmentProject['status']),
                                        'receipt_proof' => $installmentProject["proof"] ?? null,
                                    ];
                                    if ($existingInstallment) {
                                        $existingInstallment->update($installmentData);
                                    } else {
                                        $currentSupporter->installments()->create($installmentData);
                                    }
                                }
                                $existingInstallments->filter(function ($installment) use ($supporter) {
                                    return !isset($supporter["installments"][$installment->installment_number - 1]);
                                })->each->delete();
                            }
                        }
                        if ($currentSupporters->count() > count($submittedSupporters)) {
                            $currentSupporters->splice(count($submittedSupporters))->each->delete();
                        }
                    }

                    Projects::where('id', $id)->update(['total_cost' => is_numeric(trim($data['financial-data']["total_cost"] ?? ''))
                        ? trim($data['financial-data']["total_cost"] ?? '') : null]);
                    if (!empty($data['financial-data']["installments"])) {
                        $existingInstallments = ProjectSupporters::where('projects_id', $id)->first()->installments;

                        foreach ($data['financial-data']["installments"] as $index => $installmentProject) {
                            $existingInstallment = $existingInstallments->where('installment_number', $index + 1)->first();

                            if ($existingInstallment) {
                                $existingInstallment->update([
                                    'installment_amount' => $installmentProject["amount"] ?? 0,
                                    'installment_receipt_status' => isset($installmentProject['status']) ? true : false,
                                    'receipt_proof' => $installmentProject["proof"] ?? null,
                                ]);
                            } else {
                                $supporter = ProjectSupporters::where('projects_id', $id)->first();
                                $supporter->update([
                                    'p_support_status' => $data['financial-data']['p_support_status'],
                                    'p_support_type' => $data['financial-data']['p_support_type'],
                                ]);
                                $supporter->installments()->create([
                                    'project_id' => $id,
                                    'installment_amount' => $installmentProject["amount"] ?? 0,
                                    'installment_receipt_status' => isset($installmentProject['status']) ? true : false,
                                    'receipt_proof' => $installmentProject["proof"] ?? null,
                                ]);
                            }
                        }

                        foreach ($existingInstallments as $existingInstallment) {
                            if (!isset($data['financial-data']["installments"][$existingInstallment->installment_number - 1])) {
                                $existingInstallment->delete();
                            }
                        }
                    }

                    if (!empty($data['financial-data']['project_phases'])) {
                        Projects::where('id', $project->id)->update([
                            'expected_cost' => $data['financial-data']['expected_cost'] ?? 0,
                            'actual_cost' => $data['financial-data']['actual_cost'] ?? 0,
                        ]);

                        ProjectSupporters::where('projects_id', $project->id)->update([
                            'p_support_type' => $data['financial-data']['p_support_type'] ?? null,
                            'p_support_status' => $data['financial-data']['p_support_status'] ?? null,
                        ]);

                        $existingPhases = ProjectPhases::where('project_id', $project->id)->get();
                        $newPhases = $data['financial-data']['project_phases'];
                        $newPhasesCount = count($newPhases);

                        foreach ($newPhases as $key => $phase) {
                            $disbursementProof = $phase['proof'] ?? null;

                            ProjectPhases::updateOrCreate(
                                [
                                    'project_id' => $project->id,
                                    'id' => $existingPhases[$key]->id ?? null, // Match by ID if exists
                                ],
                                [
                                    'phase_cost' => $phase['amount'] ?? 0,
                                    'disbursement_status' => isset($phase['status']) && $phase['status'] === 'on',
                                    'disbursement_proof' => $disbursementProof,
                                    'stages_count' => $newPhasesCount, // Store the count of phases
                                ]
                            );
                        }

                        if ($existingPhases->count() > $newPhasesCount) {
                            $phasesToDelete = $existingPhases->slice($newPhasesCount);
                            ProjectPhases::whereIn('id', $phasesToDelete->pluck('id'))->delete();
                        }
                    } else {
                        Projects::where('id', $project->id)->update([
                            'expected_cost' => $data['financial-data']['expected_cost'] ?? 0,
                            'actual_cost' => $data['financial-data']['actual_cost'] ?? 0,
                        ]);
                        ProjectSupporters::where('projects_id', $project->id)->update([
                            'p_support_type' => $data['financial-data']['p_support_type'] ?? null,
                            'p_support_status' => $data['financial-data']['p_support_status'] ?? null,
                        ]);
                    }
                }

                if (!empty($data['attachment'])) {
                    foreach ($data['attachment'] as $attachment) {
                        if (is_array($attachment) && isset($attachment["file"], $attachment["file_name"])) {
                            $project->files()->create([
                                'file' => $attachment["file"],
                                'file_name' => $attachment["file_name"],
                            ]);
                        }
                    }
                }

                if (!empty($data['status'])) {
                    Projects::where('id', $id)->update([
                        'project_status' => $data['status']['project_status'],
                        'comment' => $data['status']['comment']
                    ]);
                }

                if ($data['level']['stages-add'] !== null) {
                    foreach (json_decode($data['level']['stages-add']) as $level) {
                        Stages::create([
                            'projects_id' => $id,
                            'stage_name' => $level->stage_name,
                            'stage_number' => $level->stage_number,
                        ]);
                    }
                }

                if ($data['level']['stages-done'] !== null) {
                    foreach (json_decode($data['level']['stages-done']) as $done) {
                        $stageDone = Stages::where('stage_name', $done->stage_name)->first();
                        if ($stageDone) {
                            $p = Projects::find($id);
                            if ($p) {
                                $p->stages()->attach($stageDone->id);
                            }
                        }
                    }
                }

                if ($data['level']['stages-removed'] !== null) {
                    foreach (json_decode($data['level']['stages-removed']) as $removed) {
                        $stageRemove = Stages::where('stage_name', $removed->stage_name)->first();
                        if ($stageRemove) {
                            $p = Projects::find($id);
                            if ($p) {
                                $p->stages()->detach($stageRemove->id);
                            }
                        }
                        Stages::where([
                            ['stage_name', '=', $removed->stage_name],
                            ['projects_id', '=', $project->id]
                        ])->delete();
                    }
                }

                if ($data['level']['all-stages'] !== null) {
                    foreach (json_decode($data['level']['all-stages']) as $stage) {
                        $uncheckStage = Stages::where('stage_name', $stage->stage_name)->first();
                        if ($uncheckStage) {
                            $p = Projects::find($id);
                            if ($p) {
                                $p->stages()->detach($uncheckStage->id);
                            }
                        }
                    }
                }

                if (!empty($data['code'])) {
                    ProjectDetails::where('projects_id', $id)->update([
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
                    if ($data['team']['members'] !== '[]') {
                        $roles = json_decode($data['team']['members']);
                        $role = array_map(fn($r) => ['members' => $r], $roles);
                        if (count($role) !== 0) {
                            foreach ($roles as $user) {
                                ProjectUser::create([
                                    'role' => $user->role,
                                    'user_id' => $user->id,
                                    'projects_id' => $project->id
                                ]);
                            }
                        }
                    }

                    if ($data['team']['delete_members'] !== '[]') {
                        $roles = json_decode($data['team']['delete_members']);
                        $role = array_map(fn($r) => ['members' => $r], $roles);

                        if (count($role) !== 0) {
                            foreach ($roles as $user) {
                                $memberRemove = User::where('name', $user->name)->first();
                                if ($memberRemove) {
                                    $p = Projects::find($id);
                                    if ($p) {
                                        $p->members()->detach($memberRemove->id);
                                    }
                                }
                            }
                        }
                    }

                    if ($data['team']['project_manager'] !== '[]') {
                        $managers = json_decode($data['team']['project_manager']);
                        $projectManagerIds = array_map(fn($m) => $m->id, $managers);

                        // Remove existing managers for the project
                        ProjectUser::where('projects_id', $project->id)
                            ->where('role', 'manager')
                            ->whereNotIn('user_id', $projectManagerIds)
                            ->delete();

                        // Add or update the manager(s)
                        foreach ($managers as $manager) {
                            ProjectUser::updateOrCreate(
                                [
                                    'projects_id' => $project->id,
                                    'user_id' => $manager->id,
                                    'role' => 'manager'
                                ],
                                [
                                    'user_id' => $manager->id,
                                    'projects_id' => $project->id,
                                    'role' => 'manager'
                                ]
                            );
                        }
                    }

                    if ($data['team']['sub_project_manager'] !== '[]') {
                        $subManagers = json_decode($data['team']['sub_project_manager']);
                        $subManagerIds = array_map(fn($sm) => $sm->id, $subManagers);

                        // Remove existing sub-managers for the project
                        ProjectUser::where('projects_id', $project->id)
                            ->where('role', 'sub manager')
                            ->whereNotIn('user_id', $subManagerIds)
                            ->delete();

                        // Add or update the sub-manager(s)
                        foreach ($subManagers as $subManager) {
                            ProjectUser::updateOrCreate(
                                [
                                    'projects_id' => $project->id,
                                    'user_id' => $subManager->id,
                                    'role' => 'sub manager'
                                ],
                                [
                                    'user_id' => $subManager->id,
                                    'projects_id' => $project->id,
                                    'role' => 'sub manager'
                                ]
                            );
                        }
                    }
                }
            }
        }
        session()->forget(['project_step1', 'project_step2', 'project_step3', 'project_step4', 'project_step5', 'project_step6', 'project_step7']);

        return redirect()->route('admin.dashboard')->with('success', 'تم إنشاء المشروع بنجاح');
    }
}
