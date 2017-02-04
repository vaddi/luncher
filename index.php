<!DOCTYPE html>
<html lang="en">
<?php

// constants 
define( 'APPNAME', 'launcher' ); 
define( 'APPDESC', 'Kleine App zum finden einer Örtlichkeit zum Speisen in Wolfsburg (Innenstadt).' );
define( 'APPKEYW', 'Mittagstisch-Finder, Mittagstisch, Wolfsburg, 38440, Porschestr., Porschestraße' );

?>
<head>
	<title><?= APPNAME ?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="keywords" content="<?= APPKEYW ?>" />
	<meta name="description" content="<?= APPDESC ?>" />
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
	$locations = $luncher->getLocations();
	$tags = $luncher->getTags();
	$angebote = $luncher->getAngebote();
	$entfernungen = $luncher->getEntfernungen();
	
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
		$result .= '<blockquote>' . $element->geöffnet . '</blockquote>';
		// labels
		$result .= '<p class="list-group-item-text">';
		$result .= Base::arr2label( $element->tags ) . " ";
		$result .= Base::arr2label( $element->angebote ) . " ";
		$result .= '</p>';
		$result .= '</div>' . "\n";
		return $result;
	}
	
?>
	
	<header class="page-header row">
		<div class="col-sm-2 pull-left" style="font-size:59px;margin:20px 0 0 0;">
			<a onclick="deselectAll()" title="Alle Deaktivieren" data-toggle="tooltip">
				<span class="glyphicon glyphicon-cutlery"></span>
			</a>
		</div>
		<div class="col-sm-10">
			<h1><?= ucfirst(APPNAME) ?> <small>Der Mittagstisch-Finder</small></h1>
			<p><?= APPDESC ?></p>
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
			echo '		' . $tag . " \n";
		}
		echo '	</div>';
		echo '</div>' . "<br /><br />\n";
		
		// angebote
		echo '<div class="row">';
		echo '	<label class="control-label col-sm-2" style="margin-top:5px;">Angebote:</label> ';
		echo '	<div data-toggle="buttons" class="form-group col-sm-10">';
		foreach ( $angebote as $aid => $angebot ) {
			echo  '		' . $angebot . " \n";
		}
		echo '	</div>';
		echo '</div>' . "<br /><br />\n";
		
		// entfernung
		echo '<div class="row">';
		echo '	<label class="control-label col-sm-2" style="margin-top:5px;">Minuten:</label> ';
		echo '	<div data-toggle="buttons" class="form-group col-sm-10">';
		foreach ( $entfernungen as $eid => $entfernung ) {
			echo  '		' . $entfernung . " \n";
		}
		echo '	</div>';
		echo '</div>' . "<br /><br />\n";
		
		// print searchstrings
		echo '<div class="row">';
		echo '	<label class="control-label col-sm-2" style="">Filter:</label> ';
		echo '	<div class="pull-right col-sm-1"><span id="counter">0</span> / <span id="totals">' . $luncher->getTotal() . '</span></div>';
		echo '	<div id="searchstrings" class="col-sm-9">Alle</div>';
		echo '</div>' . "<br />\n";
		
		// list of locations
		echo '<div id="locations" class="list-group">';
		$result = '';
		foreach ( $locations as $id => $location ) {
			$result = buildElement( $location, $id );
			echo  '	' . $result;
		}
		echo '</div>' . "<br />\n";
	} else {
		// locations = false
		echo '<div id="locations" class="list-group">';
		echo '<div class="list-group-item list-group-item-info">';
		echo '<strong>Alle Läden geschlossen.</strong>';
		echo '</div>';
		echo '</div>' . "<br />\n";
	}

?>
	
		<div class="clear"></div>
		
		<footer>
			<p class="pull-center pull-top">· <?= date('Y') ?> ·</p>
			<p class="pull-right"> <?= APPNAME ?> on <a href="https://github.com/vaddi/<?= APPNAME ?>">github.com</a></p>
			<p>
				Bootstrap <a href="https://github.com/twbs/bootstrap/releases/latest">v3.3.7</a> · 
				jQuery <a href="https://github.com/jquery/jquery">3.1.1</a>
			</p>
		</footer>
	
	</div>
	
</div>

</body>
</html>
