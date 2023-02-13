/* Old AJAX
function ajaxRequest() {

    const keyword = document.getElementById('search_form_keywords');
    let range = document.getElementById('search_form_range');
    const xmlhttp = new XMLHttpRequest();
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
*/
// New function AJAX by using fetch API (made by théo)
const fetchData = async () => {
    const keyword = document.getElementById('search_form_keywords');
    const range = document.getElementById('search_form_range').value;
    const order = document.getElementById('search_form_order').value;
    let newRange = parseInt(range);
    newRange = newRange * 4;
    if(isNaN(newRange)) newRange = 12;


    const res = await fetch("result?keywords="+keyword.value+"&range="+newRange+"&order="+order);
    document.getElementById("article-wrapper").innerHTML = await res.text();
    window.history.replaceState(null, null, "?keywords="+keyword.value+"&step="+newRange+"&order="+order);
}

let form = document.getElementById('searchForm');
form.onkeyup = (e) => fetchData();

let range = document.getElementById('search_form_range');
range.onchange = (e) => fetchData();

let order = document.getElementById('search_form_order');
order.onchange = (e) => fetchData();
