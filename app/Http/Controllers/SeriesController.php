<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        //Não é a melhor maneira -> FACADE
        //--> $series = DB::select('SELECT nome FROM series');

        //Eloquent ORM
        //ou $series = Serie::all();
        //$series = Serie::query()->orderBy('nome')->get();

        //ou return view('listar-series', compact('series'));
        //ou return view('series.index', ['series' => $series]);

        $series = Series::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')
            ->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $nomeSerie = $request->nome;
        //Não é a melhor maneira -> FACADE
        //--> DB::insert('INSERT INTO series (nome) VALUES(?)', [$nomeSerie]);

        //Eloquent ORM
        /*$serie = new Serie();
        $serie->nome = $nomeSerie;
        $serie->save();*/
        /**
         * @var $serie Series
         */
        $serie = Series::create($request->all());
        $seasons = [];
        for($i = 1; $i <= $request->seasonsQty; $i++) {
            $seasons[] = [
                'series_id' => $serie->id,
                'number' => $i
            ];
        }
        Season::insert($seasons);

        $episodes = [];
        foreach ($serie->seasons as $season) {
            for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                $episodes []= [
                    'season_id' => $season->id,
                    'number' => $j
                ];
            }
        }
        Episode::insert($episodes);

        return to_route('series.index')->with('mensagem.sucesso', "Série {$serie->nome} criada com sucesso");
    }

    public function destroy(Series $series)
    {
        $series->delete();
        return to_route('series.index')->with('mensagem.sucesso', "Série {$series->nome} removida com sucesso");
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        //$series->nome = $request->nome;
        $series->fill($request->all());
        $series->save();
        return to_route('series.index')->with('mensagem.sucesso', "Série {$series->nome} alterada com sucesso");
    }
}
