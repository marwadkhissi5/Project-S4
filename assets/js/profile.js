function afficherForm() {
  const infos = document.getElementById("infos-actuelles");
  const form = document.getElementById("form-modif");
  const isHidden = form.style.display === "none";

  infos.style.display = isHidden ? "none" : "block";
  form.style.display = isHidden ? "block" : "none";
}
