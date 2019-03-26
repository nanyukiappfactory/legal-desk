/*Export Table Init*/

"use strict"; 

$(document).ready(function() {
	$('#transactions').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	} );
} );