
var form = document.getElementById('searchForm');

form.onkeyup =
function ajaxRequest() {

    var keyword = document.getElementById('search_form_keywords');
    var range = document.getElementById('search_form_range');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange =
        function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("article-wrapper").innerHTML = xmlhttp.responseText;
            }
        }
    xmlhttp.open("GET", "result?keywords="+keyword.value+"&range="+range.value,true);
    xmlhttp.send();

}
/*
searchBar.onkeyup =
function showHint() {
    if (this.value().length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "gethint.php?q=" + str, true);
        xmlhttp.send();
    }
}*/