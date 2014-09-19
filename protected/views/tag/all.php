<h1>Oблако тегов</h1>
<?php

foreach ($listAllTagsCounts as $tag)
{
	echo '<div><a style="font-size: '.$tag['size'].'pt;" href="/tag/view/id/'.$tag['id'].'">'.$tag['name'].'</a></div>';
}
?>
