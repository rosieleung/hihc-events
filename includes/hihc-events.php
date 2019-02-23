<?php



function hihc_event_archive_shows_only_past_events( $query ) {
	if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'hihc-event' ) ) {
		$yesterday = intval(current_time( 'Ymd' )) - 1;
		$query->set(
			'meta_query', array(
			array(
				'key'     => 'date',
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC',
				'value'   => array( 1, $yesterday ),
			),
		) );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );
	}
}

add_filter( 'pre_get_posts', 'hihc_event_archive_shows_only_past_events' );


add_action( 'init', 'hihc_events_register', 0 );

function hihc_events_register() {
	
	$labels = array(
		'name'                  => 'Events',
		'singular_name'         => 'Event',
		'menu_name'             => 'Events',
		'name_admin_bar'        => 'Events',
		'archives'              => 'Event Archives',
		'attributes'            => 'Event Attributes',
		'parent_item_colon'     => 'Parent Event:',
		'all_items'             => 'All Events',
		'add_new_item'          => 'Add New Event',
		'add_new'               => 'Add New',
		'new_item'              => 'New Event',
		'edit_item'             => 'Edit Event',
		'update_item'           => 'Update Event',
		'view_item'             => 'View Event',
		'view_items'            => 'View Events',
		'search_items'          => 'Search Event',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into event',
		'uploaded_to_this_item' => 'Uploaded to this event',
		'items_list'            => 'Events list',
		'items_list_navigation' => 'Events list navigation',
		'filter_items_list'     => 'Filter events list',
	);
	$args   = array(
		'label'               => 'Event',
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-calendar',
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => 'events-archive',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'rewrite'             => array(
			'slug'       => 'events',
			'with_front' => false,
		),
	);
	register_post_type( 'hihc-event', $args );
	
}