const addPanier = async () => {

    const itemID = document.getElementById("idItem").innerText;
    console.log(itemID);
    const res = await fetch("add/panier?id="+itemID);
    document.getElementById("Result").innerHTML = await res.text(); /**/

}

const suppPanier = async () => {
    const itemID = document.getElementById("idItem").innerText;
    console.log(itemID);
    const res = await fetch("del/panier?id="+itemID);
    //document.getElementById("Result").innerHTML = await res.text();
}
let btnPanier = document.getElementById('addPanier');
btnPanier.onclick = (e) => addPanier();