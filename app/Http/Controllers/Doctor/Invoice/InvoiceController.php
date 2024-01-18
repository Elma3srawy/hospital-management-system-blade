<?php

namespace App\Http\Controllers\Doctor\Invoice;

use App\Http\Controllers\Controller;
use App\Interfaces\DoctorInvoiceInterface;


class InvoiceController extends Controller
{

    public function __construct(protected DoctorInvoiceInterface $invoice){}
    /**
     * Display a listing of the resource.
     */
    public function pending()
    {
        return $this->invoice->pending();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function review()
    {
        return $this->invoice->review();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function completed()
    {
        return $this->invoice->completed();

    }

    /**
     * Display the specified resource.
     */
    public function patientDetails(string $id)
    {
        return $this->invoice->patient_details($id);
    }
    public function show(string $id)
    {
        return $this->invoice->show($id);
    }
    public function showLaboratory(string $id)
    {
        return $this->invoice->showLaboratory($id);
    }


}
