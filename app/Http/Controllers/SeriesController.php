<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        //Não é a melhor maneira -> FACADE
        //--> $series = DB::select('SELECT nome FROM series');

        //Eloquent ORM
        //ou $series = Serie::all();
        $series = Serie::query()->orderBy('nome')->get();

        //ou return view('listar-series', compact('series'));
        //ou return view('series.index', ['series' => $series]);
        return view('series.index')->with('series', $series);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('series.create');
    }

    public function store(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $nomeSerie = $request->nome;
        //Não é a melhor maneira -> FACADE
        //--> DB::insert('INSERT INTO series (nome) VALUES(?)', [$nomeSerie]);

        //Eloquent ORM
        /*$serie = new Serie();
        $serie->nome = $nomeSerie;
        $serie->save();*/
        Serie::create($request->all());
        return to_route('series.index');
    }
}
