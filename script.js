window.onload = function() {
var index = 1;
 document.querySelectorAll("tr").forEach(element => {
    element.style.animationDelay = index *0.5 +'s';
    index++;
 });

}

function clearForm(){
    document.getElementById("search").value = '';
 }