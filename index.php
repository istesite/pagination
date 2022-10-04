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

ul.pagination > li > input[type="text"], ul.pagination > li > input[type="number"] {
    display: inline-block;
    margin: 2px 0.5px;
    padding:4px 7px;
    border-radius:5px;
    max-width:50px;
    border:1px solid #666;
    color:#333;
    background:#eee;
    font-family: Trebuchet MS;
    font-size:13px;
}
</style>

<?php
include_once "pagination.class.php";
$pagi = new Pagi(3, 'page');
echo $pagi->getContent();
echo "\n<br>";

$pagi->setTotalPage(25);
echo $pagi->getContent();
echo "\n<br>";

$pagi->setPageLimit(5);
echo $pagi->getContent();
echo "\n<br>";
?>