<?php

namespace App\Services;

use App\Charts\ProjectsIncome;

class ViewChartService
{
    public function getProjectsIncome()
    {
        $borderColors = [
            "rgba(161, 227, 203, 1.0)",
            "rgba(78,184,188, 1.0)",
            "rgba(19, 126, 164, 1.0)",
            "rgba(182,215,227, 1.0)"
        ];
        $fillColors = [
            "rgba(161, 227, 203, 1.0)",
            "rgba(78,184,188, 1.0)",
            "rgba(19, 126, 164, 1.0)",
            "rgba(182,215,227, 1.0)"
        ];
        $chart = new ProjectsIncome;
        $chart->minimalist(true);
        $chart->labels(['سخي', 'نظام إدارة المحتوى', 'فرصة', 'وعي']);
        $chart->dataset('Users by trimester', 'doughnut', [50, 22.5, 30.8, 8.1])
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        return $chart;
    }
}
