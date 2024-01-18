<?php

namespace App\Http\Controllers\Admin\Insurance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\InsuranceInterface;
use App\Http\Requests\Insurance\InsuranceStoreRequest;
use App\Http\Requests\Insurance\InsuranceUpdateRequest;

class InsuranceController extends Controller
{

    public function __construct(protected InsuranceInterface $insurance){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->insurance->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->insurance->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InsuranceStoreRequest $request)
    {
        return $this->insurance->store($request);
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
        return $this->insurance->edit($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InsuranceUpdateRequest $request, string $id)
    {
        return $this->insurance->update($request , $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->insurance->destroy($id);
    }
}
