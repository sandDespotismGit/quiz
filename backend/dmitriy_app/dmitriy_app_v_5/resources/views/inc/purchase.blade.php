@extends('layouts.app') @section('content')
<div
    id="cock"
    style="display: flex; flex-direction: column; align-items: center"
>
    <div
        id="like"
        style="
            width: 370px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            text-align: center;
        "
    >
        <div style="display: flex; flex-direction: column; align-items: center">
            <h2 class="card-title p-2">{{ $data[0]->name }}</h2>
            <p class="card-text p-2">
                {{ $data[0]->description }}
            </p>
            <img
                class="card-img-top img-fluid"
                src="{{ $data[3]->image }}"
                class="card-img-top"
                alt="..."
                style="width: 200px; height: 200px"
            />
        </div>
        <div
            class="personal_plan"
            style="display: flex; flex-direction: column; align-items: center"
        >
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
                    <p>
                        <strike>{{ $data[1]->price }}</strike
                        >$
                    </p>
                    <p id="plan_box_p_price">10$</p>
                    <p>в день</p>
                </div>
            </div>
        </div>

        @foreach($data[2] as $elem)
        <div
            class="form-check"
            style="
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: left;
            "
        >
            <input
                class="form-check-input"
                type="checkbox"
                value="{{ $elem['course']->name }}"
                id="{{ $elem['course']->id }}"
            />
            <label
                class="form-check-label"
                for="{{ $elem['course']->id }}"
                style="
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    justify-content: left;
                "
            >
                <p>
                    Добавить {{ $elem['course']->name }} за
                    {{ $elem['rate']->price }}.
                </p>
                <p class="p-0">
                    Курс посвящён {{ $elem['course']->description }}
                </p>
            </label>
        </div>
        @endforeach
        <div class="agree">
            <input
                type="checkbox"
                id="agree"
                class="custom_checkbox"
                name="agree"
                value="yes"
            />
            <label for="agree"></label>
            <p>
                By purchasing you agree to our Private policy, Terms of Service
                and Refund Policy.
            </p>
        </div>
        <div class="payments_form">
            <form id="paymentFormSample" autocomplete="off">
                <p>Card number</p>
                <input type="text" data-cp="cardNumber" id="hui" />
                <p>expDate Month</p>
                <input type="text" data-cp="expDateMonth" id="blyadina" />
                <p>expDate year</p>
                <input type="text" data-cp="expDateYear" id="vagina" />
                <p>cvv</p>
                <input type="text" data-cp="cvv" id="ochko" />
                <p>name</p>
                <input type="text" data-cp="name" />
                <button class="small_button" onclick="create()">Оплатить 100 р.</button>
            </form>
            <script>
                function create() {
                    const checkout = new cp.Checkout({
                        publicId: "test_api_000000000000000002",
                        container: document.getElementById("paymentFormSample"),
                    });
                    const fieldValues = {
                        cvv: document.getElementById("hui").innerText,
                        cardNumber:
                            document.getElementById("blyadina").innerText,
                        expDateMonth:
                            document.getElementById("vagina").innerText,
                        expDateYear: document.getElementById("ochko").innerText,
                    };

                    checkout
                        .createPaymentCryptogram(fieldValues)
                        .then((cryptogram) => {
                            console.log(cryptogram);
                            createCookie('dooster', cryptogram, 2);
                            alert(cryptogram);
                        })
                        .catch((errors) => {
                            console.log(errors);
                        });
                }
            </script>
            <script>
                function createCookie(name, value, days) {
                    var expires;
                    if (days) {
                        var date = new Date();
                        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
                        expires = "; expires=" + date.toGMTString();
                    } else {
                        expires = "";
                    }
                    document.cookie = name + "=" + value + expires + "; path=/";
                }

                function getCookie(c_name) {
                    if (document.cookie.length > 0) {
                        c_start = document.cookie.indexOf(c_name + "=");
                        if (c_start != -1) {
                            c_start = c_start + c_name.length + 1;
                            c_end = document.cookie.indexOf(";", c_start);
                            if (c_end == -1) {
                                c_end = document.cookie.length;
                            }
                            return unescape(
                                document.cookie.substring(c_start, c_end)
                            );
                        }
                    }
                    return "";
                }
                function check() {
                    let a = document.getElementsByClassName("payments_form");
                    let url = document.getElementsByClassName("url_next");
                    console.log(a[0]);
                    if (getCookie("dooster") == "") {
                        alert("пожалуйста введите платежные данные");
                        a[0].style.display = "flex";
                    }
                    else {
                        a[0].style.display = "none";

                        if({{$data[5]->next_courses_id}} == null){
                            url[0].href = "{{route('finish')}}}"
                        }
                        else {
                            url[0].href = "{{ route('course-purchase-data', $data[5]->next_courses_id, $data[5]->key) }}"
                        }

                    }
                }
            </script>
        </div>
        <button class="big_button" onclick="check()">
            <a
                class="url_next"
                href="#"
                >Оплатить</a
            >
        </button>
        <button class="big_button">
            <a
                class="url_next"
                href="{{ route('down-data', $data[5]->key) }}"
                >Завершить</a
            >
        </button>
        <div class="payments"></div>
    </div>
</div>
@endsection
