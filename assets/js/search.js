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
    const type = document.getElementById('search_form_type').value;
    const ctg = document.getElementById('search_form_ctg').value;
    const genre = document.getElementById('search_form_genre').value;
    let newRange = parseInt(range);
    newRange = newRange * 4;
    if(isNaN(newRange)) newRange = 12;


    const res = await fetch("result?keywords="+keyword.value+"&range="+newRange+"&order="+order+"&genre="+genre+"&ctg="+ctg+"&type="+type);
    document.getElementById("article-wrapper").innerHTML = await res.text(); /**/
    window.history.replaceState(null, null, "?keywords="+keyword.value+"&step="+newRange+"&order="+order+"&genre="+genre+"&ctg="+ctg+"&type="+type);
}

const fetchCtg = async () => {
    const genre = document.getElementById('search_form_genre').value;

    const res = await fetch("ctg?genre="+genre);
    document.getElementById("search_form_ctg").innerHTML = await res.text();
}

const fetchTypes = async () => {
    const ctg = document.getElementById('search_form_ctg').value;

    const res = await fetch("types?ctg="+ctg);
    document.getElementById("search_form_type").innerHTML = await res.text();
}

let form = document.getElementById('searchForm');
form.onkeyup = (e) => fetchData();

let range = document.getElementById('search_form_range');
range.onchange = (e) => fetchData();

let order = document.getElementById('search_form_order');
order.onchange = (e) => fetchData();

let genre = document.getElementById('search_form_genre');
genre.onchange =(e) => {
    fetchData();
    fetchCtg();
}

let ctg = document.getElementById('search_form_ctg');
ctg.onchange = (e) => {
    fetchData();
    fetchTypes();
}

let types = document.getElementById('search_form_type');
types.onchange = (e) => fetchData();
