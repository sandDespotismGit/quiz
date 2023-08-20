@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card" style="width: 40rem;">
                <div class="h-100">
                    <img class="card-img-top img-fluid" src="{{ $data[3]->image }}" class="card-img-top" alt="...">
                </div>
                <div class="card-body">
                    <h2 class="card-title p-2">{{ $data[0]->name }}</h2>
                    <h3 class="card-title p-2">{{ $data[1]->price }}</h3>
                    <p class="card-text p-2">{{ $data[0]->description }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($data[2] as $elem)
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $elem['course']->name }}" id="{{ $elem['course']->id }}">
                                <label class="form-check-label" for="{{ $elem['course']->id }}">
                                    Добавить {{ $elem['course']->name }} за {{ $elem['rate']->price }}.
                                    <p class="p-0">
                                        Курс посвящён {{ $elem['course']->description }}
                                    </p>
                                </label>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="card-body" style="background-color: #df9f1f" >
                    <a href="{{ route('course-purchase-data', $data[5]->next_courses_id, $data[5]->key) }}" class="list-group-item list-group-item-action">Купить</a>
                </div>
            </div>
        </div>
    </div>
@endsection

