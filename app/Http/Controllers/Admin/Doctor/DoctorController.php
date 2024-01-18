<?php

namespace App\Http\Controllers\Admin\Doctor;

use Illuminate\Http\Request;
use App\Interfaces\DoctorInterface;
use App\Http\Controllers\Controller;
use App\Services\Admin\DoctorServices;
use App\Http\Requests\Doctor\DoctorStoreRequest;
use App\Http\Requests\Doctor\DoctorUpdateRequest;

class DoctorController extends Controller
{

    public function __construct(protected DoctorInterface $doctor)
    {}    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doctor->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->doctor->create();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorStoreRequest $request)
    {
        return $this->doctor->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->doctor->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateRequest $request, string $id)
    {
        return $this->doctor->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->doctor->destroy($id);

    }
    public function ChangePassword(Request $request)
    {
        return DoctorServices::ChangePassword($request);
    }
    public function ChangeStatus(Request $request)
    {
        return DoctorServices::ChangeStatus($request);
    }
}
