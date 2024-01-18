<?php

namespace App\Http\Controllers\Admin\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientStoreRequest;
use App\Http\Requests\Patient\PatientUpdateRequest;
use App\Interfaces\PatientInterface;
use Illuminate\Http\Request;

class PatientContoller extends Controller
{

    public function __construct(protected PatientInterface $Patient){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->Patient->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->Patient->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientStoreRequest $request)
    {
        return $this->Patient->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->Patient->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->Patient->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientUpdateRequest $request, string $id)
    {
        return $this->Patient->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->Patient->destroy($id);
    }
}
