<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Interfaces\ServiceInterface;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(protected ServiceInterface $service){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->service->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        return $this->service->store($request);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, string $id)
    {
        return $this->service->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $requset, string $id)
    {
        $validatedData = $requset->validate(['id'  => "required|exists:services,id"]);
        return $this->service->destroy($validatedData['id']);
    }
}
