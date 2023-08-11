<div>
    {{ $data[0]->name }}
</div>
<div>
    {{ $data[1]->price }}
</div>
<div>
    @foreach($data[2] as $elem)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="{{ $elem['course']->name }}" id="{{ $elem['course']->id }}">
            <label class="form-check-label" for="{{ $elem['course']->id }}">
                Добавить {{ $elem['course']->name }} за {{ $elem['rate']->price }}
            </label>
        </div>
    @endforeach
</div>
<button>
    Точно купить
</button>
