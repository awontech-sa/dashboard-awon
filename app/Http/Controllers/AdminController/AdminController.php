<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\User;
use App\Services\ViewChartService;
use Illuminate\Support\Facades\Auth;

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
}
