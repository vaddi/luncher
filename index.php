<!DOCTYPE html>
<html lang="en">
<head>
	<title>luncher</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="keywords" content="Mittagstisch-Finder, Mittagstisch, Wolfsburg, 38440, Porschestr., Porschestraße" />
	<meta name="description" content="Kleine App zum finden einer Örtlichkeit zum Speisen in Wolfsburg (Innenstadt)." />
	<!-- icon -->
	<script type="text/javascript" src="inc/js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="inc/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="inc/js/functions.js"></script>
	<link href="inc/css/bootstrap.min.css" rel="stylesheet">
	<link href="inc/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
	
<?php

	require_once( 'inc/data.php' );
	require_once( 'inc/class/class.Luncher.php' );
	
	$luncher = new Luncher( $data );
	$tags = $luncher->getTags();
	$angebote = $luncher->getAngebote();
	$entfernungen = $luncher->getEntfernungen();
	$locations = $luncher->getLocations();
	
	function buildElement( $element ) {
		$lname = strtolower( trim( $element->name ) );
		$result  = '<div class="list-group-item" data-search="' . Base::arr2str( $element->angebote ) . Base::arr2str( $element->tags ) . Base::arr2str( $element->entfernung ) . '">' . "\n";
		// link elements
		$result .= '<div class="pull-right elinks">';
		$result .= '<span title="' . $element->entfernung . '. zu Fuß" data-toggle="tooltip" data-placement="right">' . $element->entfernung . '. Fußweg</span>&ensp;';
		$result .= ( $element->lat != '' && $element->long != '' ) ? '<a href="' . Base::linkTo( $element->lat, $element->long, $element->zoom, $element->name ) . '" title="Auf G-Maps zeigen" data-toggle="tooltip"><span class="glyphicon glyphicon-map-marker"></span></a>&ensp;' : '';
		$result .=  $element->url['long'] != '' ? '<a href="' . $element->url['long'] . '" title="Webseite besuchen" data-toggle="tooltip"><span class="glyphicon glyphicon-globe"></span></a>&ensp;' : '';
		$result .= $element->email != '' ? '<a href="mailto:' . $element->email . '" title="E-Mail schreiben" data-toggle="tooltip"><span class="glyphicon glyphicon-envelope"></span></a>&ensp;' : '';
		$result .=  $element->tel != '' ? '<a href="tel:' . $element->tel . '" title="Anrufen" data-toggle="tooltip"><span class="glyphicon glyphicon-earphone"></span></a>' : '';
		$result .= '</div>';
		// headline
		$result .= '<h2 class="list-group-item-heading">';
		$result .= $element->name;
		$result .= '</h2>';
		// opening
		$result .= $element->geöffnet;
		// labels
		$result .= '<p class="list-group-item-text">';
		$result .= Base::arr2label( $element->tags ) . " ";
		$result .= Base::arr2label( $element->angebote ) . " ";
		$result .= '</p>';
		$result .= '</div>' . "\n";
		return $result;
	}
	
	echo '<script type="text/javascript">var acc = `' . buildElement( $luncher->getRandLocation(), true ) . '`;</script>'
	
?>
	
	<header class="page-header row">
		<div class="col-sm-2 pull-left" style="font-size:59px;margin:20px 0 0 0;">
			<a onclick="deselectAll()" title="Alle Deaktivieren" data-toggle="tooltip">
				<span class="glyphicon glyphicon-cutlery"></span>
			</a>
		</div>
		<div class="col-sm-10">
			<h1>Luncher <small>Der Mittagstisch-Finder</small></h1>
			<p>Kleine App zum finden eines Mittagstisches in der Wolfsburger Innenstadt (Porschestraße).</p>
		</div>
	</header>
	
	
	<div class="maincont">
		
		<div id="content" class="appcontent"></div>

<?php
	
	if( $locations ) {
		
		// tags
		echo '<div class="row">';
		echo '	<label class="control-label col-sm-2" style="margin-top:5px;">Kategorie:</label> ';
		echo '	<div data-toggle="buttons" class="form-group col-sm-10">';
		foreach ( $tags as $tid => $tag ) {
			print_r( '		' . $tag . " \n" );
		}
		echo '	</div>';
		echo '</div>' . "<br /><br />\n";
		
		// angebote
		echo '<div class="row">';
		echo '	<label class="control-label col-sm-2" style="margin-top:5px;">Angebote:</label> ';
		echo '	<div data-toggle="buttons" class="form-group col-sm-10">';
		foreach ( $angebote as $aid => $angebot ) {
			print_r( '		' . $angebot . " \n" );
		}
		echo '	</div>';
		echo '</div>' . "<br /><br />\n";
		
		// entfernung
		echo '<div class="row">';
		echo '	<label class="control-label col-sm-2" style="margin-top:5px;">Minuten:</label> ';
		echo '	<div data-toggle="buttons" class="form-group col-sm-10">';
		foreach ( $entfernungen as $eid => $entfernung ) {
			print_r( '		' . $entfernung . " \n" );
		}
		echo '	</div>';
		echo '</div>' . "<br /><br />\n";
		
		// print searchstrings
		echo '<div class="row">';
		echo '	<label class="control-label col-sm-2" style="">Filter:</label> ';
		echo '	<div id="searchstrings" class="col-sm-10">Alle</div>';
		echo '</div>' . "<br />\n";
		
		// list of locations
		echo '<div id="locations" class="list-group">';
		$result = '';
		foreach ( $locations as $id => $location ) {
			$result = buildElement( $location );
			print_r( '	' . $result );
		}
		echo '</div>' . "<br />\n";
		
	} else {
		// locations = false
		echo "Keine Daten in \$locations";
	}

?>
	
		<div class="clear"></div>
		
		<footer style="padding:10px 0 30px;">
			<p class="pull-center pull-top">· <?= date('Y') ?> ·</p>
			<p class="pull-right"> <a href="http://www.mvattersen.de/">mvattersen.de</a></p>
			<p>
				Bootstrap <a href="https://github.com/twbs/bootstrap/releases/latest">v3.3.7</a>
				jQuery <a href="https://github.com/jquery/jquery">3.1.1</a>
			</p>
		</footer>
	
	</div>
	
</div>

</body>
</html>
