<?php
if ($post_data['post_type'] == 'lesson') {
	echo trim(healthandcare_get_lessons_links($parent_id, $post_data['post_id'], array(
		'header' => esc_html__('Course Content', 'healthandcare'),
		'show_prev_next' => true
		)));
} else {
	wp_link_pages( array( 
		'before' => '<nav class="pagination_single" role="navigation"><span class="pager_pages">' . esc_html__( 'Pages:', 'healthandcare' ) . '</span>',
		'after' => '</nav>',
		'link_before' => '<span class="pager_numbers">',
		'link_after' => '</span>'
		)
	); 
}
?>