<!-- main -->
<div class="wrap">
<h1> Aqu&iacute; va el titulo de algo</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque nunc urna, ut rhoncus ligula. Vestibulum imperdiet odio in odio lobortis aliquet. Cras lorem ipsum, rutrum ut hendrerit a, placerat ac dolor. Nulla mollis, sapien sed rhoncus aliquam, magna arcu eleifend sapien, vel faucibus urna ligula id urna. Vestibulum vulputate lorem ut ipsum posuere at vulputate nibh pulvinar. Fusce non risus vel justo elementum blandit. Vivamus placerat dapibus nibh at fermentum. Fusce non nibh eros, sed vestibulum risus. In lectus ipsum, lacinia ut mattis et, consequat sit amet felis. Aliquam erat volutpat. In hac habitasse platea dictumst. Ut eleifend libero eu nibh porta vel consequat mauris eleifend. Vestibulum ornare pellentesque erat sit amet interdum. Praesent sit amet fringilla dui. Pellentesque eget massa mi, et vulputate enim. Fusce nisl turpis, molestie a vulputate non, aliquet in tortor.</p>

<table border="1" bordercolor="#000" style="background-color:#fff" width="80%" cellpadding="0" cellspacing="0">
	<tr>
		<td>Table Cell</td>
		<td>Table Cell</td>
	</tr>
	<tr>
		<td>Table Cell</td>
		<td>Table Cell</td>
	</tr>
	<tr>
		<td>Table Cell</td>
		<td>Table Cell</td>
	</tr>
	<tr>
		<td>Table Cell</td>
		<td>Table Cell</td>
	</tr>
	<tr>
		<td>Table Cell</td>
		<td>Table Cell</td>
	</tr>
</table>
<?php
$rss = fetch_feed('http://feeds.feedburner.com/ElBlogDeAbr4xasVol2');
$rss_items = $rss->get_items( 0, $rss->get_item_quantity(1) );
if ( !$rss_items ) {
	echo 'no items';
} else {
	foreach ( $rss_items as $item ) {
		echo '<h2><a href="' . $item->get_permalink() . '">' . $item->get_title() . '</a></h2>';
		echo '<p>' . $item->get_content() . '</p>';
	}
}
?>

</div> 


<!-- / main -->
