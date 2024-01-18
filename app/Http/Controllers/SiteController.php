<?php

namespace App\Http\Controllers;

use App\Services\Admin\DashboardServices;
use App\Services\RayEmployee\DashboardServices AS RayEmployeeDashboard;
use App\Services\LaboratoryEmployee\DashboardServices AS LaboratoryEmployeeDashboard;


class SiteController extends Controller
{
    public function login(){
        return view("Dashboard.User.auth.signin");
    }

    public function adminDashboard(){
        $count_doctors  =  DashboardServices::getCountDoctors();
        $count_patients =  DashboardServices::getCountPatients();
        $count_sections =  DashboardServices::getCountSections();
        return  view('Dashboard.Admin.dashboard', compact('count_doctors', 'count_patients' , 'count_sections'));
    }
    public function doctorDashboard(){
        return view('Dashboard.doctor.dashboard');
    }
    public function patientDashboard(){
        return view('Dashboard.dashboard_patient.dashboard');
    }
    public function rayEmployeeDashboard(){
        $latestFiveRays = RayEmployeeDashboard::getLatestFiverRays();
        return view('Dashboard.dashboard_RayEmployee.dashboard' , compact('latestFiveRays'));
    }
    public function laboratoryEmployeeDashboard(){
        $latestFiveInvoices =  LaboratoryEmployeeDashboard::getLatestFiveLaboratory();
        return view('Dashboard.dashboard_LaboratorieEmployee.dashboard' ,compact('latestFiveInvoices'));
    }
}
