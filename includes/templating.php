<?php


// use custom template for single posts
add_filter( 'single_template', 'hihc_event_single_custom_template' );

function hihc_event_single_custom_template( $single_template ) {
	if ( is_singular( 'hihc-event' ) ) {
		if ( file_exists( HIHC_EVENTS_PATH . '/templates/single-hihc-event.php' ) ) {
			return HIHC_EVENTS_PATH . '/templates/single-hihc-event.php';
		}
	}
	
	return $single_template;
}

// use custom template for archives
add_filter( 'archive_template', 'hihc_event_archive_custom_template' );

function hihc_event_archive_custom_template( $archive_template ) {
	if ( is_post_type_archive( 'hihc-event' ) ) {
		if ( file_exists( HIHC_EVENTS_PATH . '/templates/archive-hihc-event.php' ) ) {
			return HIHC_EVENTS_PATH . '/templates/archive-hihc-event.php';
		}
	}
	
	return $archive_template;
}


// helper function to determine if event is tba, upcoming, ended, ongoing
function get_hihc_event_status( $postID = '' ) {
	
	$status = 'tba';
	$postID = $postID ?: get_the_ID();
	
	if ( $startdate = get_field( "date", $postID ) ) {
		$now       = current_time( 'Ymd' );
		$recurring = get_field( "recurring_event", $postID );
		$enddate   = $recurring ? get_field( "end_date", $postID ) : $startdate;
		$enddate   = $enddate ?: 999999999999;
		
		if ( $recurring ) {
			if ( $enddate < $now ) {
				$status = 'ended recurring';
			} elseif ( $startdate > $now ) {
				$status = 'upcoming recurring';
			} else {
				$status = 'ongoing recurring';
			}
		} else {
			if ( $enddate < $now ) {
				$status = 'ended';
			} else {
				$status = 'upcoming';
			}
		}
	}
	
	return $status;
}


// helper function to output the dateboxes consistently
function get_hihc_event_datebox( $postID = '' ) {
	
	ob_start();
	
	$postID = $postID ?: get_the_ID();
	
	
	if ( $date = get_field( "date", $postID ) ) {
		$datetime     = strtotime( $date );
		$status       = get_hihc_event_status( $postID );
		$datebox_flag = '';
		
		if ( is_post_type_archive( 'hihc-event' ) ) {
			$month = date( 'M Y', $datetime );
		} else {
			$month = date( 'F', $datetime );
		}
		$day = date( 'j', $datetime );
		
		if ( $status == 'ongoing recurring' ) {
			$datebox_flag = 'Series began on:';
		}
		if ( $status == 'upcoming recurring' ) {
			$datebox_flag = 'Series begins on:';
		}
		?>
		
		<div class="hihc-event-datebox<?php if ( $status == 'ended' || $status == 'ended recurring' ) {
			echo ' event-ended';
		} ?>">
			<?php if ( $datebox_flag ): ?>
				<div class="datebox-flag"><?php echo $datebox_flag; ?></div>
			<?php endif; ?>
			<div class="month"><?php echo $month; ?></div>
			<div class="day"><?php echo $day; ?></div>
		</div>
		
		<?php
	} else {
		?>
		
		<div class="hihc-event-datebox event-tba">
			<div class="day">TBA</div>
		</div>
		
		<?php
	}
	
	return ob_get_clean();
}