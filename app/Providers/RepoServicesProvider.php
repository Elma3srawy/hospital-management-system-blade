<?php

namespace App\Providers;

use App\Interfaces\RayInterface;
use App\Repository\RayRepository;
use App\Interfaces\DoctorInterface;
use App\Interfaces\PatientInterface;
use App\Interfaces\SectionInterface;
use App\Interfaces\ServiceInterface;
use App\Repository\DoctorRepository;
use App\Repository\PatientRepository;
use App\Repository\SectionRepository;
use App\Repository\ServiceRepository;
use App\Interfaces\AmbulanceInterface;
use App\Interfaces\InsuranceInterface;
use App\Interfaces\DiagnosticInterface;
use App\Interfaces\LaboratoryInterface;
use App\Repository\AmbulanceRepository;
use App\Repository\InsuranceRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\RayEmployeeInterface;
use App\Repository\DiagnosticRepository;
use App\Repository\LaboratoryRepository;
use App\Repository\RayEmployeeRepository;
use App\Interfaces\DoctorInvoiceInterface;
use App\Interfaces\PaymentAccountInterface;
use App\Interfaces\ReceiptAccountInterface;
use App\Repository\DoctorInvoiceRepository;
use App\Repository\PaymentAccountRepository;
use App\Repository\ReceiptAccountRepository;
use App\Interfaces\PatientDashboardInterface;
use App\Interfaces\LaboratoryEmployeeInterface;
use App\Interfaces\RayEmployeeInvoiceInterface;
use App\Repository\LaboratoryEmployeeRepository;
use App\Repository\RayEmployeeInvoiceRepository;
use App\Interfaces\LaboratoryEmployeeInvoiceInterface;
use App\Repository\LaboratoryEmployeeInvoiceRepository;
use App\Repository\PatientDashboardRepository;

class RepoServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SectionInterface::class ,SectionRepository::class);
        $this->app->bind(DoctorInterface::class ,DoctorRepository::class);
        $this->app->bind(ServiceInterface::class ,ServiceRepository::class);
        $this->app->bind(AmbulanceInterface::class ,AmbulanceRepository::class);
        $this->app->bind(InsuranceInterface::class ,InsuranceRepository::class);
        $this->app->bind(PatientInterface::class ,PatientRepository::class);
        $this->app->bind(ReceiptAccountInterface::class ,ReceiptAccountRepository::class);
        $this->app->bind(PaymentAccountInterface::class ,PaymentAccountRepository::class);
        $this->app->bind(DoctorInvoiceInterface::class ,DoctorInvoiceRepository::class);
        $this->app->bind(DiagnosticInterface::class ,DiagnosticRepository::class);
        $this->app->bind(RayInterface::class ,RayRepository::class);
        $this->app->bind(LaboratoryInterface::class ,LaboratoryRepository::class);
        $this->app->bind(LaboratoryEmployeeInterface::class ,LaboratoryEmployeeRepository::class);
        $this->app->bind(RayEmployeeInterface::class ,RayEmployeeRepository::class);
        $this->app->bind(RayEmployeeInvoiceInterface::class ,RayEmployeeInvoiceRepository::class);
        $this->app->bind(LaboratoryEmployeeInvoiceInterface::class ,LaboratoryEmployeeInvoiceRepository::class);
        $this->app->bind(PatientDashboardInterface::class ,PatientDashboardRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
