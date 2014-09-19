
<h1>Товары отсортированные по кол-ву тегов</h1>

Название товара - кол-во тегов<br>
<?php 
		if(!empty($listProductsTagsCounts)) {
			foreach($listProductsTagsCounts as $productsTagsCounts) {				
					echo ' <i>'.$productsTagsCounts['name'].'</i> - '.$productsTagsCounts['COUNT( product_to_tag.product_id )'].'<br>';				
			}
		}
		if(!empty($listProductsTagsNullCounts)) {
			foreach($listProductsTagsNullCounts as $productsTagsNullCounts) {				
					echo ' <i>'.$productsTagsNullCounts.'</i> - 0<br>';				
			}
		}
?>

