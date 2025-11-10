var idx = 0;
slideshow();

function slideshow() {
    var i;
    var x = document.getElementsByClassName("slides");
    for(i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }

    idx++;
    if(idx > x.length) {idx = 1}
    x[idx - 1].style.display = "block";
    setTimeout(slideshow, 3000);
}