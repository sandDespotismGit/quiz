let select_pays = document.getElementsByClassName('select_credits');

function change_credits(select_box){
    if (getComputedStyle(select_pays[select_box]).borderColor == 'rgb(153, 153, 153)') {
        color = '#EC44AD';
    } else {
        color = '#999999';
    }
    select_pays[select_box].style.borderColor = color;
}