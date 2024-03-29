@extends('layouts.app')

@section('content')
    <div class="container p-2" style="background-color: #adacab; border-radius: 15px">
        <div class="container p-3 text-center">
            <h1>Список продуктов</h1>
        </div>
        @foreach($data as $course)
            <div class="container p-3">
                <div class="card">
                    <div class="card-header" style="background-color: #df9f1f">
                        <h3>
                            {{ $course->name }}
                        </h3>
                    </div>
                    <div class="card-body" style="background-color: #eecd8a">
                        <h5 class="card-title">{{ $course->price }}</h5>
                        <p class="card-text">Добавлено {{ $course->created_at }}</p>
                        <a href="{{ route('course-purchase-data', $course->id) }}" class="btn" style="background-color: #df9f1f">Купить</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
