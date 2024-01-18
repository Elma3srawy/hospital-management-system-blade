<?php

namespace App\Interfaces;

interface LaboratoryEmployeeInvoiceInterface
{
     /**
    * Display a listing of the resource.
    */
    public function index();

    public function completed_invoices();



    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id);


    /**
    * Update the specified resource in storage.
    */
    public function update(Mixed $request, string $id);



    public function viewLaboratory(string $id);
}
