<?php

namespace App\Http\Controllers\Admin\RayEmployee;

use App\Http\Controllers\Controller;
use App\Http\Requests\RayEmployee\RayEmployeeStoreRequest;
use App\Http\Requests\RayEmployee\RayEmployeeUpdateRequest;
use App\Interfaces\RayEmployeeInterface;

class RayEmployeeController extends Controller
{

    public function __construct(protected RayEmployeeInterface $rayEmployee){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->rayEmployee->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->rayEmployee->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RayEmployeeStoreRequest $request)
    {
        return $this->rayEmployee->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->rayEmployee->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->rayEmployee->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RayEmployeeUpdateRequest $request, string $id)
    {
        return $this->rayEmployee->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->rayEmployee->destroy($id);
    }
}
