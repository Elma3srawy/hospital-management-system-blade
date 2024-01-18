<?php

namespace App\Http\Controllers\Doctor\Ray;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ray\RayStoreRequest;
use App\Http\Requests\Ray\RayUpdateRequest;
use App\Interfaces\RayInterface;


class RayController extends Controller
{

    public function __construct(protected RayInterface $ray){}

    /**
     * Store a newly created resource in storage.
     */
    public function store(RayStoreRequest $request)
    {
        return $this->ray->store($request);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(RayUpdateRequest $request)
    {
        return $this->ray->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        return $this->ray->destroy();
    }
}
