function valide_article(id) {
  alert(id);
  $.ajax({
    type: "POST",
    url: "ajax/publierArticle.php",
    dataType: "json",
    encode: true,
    data: "idArticle=" + id, // on envoie via post l’id
    success: function(retour) {
      document.location.href = "./Accueil";
    },
    error: function(jqXHR, textStatus) {
      // traitement des erreurs ajax
      if (jqXHR.status === 0) {
        alert("Not connect.n Verify Network.");
      } else if (jqXHR.status == 404) {
        alert("Requested page not found. [404]");
      } else if (jqXHR.status == 500) {
        alert("Internal Server Error [500].");
      } else if (textStatus === "parsererror") {
        alert("Requested JSON parse failed.");
      } else if (textStatus === "timeout") {
        alert("Time out error.");
      } else if (textStatus === "abort") {
        alert("Ajax request aborted.");
      } else {
        alert("Uncaught Error.n" + jqXHR.responseText);
      }
    }
  });
}
