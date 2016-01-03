$(document).ready(function() {
    $('#Tabla-Categoria').DataTable( {
	    language: {
	        processing:     "Traitement en cours...",
	        search:         "Buscar por:",
	        lengthMenu:    "Mostrar _MENU_ Elementos",
	        info:           "Mostrando _START_ a _END_ de _TOTAL_ Elementos",
	        infoEmpty:      "Mostrando 0 registros de 0 registros encontrados",
	        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
	        infoPostFix:    "",
	        loadingRecords: "Chargement en cours...",
	        zeroRecords:    "<span class='text-danger'>No se encontro ningún elemento.</span>",
	        emptyTable:     "<span class='text-danger'>No se encontro ningún registro disponible.</span>",
	        paginate: {
	            first:      "Premier",
	            previous:   "Anterior",
	            next:       "Siguiente",
	            last:       "Dernier"
	        },
	        aria: {
	            sortAscending:  ": activer pour trier la colonne par ordre croissant",
	            sortDescending: ": activer pour trier la colonne par ordre décroissant"
	        }
	    }
	} );
} );