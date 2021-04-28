<?php 
get_header(); 
	if ( have_posts() ) : 
		if ( !is_front_page() && is_home() ) { 
			get_template_part( 'content', 'blog' ); 
		}
		else   
		{
			the_content(); 		
		}
	endif; 
get_footer();			   
 ?>