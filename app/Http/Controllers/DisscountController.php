<?php

namespace App\Http\Controllers;

use App\Models\Disscount;
use App\Http\Requests\StoreDisscountRequest;
use App\Http\Requests\UpdateDisscountRequest;

class DisscountController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDisscountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDisscountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disscount  $disscount
     * @return \Illuminate\Http\Response
     */
    public function show(Disscount $disscount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDisscountRequest  $request
     * @param  \App\Models\Disscount  $disscount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDisscountRequest $request, Disscount $disscount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disscount  $disscount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disscount $disscount)
    {
        //
    }
}
