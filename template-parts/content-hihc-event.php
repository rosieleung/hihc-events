<?php

$img      = get_field( "thumbnail", $post->ID );
$imgclass = $img ? ' has-img' : ' no-img';

echo '<article class="archive-hihc-event', $imgclass, '">';
echo get_hihc_event_datebox( $post->ID );
echo '<h3><a href="', get_the_permalink( $post->ID ), '">Title: ' . get_the_title( $post ) . '</a></h3>';


echo '<div class="hihc-event-content-wrapper">';
if ( $img ) {
	echo '<div class="hihc-event-img">';
	echo wp_get_attachment_image( $img, 'thumbnail' );
	echo '</div>';
}

echo '<div class="hihc-event-content">';
the_content();

$button = false;
$status = get_hihc_event_status( $post->ID );
// change link into button for upcoming events that allow registration
if ( $status != 'ended' && $status != 'ended recurring' ) {
	$registration = get_field( "registration", $post->ID );
	$form         = $registration['form_type'];
	$button       = $form != 'none' ? true : false;
}

if ( $button == false ) {
	echo '<p><a href="', get_the_permalink( $post->ID ), '">Event details &rarr;</a></p>';
} else {
	echo '<div class="hihc-event-readmore-button"><a href="', get_the_permalink( $post->ID ), '">Register Online</a></div>';
}

echo '</div>';
echo '</div>';

echo '</article>';