<h1>Categories</h1>
<?php  
foreach($listCategory as $key=> $category) {
echo '<b>'.$category.'</b> Товары:';
if(!empty($listProduct[$key])) {
	foreach($listProduct[$key] as $product) {
		echo ' <i>'.$product.'</i>';		
	}
}
?> <br> <?php
}
?>
