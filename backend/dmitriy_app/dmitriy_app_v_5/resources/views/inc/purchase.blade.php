@extends('layouts.app') @section('content')
<div id="cock" style="display: flex;flex-direction: column;align-items: center;">
    <div style="display: flex;flex-direction: column;align-items: center;">
        <h2 class="card-title p-2">{{ $data[0]->name }}</h2>
        <p class="card-text p-2" style="width: 400px;">{{ $data[0]->description }}</p>
        <img
            class="card-img-top img-fluid"
            src="{{ $data[3]->image }}"
            class="card-img-top"
            alt="..."
            style="width: 200px;height: 200px;"
        />
    </div>
    <div class="personal_plan" style="display: flex;flex-direction: column;align-items: center;">
        <div class="big_banner">
            <p>Choose your plan</p>
        </div>
        <div class="discount_red">
            <p>Предложение доступно</p>
            <p class="counter">60</p>
        </div>
        <div class="one_two_button">
            <button class="one_two_buttonleft">Стандарт</button>
            <button class="one_two_buttonright">Премиум</button>
        </div>
        <div class="plan_box">
            <div class="plan_box_time">
                <div class="plan_box_time_round"></div>
                <div class="plan_box_time_discount">
                    <p>1 месяц</p>
                    <p class="small_discount">-28%</p>
                </div>
            </div>
            <div class="plan_box_price">
                <p><strike>{{ $data[1]->price }}</strike>$</p>
                <p id="plan_box_p_price">10$</p>
                <p>в день</p>
            </div>
        </div>
    </div>
    <ul class="list-group list-group-flush" style="display: flex; flex-direction: column; align-items: flex-start;">
        @foreach($data[2] as $elem)
        <li class="list-group-item">
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    value="{{ $elem['course']->name }}"
                    id="{{ $elem['course']->id }}"
                />
                <label
                    class="form-check-label"
                    for="{{ $elem['course']->id }}"
                >
                    Добавить {{ $elem['course']->name }} за
                    {{ $elem['rate']->price }}.
                    <p class="p-0">
                        Курс посвящён {{ $elem['course']->description }}
                    </p>
                </label>
            </div>
        </li>
        @endforeach
    </ul>
    <div class="agree">
        <input
            type="checkbox"
            id="agree"
            class="custom_checkbox"
            name="agree"
            value="yes"
        />
        <label for="agree"> </label>
        <p style="width: 400px;">
            By purchasing you agree to our Private policy, Terms of Service and
            Refund Policy.
        </p>
    </div>
    <button class="big_button"><a href="{{ route('course-purchase-data', $data[5]->next_courses_id, $data[5]->key) }}">оплатить</a></button>
    <div class="payments"></div>
</div>
@endsection 