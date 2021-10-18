<?php

namespace App\Services;

use App\Models\Beer;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BeerService
{
    public function getAll(int $qty = null): Paginator
    {
        return Beer::latest()
            ->paginate($qty);
    }

    public function store(Request $request): Beer
    {
        $img = $request->file('img');

        $beer = new Beer();
        $beer->name = $request->name;
        $beer->desc = $request->desc;
        $beer->img = $this->saveImage($img);

        $beer->save();

        return $beer;
    }

    public function update(Request $request, Beer $beer): void
    {
        $beer->name = $request->name;
        $beer->desc = $request->desc;

        if ($img = $request->file('img'))
            $beer->img = $this->saveImage($img);

        $beer->save();
    }

    public function delete(Beer $beer): void
    {
        $beer->delete();
    }

    private function saveImage(UploadedFile $image): string
    {
        return Storage::put('images', $image);
    }
}
