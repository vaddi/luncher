// functions.js //

// New Scope via IIEF
//(function () {

	let searchArr = [];

	// remove from array by given Value
	function remove(arr, item) {
		for(let i = arr.length; i--;) {
		  if(arr[i] === item) {
				arr.splice(i, 1);
		  }
		}
	}

	// Show all List Elements
	function showAll() {
		$( '#locations > div' ).each( function() {
			$(this).show();
		});
	}
	
	// Helper to get amount of open Stores
	function refreshOpen() {
		let open = 0;
		$( '#locations > div' ).each( function() {
			if( $( this ).is(":visible") ) open++;
		});
		$( '#counter' ).text( open === 0 ? $( '#totals' ).text() : open );
	}
	
	// Helper to refresh the search string 
	function refreshSearch() {
		// show searchArr as String on Top of result list
		let searchstring = searchArr.length === 0 ? 'Alle' : searchArr.toString();
		$( '#searchstrings' ).html( searchstring );
	}
	
	// Show/Hide List Elements, depend on have one or more searchterms wich are contained in searchArr
	function renderList() {
		let counter = 0;
		$( '#locations > div' ).each( function() {
			$(this).hide();
			let obj = $( this );
			$( searchArr ).each( function( index, value ) {
				if( obj.attr( 'data-search' ).indexOf( value ) != -1 ) {
					obj.show();
					counter++;
				}
			});
		});
		if( counter === 0 ) showAll();
		// refresh counter
		refreshOpen();
		// refresh search string output
		refreshSearch();
	}

	// deactivate all checkboxes by given Value
	function deselectAll() {
		$('label > input[type=checkbox]').each( function() {
			$( this ).parent().hasClass('active') ? $( this ).parent().removeClass('active') : null;
			$( this ).prop('checked', false);
		});
		searchArr = [];
		renderList();
	}

	// deactivate all checkboxes by given Value
	function deactivateByVal( value ) {
		$('label > input[type=checkbox]').each( function() {
			if( $( this ).val() === value ) {
				$( this ).parent().hasClass('active') ? $( this ).parent().removeClass('active') : null;
				$( this ).prop('checked', false);
			}
		});
	}

	// activate all checkboxes by given Value
	function activateByVal( value ) {
		$('label > input[type=checkbox]').each( function() {
			if( $( this ).val() === value ) {
				$( this ).parent().hasClass('active') ? null : $( this ).parent().addClass('active');
				$( this ).prop('checked', true);
			}
		});
	}
	
	
$(document).ready( function() {
	
	// onclick event to fill value into searchArr
	$('label > input[type=checkbox]').on('change', function () {
		if( $( this ).is(':checked') ) {
			// ad to searchArr if not allready in there
			if( searchArr.indexOf( $( this ).val() ) === -1 ) searchArr.push( $( this ).val() );
			// mark all active wich have the same value
			activateByVal( $( this ).val() );
		} else {
			remove( searchArr, $( this ).val() );
			deactivateByVal( $( this ).val() );
		}
		renderList();
	});
	
	// add target _blank to each external link witch hasn't allready a target attribute
	$( 'a' ).each( function() {
		if( this.target === '' && this.href != undefined && this.href.indexOf('http') != -1 ) {
			$( this ).attr( 'target', '_blank' );
		}
	});	
	
	// Add initial counter value
	$( '#counter' ).text( $( '#totals' ).text() );
	
	// Initialize bootstrap tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
});


/**
 * Helper function to render a Modal into the Page
 */
function showModal( text, title ) {
	if( text === undefined || text === '' ) return;
	if( title === undefined || title === '' ) var title = 'Infotext';
	let id = 'pageModal';
	
	// Additional info
	var additional = "";
	additional += '<br /><br />';
	additional += 'Aktuelle Version: <a href="' + APPRepository + '/releases" target="_blank">' + APPVersion + '</a><br />';
	additional += 'Fragen und Anregungen: <a href="https://github.com/vaddi/luncher/wiki" target="_blank">wiki</a><br />';
	additional += 'Probleme berichten: <a href="https://github.com/vaddi/luncher/issues" target="_blank">issues</a><br /><br />';
	additional += 'PHP <a href="http://packages.ubuntu.com/de/trusty/php5" target="_blank">' + PHPVersion + '</a><br />';
	additional += 'Bootstrap <a href="https://github.com/twbs/bootstrap/releases/latest" target="_blank">v3.3.7</a><br />';
	additional += 'jQuery <a href="https://github.com/jquery/jquery/releases" target="_blank">3.1.1</a>';
	text = text + additional;
	
	if( $( '#' + id ).length <= 0 ) {
		let modal = '<div id="' + id + '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" style="width: 100%;">';
		modal += '<div class="modal-dialog modal-dialog-breiter" role="document">';
		modal += '	<div class="modal-content">';
		modal += '		<div class="modal-header">';
		modal += '			<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
		modal += '				<span aria-hidden="true">&times;</span>';
		modal += '			</button>';
		modal += '			<h4 class="modal-title">' + title + '</h4>';
		modal += '		</div>';
		modal += '		<div class="modal-body">';
		modal += text;
		modal += '		</div>';
		modal += '		</div>';
		modal += '	</div>';
		modal += '</div>';
		$( '#content' ).append( modal );
	} else {
		$( '#pageModal' ).find( '.modal-header h4' ).text( title );
		$( '#pageModal' ).find( '.modal-body' ).html( text );
	}
	$( '#pageModal' ).modal( 'show' );
}


//}());

