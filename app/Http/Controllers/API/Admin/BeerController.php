<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Beer\StoreRequest;
use App\Http\Requests\Beer\UpdateRequest;
use App\Http\Resources\BeerResource;
use App\Models\Beer;
use App\Services\BeerService;

class BeerController extends Controller
{
    private BeerService $beerService;

    public function __construct(BeerService $beerService)
    {
        $this->beerService = $beerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beers = $this->beerService->getAll();
        return BeerResource::collection($beers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $beer = $this->beerService->store($request);
        return new BeerResource($beer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Beer $beer)
    {
        $this->beerService->update($request, $beer);
        return new BeerResource($beer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beer $beer)
    {
        $this->beerService->delete($beer);

        return response()
            ->noContent();
    }
}
