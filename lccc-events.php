<?php
/*
Plugin Name: Custom Events List
Description: Display the next three events from The Events Calendar.
Version: 1.0
Author: Stu Lowe
*/

function display_lccc_next_events( $atts ) {
    // Shortcode default attributes
    $atts = shortcode_atts( array(
        'events' => 3,
    ), $atts, 'lccc_next_events' );

    $events = tribe_get_events( array(
        'posts_per_page' => intval( $atts['events'] ),
        'start_date'     => current_time( 'Y-m-d H:i:s' ),
    ) );

    if ( empty( $events ) ) {
        return '<p class="elementor-event-no-events">No upcoming events.</p>';
    }

    ob_start(); ?>
    
    <section class="elementor-event-list">
        <?php foreach ( $events as $event ) : ?>
            <article class="elementor-event">
                <header class="elementor-event-header">
                    <h3 class="elementor-event-title"><?php echo esc_html( $event->post_title ); ?></h3>
                    <p class="elementor-event-date"><?php echo esc_html( tribe_get_start_date( $event, false, 'F j, Y' ) ); ?></p>
                </header>
                <div class="elementor-event-content">
                    <p class="elementor-event-description"><?php echo esc_html( wp_trim_words( $event->post_content, 15 ) ); ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </section>

    <?php return ob_get_clean();
}

add_shortcode('lccc_next_events', 'display_lccc_next_events');
