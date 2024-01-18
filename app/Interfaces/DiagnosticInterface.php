<?php
namespace App\Interfaces;


interface DiagnosticInterface {

    public function store($request);
    public function show();
    public function addReview($request);

}




?>
