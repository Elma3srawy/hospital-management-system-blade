<?php

namespace App\Interfaces;

interface DoctorInvoiceInterface
{
    /**
    * Display a listing of the resource.
    */
    public function pending();


    /**
    * Show the form for creating a new resource.
    */
    public function review();


    /**
    * Store a newly created resource in storage.
    */
    public function completed();


    /**
    * Display the specified resource.
    */
    public function patient_details(string $id);
    public function show(string $id);
    public function showLaboratory(string $id);


}
