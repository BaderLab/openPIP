/*  property_view.js
    Author: Hussam Fetyan
    This file contains the functions required
    to apply changes to the property view document dynamically
*/


var listing_date = new Date(2016, 1, 10, 0, 0, 0, 0);

function updateFields(){
    var current_date = new Date();
    var total_seconds_elapsed = Math.floor((current_date - listing_date) / 1000);

    var days_elapsed = Math.floor(total_seconds_elapsed / (24 * 60 * 60));
    var less_than_day = total_seconds_elapsed % (24 * 60 * 60);
    var hours_elapsed = Math.floor(less_than_day / (60 * 60));
    var less_than_hour = less_than_day % (60 * 60);
    var minutes_elapsed = Math.floor(less_than_hour / 60);
    var seconds_elapsed = less_than_hour % 60;

    document.getElementById("days").innerHTML = days_elapsed;
    document.getElementById("hours").innerHTML = hours_elapsed;
    document.getElementById("mins").innerHTML = minutes_elapsed;
    document.getElementById("sec").innerHTML = seconds_elapsed;
}


function enlargeImage(evt){
    var img_src = evt.target.src;
    var target = document.getElementById("enlarged");

    target.src = img_src;

    var container = document.getElementById("container");
    container.className = "large";

    var close_btn = document.getElementById("close_btn");
    close_btn.addEventListener("click", shrinkImage, false);
}

function shrinkImage(){
    document.getElementById("container").className = "hidden";

}


document.getElementById("pic_1").addEventListener("click", enlargeImage, false);
document.getElementById("pic_2").addEventListener("click", enlargeImage, false);
document.getElementById("pic_3").addEventListener("click", enlargeImage, false);
document.getElementById("pic_4").addEventListener("click", enlargeImage, false);



setInterval(updateFields, 1000);


