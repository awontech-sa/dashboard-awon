<?php

namespace App\Services;

use App\Charts\CurrentGrossIncome;
use App\Charts\GrossAnnualIncome;
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
        $chart->dataset('Users by trimester', 'doughnut', [0, 0, 0, 0])
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        return $chart;
    }

    public function getGrossAnnualIncome()
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

        $grossAnnualIncomeChart = new GrossAnnualIncome;
        $grossAnnualIncomeChart->minimalist(true);
        $grossAnnualIncomeChart->labels(['2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025']);
        $grossAnnualIncomeChart->dataset('Users by trimester', 'line', [0, 0, 0, 0, 0])->color($borderColors)
            ->backgroundcolor($fillColors);

        return $grossAnnualIncomeChart;
    }

    public function getCurrentGrossIncome()
    {
        $borderColors = [
            "rgba(161, 227, 203, 1.0)",
            "rgba(78,184,188, 1.0)"
        ];
        $fillColors = [
            "rgba(161, 227, 203, 1.0)",
            "rgba(78,184,188, 1.0)"
        ];

        $currentGrossIncome = new CurrentGrossIncome;
        $currentGrossIncome->minimalist(true);
        $currentGrossIncome->labels(['الربح', 'المحصل']);
        $currentGrossIncome->dataset('Users by trimester', 'polarArea', [0, 0])->color($borderColors)->backgroundcolor($fillColors);

        return $currentGrossIncome;
    }
}
