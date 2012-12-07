<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php echo $title ?> - wdzGalerie</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/global/bootstrap.min.css');?>" class="switchable" />
        
        <?php
		//echo link_tag('css/global/bootstrap.min.css');
		//echo link_tag('css/cyborg/bootstrap.min.css');
		echo link_tag('css/global/bootstrap-responsive.min.css');
		echo link_tag('css/global/main.css');
		echo link_tag('css/fullscreenstyle.css');
		?>
		<script src="<?php echo base_url('js/global/modernizr-2.6.1-respond-1.1.0.min.js')?>"></script>
	</head>

	<body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="<?php echo base_url(index_page() . '/pages/accueil')?>">wdzGalerie</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="<?php echo base_url(index_page() . '/pages/accueil')?>">Accueil</a></li>
                            <li><a href="<?php echo base_url(index_page() . '/admin/accueil')?>">Administration</a></li>
                            <li class="dropdown">
                            	<a href="#theme" class="dropdown-toggle" data-toggle="dropdown">Theme</a>
                            	<ul id="cssSwitch" class="dropdown-menu">
				                  <li><a href="#" rel="<?php echo base_url('css/global/bootstrap.min.css');?>">Defaut</a></li>
				                  <li class="divider"></li>
				                  <li><a href="#" rel="<?php echo base_url('css/slate/bootstrap.min.css');?>">Slate</a></li>
				                  <li><a href="#" rel="<?php echo base_url('css/cyborg/bootstrap.min.css');?>">Cyborg</a></li>
				                  <li><a href="#" rel="<?php echo base_url('css/spacelab/bootstrap.min.css');?>">Spacelab</a></li>
				                </ul>
                            </li>
                        </ul>
                        <form id='searchForm' class="navbar-search pull-right">
                        	<div class="input-append">
                             <input id="searchField" type="text" class="search-query" placeholder="Rechercher une galerie" data-provide='typeahead'>
                             <span class="add-on"><i class="icon-search"></i></span>
                             </div>
                        </form>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>