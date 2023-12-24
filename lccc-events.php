<?php
/*
Plugin Name: Custom Events List
Description: Display the next three events from The Events Calendar.
Version: 1.0
Author: Stu Lowe
*/


function display_lccc_next_events( $atts ) {
    // Set up default parameters
    $atts = shortcode_atts( array(
        'events' => 3, // Default number of events if none provided
    ), $atts, 'lccc_next_events' );

    // Fetch the specified number of events
    $events = tribe_get_events( array(
        'posts_per_page' => intval( $atts['events'] ), // Use the 'events' attribute value
        'start_date'     => current_time( 'Y-m-d H:i:s' ),
    ) );

    if ( empty( $events ) ) {
        return 'No upcoming events.';
    }

    ob_start(); ?>

    <div class="custom-events-list">
        <?php foreach ( $events as $event ) : ?>
            <div class="event">
                <h3 class="event-title"><?php echo esc_html( $event->post_title ); ?></h3>
                <p class="event-date"><?php echo esc_html( tribe_get_start_date( $event, false, 'F j, Y' ) ); ?></p>
                <p class="event-description"><?php echo esc_html( wp_trim_words( $event->post_content, 15 ) ); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <?php return ob_get_clean();
}

add_shortcode('lccc_next_events', 'display_lccc_next_events');
