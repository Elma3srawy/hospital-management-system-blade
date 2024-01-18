<?php

namespace App\Http\Controllers\Doctor\Laboratory;

use App\Http\Controllers\Controller;
use App\Interfaces\LaboratoryInterface;
use App\Http\Requests\Laboratory\LaboratoryStoreRequest;
use App\Http\Requests\Laboratory\LaboratoryUpdateRequest;




class LaboratoryController extends Controller
{

    public function __construct(protected LaboratoryInterface $laboratory){}

    /**
     * Store a newly created resource in storage.
     */
    public function store(LaboratoryStoreRequest $request)
    {
        return $this->laboratory->store($request);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(LaboratoryUpdateRequest $request)
    {
        return $this->laboratory->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        return $this->laboratory->destroy();
    }
}
