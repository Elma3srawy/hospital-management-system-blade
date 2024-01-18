<?php
namespace App\Interfaces;

interface InsuranceInterface{

       /**
     * Display a listing of the resource.
     */
    public function index();

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function edit(string $id);

    /**
     * Update the specified resource in storage.
     */
    public function update($request , $id);

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id);



}

?>
