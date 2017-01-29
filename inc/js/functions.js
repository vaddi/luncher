// functions.js //

var searchArr = [];

// remove from array by given Value
function remove(arr, item) {
  for(var i = arr.length; i--;) {
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

// Show/Hide List Elements, depend on have one or more searchterms wich are contained in searchArr
function renderList() {
	var counter = 0;
	$( '#locations > div' ).each( function() {
		$(this).hide();
		var obj = $( this );
		$( searchArr ).each( function( index, value ) {
			if( obj.attr( 'data-search' ).indexOf( value ) != -1 ) {
				obj.show();
				counter++;
			} 
		});
	});
	if( counter == 0 ) showAll();
	// show searchArr as String on Top of result list
	var searchstring = searchArr.length == 0 ? 'Alle' : searchArr.toString();
	$( '#searchstrings' ).html( searchstring );
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
		if( $( this ).val() == value ) {
			$( this ).parent().hasClass('active') ? $( this ).parent().removeClass('active') : null;
			$( this ).prop('checked', false);
		}
	});
}

// activate all checkboxes by given Value
function activateByVal( value ) {
	$('label > input[type=checkbox]').each( function() {
		if( $( this ).val() == value ) {
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
			if( searchArr.indexOf( $( this ).val() ) == -1 ) searchArr.push( $( this ).val() );
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
		if( this.target == '' && this.href != undefined && this.href.indexOf('http') != -1 ) {
			$( this ).attr( 'target', '_blank' );
		}
	});	
	
});

