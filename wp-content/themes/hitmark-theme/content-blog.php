<?php
$blog_post_id =get_option('page_for_posts');   
?>
<?php 
if ( have_posts() ) :  
	while ( have_posts() ) : 
	the_post();  ?>						
	<div class="items">
	<?php
		$img='';
		$image_id = get_post_thumbnail_id(get_the_ID());   
		$urls=wp_get_attachment_image_src($image_id,'full'); 
		if (isset($urls[0])) {  $img=$urls[0];} 
		if ($img!='') {
			 print '<a href="'.get_the_permalink().'" class="image"><img src="'.$img.'"></a>';
		} 
		?>
		<h2><a href="<?php the_permalink();?>" class="title"><?php the_title();?></a></h2>
		<div class="time"><?php print get_post_time('d', true);?> <?php print get_post_time('m', true);?> , <?php print get_post_time('Y', true);?></div> 
		<div class="read_more">
			<a href="<?php the_permalink();?>">read more</a>
		</div>								 								 
	</div>
<?php
	endwhile;
endif;
?>	
<?php
the_posts_pagination( array('prev_text'  => '<i class="fal fa-angle-left"></i>','next_text'  => '<i class="fal fa-angle-right"></i>','before_page_number' => '','screen_reader_text' =>''));
?>