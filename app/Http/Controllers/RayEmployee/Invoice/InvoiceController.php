<?php

namespace App\Http\Controllers\RayEmployee\Invoice;

use App\Http\Controllers\Controller;
use App\Interfaces\RayEmployeeInvoiceInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(protected RayEmployeeInvoiceInterface $invoice){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->invoice->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function completed_invoices()
    {
        return $this->invoice->completed_invoices();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->invoice->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->invoice->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->invoice->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->invoice->update($request , $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->invoice->destroy($id);
    }
    public function view_rays(string $id)
    {
        return $this->invoice->view_rays($id);
    }
}
