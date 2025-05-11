document.getElementById("login").addEventListener("input",function(){
    let nb=parseInt(this.value.length);
    let max=parseInt(this.maxLength);
    document.getElementById("cpt_nom").textContent=(max-nb)+" caractères restants";
})

document.getElementById("login").addEventListener("input",function(){
    let nb=parseInt(this.value.length);
    let max=parseInt(this.maxLength);
    document.getElementById("cpt_nom").textContent=(max-nb)+" caractères restants";
})