<?php

namespace App\Http\Controllers\Api;

use http\Env\Request;

class ApiSeriesController
{
    public function upload(\http\Client\Request $request)
    {
        $coverPath = null;

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('series_cover', 'public');
        } else {
            return response()->json(['error' => 'Nenhum arquivo foi enviado.'], 400);
        }

        $request->merge(['coverPath' => $coverPath]);

        return response()->json(['file_path' => $coverPath]);
    }

    public function store(\http\Client\Request $request)
    {
        $coverPath = $request->input('cover');
        $coverPath = str_replace("\\", "/", $coverPath);

        return response()->json(Series::create($request->all()), 201);
    }
}
