<?php

namespace App\Http\Controllers\Admin\LaboratoryEmployee;

use App\Http\Controllers\Controller;
use App\Interfaces\LaboratoryEmployeeInterface;
use App\Http\Requests\LaboratoryEmployee\LaboratoryEmployeeStoreRequest;
use App\Http\Requests\LaboratoryEmployee\LaboratoryEmployeeUpdateRequest;

class LaboratoryEmployeeController extends Controller
{

    public function __construct(protected LaboratoryEmployeeInterface $laboratory){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->laboratory->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->laboratory->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LaboratoryEmployeeStoreRequest $request)
    {
        return $this->laboratory->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->laboratory->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->laboratory->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaboratoryEmployeeUpdateRequest $request, string $id)
    {
        return $this->laboratory->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->laboratory->destroy($id);
    }
}
