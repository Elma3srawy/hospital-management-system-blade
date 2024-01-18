<?php

namespace App\Http\Controllers\Admin\Section;

use App\Http\Requests\Section\UpdateRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\SectionInterface;
use App\Http\Requests\Section\StoreRequest;

class SectionController extends Controller
{

    public function __construct(public SectionInterface $section){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return $this->section->index();
        } catch (\Exception $e) {
            return session()->flash("error" , $e->getMessage());
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
            return $this->section->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->section->show($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        return $this->section->update($request , $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->section->destroy($id);
    }
}
