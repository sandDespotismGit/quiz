importScripts('https://checkout.cloudpayments.ru/checkout.js');
let plan_boxes = document.getElementsByClassName('plan_box');
let round_divs = document.getElementsByClassName('plan_box_time_round');
console.log(round_divs);
console.log(plan_boxes);
function change_plan_box(plan_box){
    if (getComputedStyle(plan_boxes[plan_box]).borderColor == 'rgb(153, 153, 153)') {
        color = '#EC44AD';
    } else {
        color = '#999999';
    }
    plan_boxes[plan_box].style.borderColor = color;
    round_divs[plan_box].style.backgroundColor = color;
}
const checkout = new cp.Checkout({
	publicId: 'pk_8cef82aea94ac4411ffec9597022d',
});
const fieldValues = {
    cvv: '911',
    cardNumber: '4242 4242 4242 4242',
    expDateMonth: '12',
    expDateYear: '24',
}

checkout.createPaymentCryptogram(fieldValues)
    .then((cryptogram) => {
        console.log(cryptogram);
    }).catch((errors) => {
        console.log(errors)
});

