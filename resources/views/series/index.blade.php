<x-layout title="Séries" :mensagem-sucesso="$mensagemSucesso">
    <a href="{{route('series.create')}}" class="btn btn-dark mb-2">Adicionar</a>
    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between">
                <a href="{{route('seasons.index', $serie->id)}}"> {{$serie->nome}} </a>
                <span class="d-flex">
                    <a href="{{route('series.edit', $serie->id)}}" class="btn btn-primary btn-sm">Alterar</a>
                    <form action="{{route('series.destroy', $serie->id)}}" method="post" class="ms-2">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </span>

            </li>
        @endforeach
    </ul>

    <script>
        const series = {{Js::from($series)}};
    </script>
</x-layout>
