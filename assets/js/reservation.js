const b_prix=document.getElementById("total_prix");
const b_checked=document.querySelectorAll("input[name='options[]']");
const b_personne=document.getElementById("nb_personnes");
const liste_options=document.getElementById("liste-options");
let options=[];

function ListeOptions() {
    liste_options.innerHTML = "";
    b_checked.forEach(opt => {
        if (opt.checked) {
            const li = document.createElement("li");
            li.textContent = opt.parentElement.textContent.trim().split("–")[0];
            liste_options.appendChild(li);
        }
    });
}

b_checked.forEach(box=>{
    box.addEventListener("change",function(){
        const nb_personne=parseInt(b_personne.value);

        if(this.checked){
            let p_final=parseFloat(b_prix.textContent)+parseFloat(box.dataset.prix);
            if (nb_personne > parseInt(box.dataset.nb)){
                p_final+=(nb_personne-parseInt(box.dataset.nb))*parseFloat(box.dataset.prix);
                
            }
            b_prix.textContent=p_final;
            ListeOptions();
        }
        else{
            let p_final=parseFloat(b_prix.textContent)-parseFloat(box.dataset.prix);
            if (nb_personne > parseInt(box.dataset.nb)){
                p_final-=(nb_personne-parseInt(box.dataset.nb))*parseFloat(box.dataset.prix);
            }
            b_prix.textContent=p_final;
            ListeOptions();
        }    
    })
})

b_personne.addEventListener("input",function(){
    const prix_init=document.getElementById("prix_init").value;
    let prix_temp=parseFloat(prix_init);
    const nb_personne=parseInt(this.value);
    let p_final=prix_temp*nb_personne;
    document.getElementById("nb_p").value=this.value;

    b_checked.forEach(box=>{
            
            if(box.checked){
                p_final+=parseFloat(box.dataset.prix);
                if (nb_personne > parseInt(box.dataset.nb)){
                    p_final+=(nb_personne-parseInt(box.dataset.nb))*parseFloat(box.dataset.prix);
                }
                
            } 
    });
    b_prix.textContent=p_final;
    
})
