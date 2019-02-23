<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hihc_events_enqueue_scripts() {
	wp_enqueue_style( 'hihc-events', HIHC_EVENTS_URL . '/assets/hihc-events.css', array(), '1.0.1' );
}

add_action( 'wp_enqueue_scripts', 'hihc_events_enqueue_scripts', 9999 );
