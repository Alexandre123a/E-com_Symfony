const itemID = document.getElementById("idItem").innerText;
const addPanier = async () => {
    console.log(itemID);
    const res = await fetch("add/panier?id="+itemID);
    document.getElementById("Result").innerHTML = await res.text(); /**/

}

let btnAddPanier = document.getElementById('addPanier');
btnAddPanier.onclick = (e) => addPanier();