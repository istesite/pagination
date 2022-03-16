<style>
ul.pagination { 
	display:block; 
	text-align:center; 
	padding:0; 
	margin:0;
	}
	
ul.pagination > li {
	display:inline-block;
	}
	
ul.pagination > li > a, ul.pagination > li > span, ul.pagination > li > span.spacer { 
	display:inline-block; 
	min-width:15px; 
	margin:2px 0.5px; 
	text-decoration:none; 
	color:#333; 
	font-family:Trebuchet MS; 
	font-size:13px; 
	background:#eee; 
	border:1px solid #666; 
	padding:4px; 
	border-radius:5px;
	}
	
ul.pagination > li > span { 
	background:#ad0;
	}
	
ul.pagination > li > a:hover { 
	color:#333; background:#de9;
	}
</style>

<?php
include_once "pagination.class.php";
$pagi = new Pagi(15, 'page');
echo $pagi->getContent();

?>