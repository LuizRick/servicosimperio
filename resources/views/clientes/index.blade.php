<a href="{{route('clientes.create')}}">criar</a>
<ol>
    @foreach ($clientes as $c)
        <li>
            {{ $c['nome']}}
            <a href="{{route('clientes.edit', $c['id'])}}">edit</a>
            <a href="{{route('clientes.show', $c['id'])}}">info</a>
            
            <form action="{{route('clientes.destroy', $c['id'] )}}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" value="Apagar" />
            </form>
        </li>
    @endforeach
    
</ol>