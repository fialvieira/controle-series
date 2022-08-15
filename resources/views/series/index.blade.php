<x-layout title="Séries" :mensagem-sucesso="$mensagemSucesso">
    @auth()
        <a href="{{route('series.create')}}" class="btn btn-dark mb-2">Adicionar</a>
    @endauth
    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    @if($serie->cover_path != '')
                        <img src="{{asset('storage/' . $serie->cover_path)}}" width="100" class="img-thumbnail me-3">
                    @endif
                    @auth()
                        <a href="{{route('seasons.index', $serie->id)}}">@endauth {{$serie->nome}} @auth()</a>@endauth
                    @auth()
                </div>

                    <span class="d-flex">
                        <a href="{{route('series.edit', $serie->id)}}" class="btn btn-primary btn-sm">Alterar</a>
                        <form action="{{route('series.destroy', $serie->id)}}" method="post" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </span>
                @endauth
            </li>
        @endforeach
    </ul>

    <script>
        const series = {{Js::from($series)}};
    </script>
</x-layout>
