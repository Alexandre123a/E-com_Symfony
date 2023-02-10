
var form = document.getElementById('searchForm');


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
    range = parseInt(range.value) * 4;
    if(isNaN(range))
    {
        range = 12;
    }

    xmlhttp.open("GET", "result?keywords="+keyword.value+"&range="+range,true);
    xmlhttp.send();

}

const fetchData = async () => {
    const keyword = document.getElementById('search_form_keywords');
    const range = document.getElementById('search_form_range').valueAsNumber;
    let newRange = range * 4;
    if(isNaN(newRange)) newRange = 12;

    const res = await fetch("result?keywords="+keyword.value+"&range="+newRange);
    const html = await res.text();
    document.getElementById("article-wrapper").innerHTML = html;
    window.history.replaceState(null, null, "?step="+newRange);
}


form.onkeyup = (e) => fetchData();



var range = document.getElementById('search_form_range');
range.onchange = (e) => ajaxRequest()

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