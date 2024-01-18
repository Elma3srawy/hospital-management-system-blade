<?php

namespace App\Http\Controllers\Admin\Ambulance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\AmbulanceInterface;
use App\Http\Requests\Ambulance\AmbulanceStoreRequest;
use App\Http\Requests\Ambulance\AmbulanceUpdateRequest;

class AmbulanceController extends Controller
{

    public function __construct(protected AmbulanceInterface $ambulance){

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ambulance->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ambulance->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AmbulanceStoreRequest $request)
    {
        return $this->ambulance->store($request);
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
        return $this->ambulance->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AmbulanceUpdateRequest $request, string $id)
    {
        return $this->ambulance->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id ,Request $requset)
    {
        $requset->validate(['id' => "required|exists:ambulances,id"]);
        return $this->ambulance->destroy($requset->id);
    }
}
