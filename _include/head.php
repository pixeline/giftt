<!-- DEVICE OPTIMIZATION -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="cleartype" content="on">
<meta name="apple-mobile-web-app-title" content="Giftt">

<!-- META -->
<meta name="description" content="Create wishlists, share wishlists">
<meta name="copyright" content="Pierre Stoffe">
<meta name="author" content="Pierre Stoffe, bonjour@pierrestoffe.com">

<!-- FAVICONS AND STUFF -->
<link rel="apple-touch-icon" sizes="57x57" href="/_assets/images/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="114x114" href="/_assets/images/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="72x72" href="/_assets/images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="144x144" href="/_assets/images/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="60x60" href="/_assets/images/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="120x120" href="/_assets/images/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="76x76" href="/_assets/images/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="152x152" href="/_assets/images/apple-touch-icon-152x152.png">
<link rel="icon" type="image/png" href="/favicon-196x196.png" sizes="196x196">
<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<meta name="msapplication-TileColor" content="#7fba42">
<meta name="msapplication-TileImage" content="/_assets/images/mstile-144x144.png">

<!-- OG: -->
<?php
	$og_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<meta property="og:url" content="<?php echo $og_url; ?>" />
<?php
	if(isset($current_wish)){
		$og_title = $current_wish['name'] . " on Giftt.me";
	}else{
		$og_title = "Giftt.me";
	}
?>
<meta property="og:title" content="<?php echo $og_title; ?>" />
<?php
	if(isset($current_wish)){
		$og_description_raw = preg_replace( "/\r|\n/", "", $current_wish['description'] );
		$og_description = strlen($og_description_raw) > 200 ? substr($og_description_raw, 0, 200) . "..." : $og_description_raw;
	}else{
		$og_description = "Create wishlists, share wishlists";
	}
?>
<meta property="og:description" content="<?php echo $og_description; ?>" />
<?php
	if(isset($current_wish)){
		$og_picture = "https://" . $_SERVER['HTTP_HOST'] ."/" . $current_wish['picture'];
	}else{
		$og_picture = "https://giftt.me/_assets/images/logo.png";
	}
?>
<meta property="og:image" content="<?php echo $og_picture; ?>" />
<meta property='og:site_name' content='Giftt'>

<!-- LINKED FILES -->
<link rel="stylesheet" href="/_assets/css/style.css">
<script type="text/javascript" src="//use.typekit.net/jmx3imb.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<!--[if lt IE 9]>
	<script src="/_assets/js/html5shiv.min.js"></script>
<![endif]-->