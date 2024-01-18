<?php

namespace App\Http\Controllers\Doctor\Diagnostic;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\DiagnosticInterface;
use App\Http\Requests\Diagnostic\DiagnosticStoreRequest;


class DiagnosticController extends Controller
{
    public function __construct(protected DiagnosticInterface $diagnosic){}

    public function store(DiagnosticStoreRequest $request){
        return $this->diagnosic->store($request);
    }
    public function show(){
        return $this->diagnosic->show();
    }
    public function addReview(DiagnosticStoreRequest $request){
        return $this->diagnosic->addReview($request);
    }
}
