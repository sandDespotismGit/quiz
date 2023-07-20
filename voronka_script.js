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

