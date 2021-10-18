<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Beer $beer)
    {
        return new BeerResource($beer);
    }
}
