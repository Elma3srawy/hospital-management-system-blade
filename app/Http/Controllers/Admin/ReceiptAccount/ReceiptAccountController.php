<?php

namespace App\Http\Controllers\Admin\ReceiptAccount;

use App\Http\Controllers\Controller;
use App\Http\Requests\Receipt\ReceiptStoreRequset;
use App\Http\Requests\Receipt\ReceiptUpdateRequest;
use App\Interfaces\ReceiptAccountInterface;


class ReceiptAccountController extends Controller
{
    public function __construct(protected ReceiptAccountInterface $receiptAccount){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return $this->receiptAccount->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->receiptAccount->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReceiptStoreRequset $request)
    {
        return $this->receiptAccount->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->receiptAccount->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->receiptAccount->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReceiptUpdateRequest $request, string $id)
    {
        return $this->receiptAccount->update($request , $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->receiptAccount->destroy($id);
    }

    public function print(string $id)
    {
        return $this->receiptAccount->print($id);
    }
}
