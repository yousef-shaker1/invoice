<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $count_all = invoices::count();
        $count_invoices2 = invoices::where('Value_Status', 2)->count();
        $nspinvoices = $count_invoices2 / $count_all * 100;
        $count_invoices1 = invoices::where('Value_Status', 1)->count();
        $nspinvoices1 = $count_invoices1 / $count_all * 100;
        $count_invoices3 = invoices::where('Value_Status', 3)->count();
        $nspinvoices3 = $count_invoices3 / $count_all * 100;
        
        $chartjs1 = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
         ->size(['width' => 350, 'height' => 200])
         ->labels(['الفواتير الغير مدفوعة' , 'الفواتير المدفوعة', 'الفواتير المدفوعة جزيا'])
         ->datasets([
             [
                 "label" => "My First dataset",
                 'backgroundColor' => ['#ec524b', '#7ABA78', '#F97300'],//الغير مدفوعة + المدفوعة جزيا
                 'data' => [$nspinvoices, $nspinvoices1,$nspinvoices3] // الغير مدفوعة / جزيا
                ],
                ])
                ->options([]);
                //++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                
                $chartj2 = app()->chartjs
                ->name('pieChartTest')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['Label x', 'Label y'])
                ->datasets([
                    [
                        'backgroundColor' => ['#ec524b', '#7ABA78', '#F97300'],
                        'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                        'data' => [$nspinvoices, $nspinvoices1,$nspinvoices3]
                    ]
                ])
                ->options([]);

                return view('dashboard', compact('chartjs1', 'chartj2'));
            }
            
}
