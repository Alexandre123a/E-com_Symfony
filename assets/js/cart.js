
async function addPanier(id){
    let itemID  = id;
    console.log(itemID);
    const res = await fetch("add/panier?id="+itemID);
    const tab = await res.json();
    await console.log(tab["quantity"]);
    document.getElementById("Result"+itemID).innerHTML = await tab[0];
    document.getElementById("Quantity"+itemID).innerHTML = await tab["quantity"];
    let totalPrice = parseInt(document.getElementById("Price").innerHTML);
    totalPrice += parseInt(tab[1]);
    console.log(totalPrice);
    document.getElementById("Price").innerHTML = totalPrice;

}

const suppPanier = async () => {
    console.log(itemID);
    const res = await fetch("del/panier?id="+itemID);
    //document.getElementById("Result").innerHTML = await res.text();
}

let btnAddPanier = document.getElementsByClassName('addPanier');
for (let element of btnAddPanier)
{
    element.onclick = (e) => addPanier(element.id);
}

let btnDelPanier = document.getElementsByClassName('delPanier');
btnDelPanier.onclick = (e) => suppPanier();