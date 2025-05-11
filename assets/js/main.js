function SetCookie(nom,val,nb_jour){

  const expiration=new Date(Date.now+nb_jour*864e5).toUTCString();
  document.cookie=nom+"="+encodeURIComponent(val)+"; expires="+expiration+"; path=/";

}

function GetCookie(nom){
  return document.cookie.split("; ").reduce((r,v)=>{
      const elt=v.split("=");
      return elt[0]==nom?decodeURIComponent(elt[1]):r;
  },"");
}

function ModifMode(mode) {
  document.body.className = ""; // réinitialiser les classes
  document.body.classList.add(mode); 
  SetCookie("temp",mode,2);
}

window.addEventListener("load",()=>{
  const temp=GetCookie("temp");
  if (temp){
    document.body.className = ""; // réinitialiser les classes
    document.body.classList.add(temp);
      }
})

