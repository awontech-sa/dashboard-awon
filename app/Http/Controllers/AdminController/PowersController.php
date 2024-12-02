<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\PowersSections;
use App\Models\PowersUserSections;
use App\Models\Projects;
use App\Models\User;
use App\Services\ViewChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PowersController extends Controller
{
    private ViewChartService $viewChartService;

    public function __construct(ViewChartService $viewChartService)
    {
        $this->viewChartService = $viewChartService;
    }

    public function index($id)
    {
        $admin = Auth::user();
        $powersSections = PowersSections::all();
        $projects = Projects::all();

        $userPermissions = User::with('powersSections')->where('id', $id)->first();

        $viewGrossAnnualIncome = $this->viewChartService->getGrossAnnualIncome();
        $viewCurrentGrossIncome = $this->viewChartService->getCurrentGrossIncome();
        return view('admin.powers', [
            'sections' => $powersSections,
            'userPermission' => $userPermissions,
            // 'projects' => $projects,
            'projects' => $projects,
            'id' => $id,
            'admin' => $admin,
            'viewGrossAnnualIncome' => $viewGrossAnnualIncome,
            'viewCurrentGrossIncome' => $viewCurrentGrossIncome,
            // 'userPermissions' => $userPermissions
        ]);
    }

    public function update(Request $request, $id)
    {

        if ($request->action === 'add') {
            PowersUserSections::firstOrCreate([
                'user_id' => $id,
                'powers_sections_id' => $request->input('section_id'),
                'permission' => $request->input('permission'),
            ]);
        } elseif ($request->action === 'remove') {
            PowersUserSections::where([
                'user_id' => $id,
                'powers_sections_id' => $request->input('section_id'),
                'permission' => $request->input('permission'),
            ])->delete();
        }
    }



    // public function store(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     if ($request->action === 'add') {
    //         foreach ($request->project_ids as $projectId) {
    //             foreach ($permissions as $permission) {
    //                 ProjectUserPower::firstOrCreate([
    //                     'user_id' => $user->id,
    //                     'project_id' => $projectId,
    //                     'powers_id' => $permission->id,
    //                 ]);
    //             }
    //         }
    //     } elseif ($request->action === 'remove') {
    //         ProjectUserPower::where('user_id', $user->id)
    //             ->whereIn('project_id', $request->project_ids)
    //             ->delete();
    //     }
    // }
}
