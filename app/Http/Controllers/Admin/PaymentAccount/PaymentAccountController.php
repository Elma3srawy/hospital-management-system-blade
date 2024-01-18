<?php

namespace App\Http\Controllers\Admin\PaymentAccount;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentStoreRequset;
use App\Http\Requests\Payment\PaymentUpdateRequest;
use App\Interfaces\PaymentAccountInterface;
use Illuminate\Http\Request;

class PaymentAccountController extends Controller
{

    public function __construct(protected PaymentAccountInterface $payment) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->payment->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->payment->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentStoreRequset $request)
    {
        return $this->payment->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->payment->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->payment->edit($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentUpdateRequest $request, string $id)
    {
        return $this->payment->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->payment->destroy($id);
    }


    public function print(string $id)
    {
        return $this->payment->print($id);
    }
}
