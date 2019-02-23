<?php

// shortcode to output current events

function hihc_events_archive_shortcode( $atts ) {
	ob_start();
	echo '<div class="hihc-events">';
	$events_found = false;
	
	$now = current_time( 'Ymd' );
	
	$metaqueries = array(
		array(
			'key'     => 'date',
			'value'   => $now,
			'compare' => '>=',
			'type'    => 'NUMERIC',
		),
		array(
			'key'   => 'date',
			'value' => false,
			'type'  => 'BOOLEAN',
		),
	);
	
	foreach ( $metaqueries as $metaquery ) {
		
		$args   = array(
			'post_type'      => 'hihc-event',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'meta_query'     => array( $metaquery ),
		);
		$events = new WP_Query( $args );
		
		if ( $events->have_posts() ) {
			$events_found = true;
			while( $events->have_posts() ) {
				$events->the_post();
				include( HIHC_EVENTS_PATH . '/template-parts/content-hihc-event.php' );
			}
			wp_reset_postdata();
		}
	}
	
	if ( ! $events_found ) {
		echo '<p>No upcoming events found.</p>';
	}
	
	echo '</div>';
	
	return ob_get_clean();
}

add_shortcode( 'hihc_events', 'hihc_events_archive_shortcode' );