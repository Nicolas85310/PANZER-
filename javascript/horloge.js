function afficher() {
  var offsetUTC = +12,
  lD = new Date(),
  oD = new Date();
  oD.setHours(lD.getUTCHours()+offsetUTC);
 
  document.getElementById('horloge').innerHTML = "Nous sommmes le "+lD.toLocaleString();
  
}
 
window.onload=function() {
  afficher();
  setInterval(afficher,1000);
}