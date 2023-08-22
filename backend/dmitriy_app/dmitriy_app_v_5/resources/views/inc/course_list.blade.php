
@extends('layouts.app') @section('content')
<div>
    <div >
        <h1>Список продуктов</h1>
    </div>
    @foreach($data as $course)
    <div class="plan_box">
        <div class="plan_box_time">
            <div class="plan_box_time_round"></div>
            <div class="plan_box_time_discount">
                <p>Добавлено {{ $course->created_at }}</p>
                <p><a href="{{ route('course-purchase-data', $course->id) }}" class="btn">Купить</a></p>
                <p class="small_discount">{{ $course->name }}</p>
            </div>
        </div>
        <div class="plan_box_price">
            <p><strike>100</strike>$</p>
            <p id="plan_box_p_price">{{ $course->price }}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection
