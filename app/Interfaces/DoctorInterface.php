<?php
namespace App\Interfaces;

interface DoctorInterface{

       /**
     * Display a listing of the resource.
     */
    public function index();



    /**
     * Show the form for creating a new resource.
     */
    public function create();

    /**
     * Store a newly created resource in storage.
     */

    public function store($request);

    /**
     * Display the specified resource.
     */
    public function show(string $id);

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id);

    /**
     * Update the specified resource in storage.
     */
    public function update($request);

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id);



}

?>
