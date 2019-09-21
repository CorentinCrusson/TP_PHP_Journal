
function js_change_dep (){
  var myselect = document.getElementById("liste_dep");
  return (myselect.options[myselect.selectedIndex].value);
}

$("#liste_ville").empty();//vide la combo box
	$.ajax({
   			type: "POST",
        			url: "ajax/recherche_ville.php",
        			dataType: "json",
			encode          : true,
        			data: "id_dep="+myselect.options[myselect.selectedIndex].value, // on envoie via post l’id
        			success: function(retour) {

            			$.each(retour, function(index, value)
            			 { // pour chaque noeud JSON
                		// on ajoute l option dans la liste
                			$("#liste_ville").append("<option value="+ value +">"+ index +"</option>");						});
   						$("#liste_ville").focus();
   					},
   			error: function(jqXHR, textStatus)
			{
			// traitement des erreurs ajax
     			if (jqXHR.status === 0){alert("Not connect.n Verify Network.");}
    			else if (jqXHR.status == 404){alert("Requested page not found. [404]");}
				else if (jqXHR.status == 500){alert("Internal Server Error [500].");}
				else if (textStatus === "parsererror"){alert("Requested JSON parse failed.");}
				else if (textStatus === "timeout"){alert("Time out error.");}
				else if (textStatus === "abort"){alert("Ajax request aborted.");}
				else{alert("Uncaught Error.n" + jqXHR.responseText);}
			}
   				});

function js_change_ville() {

    success: function(retour) {
  $("#iddep").val(retour ["ville_departement"]);
  $("#ville_cp").val(retour ["ville_code_postal"]);
  $("#ville_nom").val(retour ["ville_nom_reel"]);
  $("#ville_lat").val(retour ["ville_latitude_deg"]);
  $("#ville_long").val(retour ["ville_longitude_deg"]);
  }
}
