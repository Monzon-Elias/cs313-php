//function clicked

function clicked() {
alert("Clicked!");
}

//function for change the color of the first div

/*function chcolor() {
 document.getElementById("first").style.backgroundColor = document.getElementById("color").value;
}*/

/*Using query instead of the previous function*/
    $("#subcolor").click(function() {
        $("#first").css('background-color', $("#color").val());
    });

$("#secbutton").click(function(){
    $("#third").fadeToggle(3000);
 });