function js_change_dep() {
  var myselect = document.getElementById("liste_dep");

  //Vérification Présence Autre Combo Box
  if ("#liste_ville:not(:empty)") {
    $("#liste_ville").fadeOut();
    if ("#infos_ville:not(:empty)") {
      $("#infos_ville").fadeOut();
    }
  }
  $("#liste_ville").empty(); //vide la combo box
  $.ajax({
    type: "POST",
    url: "ajax/recherche_ville.php",
    dataType: "json",
    encode: true,
    data: "id_dep=" + myselect.options[myselect.selectedIndex].value, // on envoie via post l’id
    success: function(retour) {
      $("#liste_ville").fadeIn();
      $.each(retour, function(index, value) {
        // pour chaque noeud JSON
        // on ajoute l option dans la liste
        $("#liste_ville").append(
          "<option value=" + value + ">" + index + "</option>"
        );
      });
      $("#liste_ville").focus();
    },
    error: function(jqXHR, textStatus) {
      // traitement des erreurs ajax
      liste_ville.style.visibility = "hidden";
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

function js_change_ville() {
  var villeSelected = document.getElementById("liste_ville");
  if ("#infos_ville:not(:empty)") {
    $("#infos_ville").fadeOut();
  }
  $.ajax({
    type: "POST",
    url: "ajax/recherche_info_ville.php",
    dataType: "json",
    encode: true,
    data:
      "id_ville=" + villeSelected.options[villeSelected.selectedIndex].value,
    success: function(retour) {
      $("#infos_ville").fadeIn();
      $("#iddep").val(retour["ville_departement"]);
      $("#ville_cp").val(retour["ville_code_postal"]);
      $("#ville_nom").val(retour["ville_nom_reel"]);
      $("#ville_lat").val(retour["ville_latitude_deg"]);
      $("#ville_long").val(retour["ville_longitude_deg"]);

      $("#map").fadeIn();
      map.style.height = "400px";
      $("#map").empty();
      $("#map").append(
        init(
          Number(retour["ville_longitude_deg"]),
          Number(retour["ville_latitude_deg"])
        )
      );
    },
    error: function(jqXHR, textStatus) {
      // traitement des erreurs ajax
      map.style.visibility = "hidden";
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

function init(longi, latti) {
  var posi = [longi, latti];
  var map = new ol.Map({
    target: "map",
    layers: [
      new ol.layer.Tile({
        source: new ol.source.OSM()
      })
    ],
    view: new ol.View({
      center: ol.proj.fromLonLat(posi),
      zoom: 14
    })
  });
}
