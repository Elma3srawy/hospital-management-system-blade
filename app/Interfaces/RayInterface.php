<?php

namespace App\Interfaces;

interface RayInterface
{

    /**
    * Store a newly created resource in storage.
    */
    public function store(Mixed $request);

    /**
    * Update the specified resource in storage.
    */
    public function update(Mixed $request);


    /**
    * Remove the specified resource from storage.
    */
    public function destroy();

}
