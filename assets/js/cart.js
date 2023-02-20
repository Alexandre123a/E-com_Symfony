
async function addPanier(id){
    let itemID  = id;

    const res = await fetch("add/panier?id="+itemID);
    const tab = await res.json();


    document.getElementById("Result"+itemID).innerHTML = await tab[0];
    document.getElementById("Quantity"+itemID).innerHTML = await tab["quantity"];

    let totalPrice = parseInt(document.getElementById("Price").innerHTML);
    totalPrice += parseInt(tab[1]);

    document.getElementById("Price").innerHTML = totalPrice;

}

async function suppPanier(id){
    
    const itemID = id;
    const res = await fetch("del/panier?id="+itemID);
    const tab = await res.json();

    if(tab["del"] !== undefined)
    {
        document.getElementById("item"+itemID).remove();
        document.getElementById("RemoveSucess").innerHTML = tab["del"];
    }
    document.getElementById("Result"+itemID).innerHTML = await tab[0];
    document.getElementById("Quantity"+itemID).innerHTML = await tab["quantity"];

    let totalPrice = parseInt(document.getElementById("Price").innerHTML);
    totalPrice -= parseInt(tab[1]);

    document.getElementById("Price").innerHTML = totalPrice;
}

let btnAddPanier = document.getElementsByClassName('addPanier');
for (let element of btnAddPanier)
{
    element.onclick = () => addPanier(element.id);
}

let btnDelPanier = document.getElementsByClassName('delPanier');
for (let element of btnDelPanier)
{
    element.onclick = () => suppPanier(element.id);
}