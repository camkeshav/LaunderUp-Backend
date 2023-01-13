<?php

namespace App\Http\Controllers;

use App\Models\OrderInvoice;
use App\Http\Requests\StoreOrderInvoiceRequest;
use App\Http\Requests\UpdateOrderInvoiceRequest;

class OrderInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderInvoice  $orderInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(OrderInvoice $orderInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderInvoice  $orderInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderInvoice $orderInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderInvoiceRequest  $request
     * @param  \App\Models\OrderInvoice  $orderInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderInvoiceRequest $request, OrderInvoice $orderInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderInvoice  $orderInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderInvoice $orderInvoice)
    {
        //
    }
}
