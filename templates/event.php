<?php
/**
 * Template for event page.
 */

namespace Wporg\TranslationEvents;

use WP_Post;

/** @var WP_Post $event */
/** @var int $event_id */
/** @var string $event_title */
/** @var string $event_description */
/** @var string $event_start */
/** @var string $event_end */
/** @var bool $user_is_attending */
/** @var Event_Stats $event_stats */

/* translators: %s: Event title. */
gp_title( sprintf( __( 'Translation Events - %s' ), esc_html( $event_title ) ) );
gp_breadcrumb_translation_events( array( esc_html( $event_title ) ) );
gp_tmpl_header();
gp_tmpl_load( 'events-header', get_defined_vars(), __DIR__ );
?>

<div class="event-page-wrapper">
	<div class="event-details-head">
		<h1>
			<?php echo esc_html( $event_title ); ?>
			<?php if ( 'draft' === $event->post_status ) : ?>
				<span class="event-label-draft"><?php echo esc_html( $event->post_status ); ?></span>
			<?php endif; ?>
		</h1>
		<p>
			Host: <a href="<?php echo esc_attr( get_author_posts_url( $event->post_author ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $event->post_author ) ); ?></a>
			<?php if ( current_user_can( 'edit_post', $event_id ) ) : ?>
				<a class="event-page-edit-link button" href="<?php echo esc_url( gp_url( 'events/edit/' . $event_id ) ); ?>"><span class="dashicons dashicons-edit"></span>Edit event</a>
			<?php endif ?>
		</p>
	</div>
	<div class="event-details-left">
		<div class="event-page-content">
			<?php
				echo wp_kses_post( wpautop( make_clickable( $event_description ) ) );
			?>
		</div>
		<?php if ( ! empty( $event_stats->rows() ) ) : ?>
	<div class="event-details-stats">
		<h2>Stats</h2>
		<table>
			<thead>
			<tr>
				<th scope="col">Locale</th>
				<th scope="col">Translations created</th>
				<th scope="col">Translations reviewed</th>
				<th scope="col">Contributors</th>
			</tr>
			</thead>
			<tbody>
			<?php /** @var $row Stats_Row */ ?>
			<?php foreach ( $event_stats->rows() as $locale_ => $row ) : ?>
			<tr>
				<td><?php echo esc_html( $locale_ ); ?></td>
				<td><?php echo esc_html( $row->created ); ?></td>
				<td><?php echo esc_html( $row->reviewed ); ?></td>
				<td><?php echo esc_html( $row->users ); ?></td>
			</tr>
		<?php endforeach ?>
			<tr class="event-details-stats-totals">
				<td>Total</td>
				<td><?php echo esc_html( $event_stats->totals()->created ); ?></td>
				<td><?php echo esc_html( $event_stats->totals()->reviewed ); ?></td>
				<td><?php echo esc_html( $event_stats->totals()->users ); ?></td>
			</tr>
			</tbody>
		</table>
	</div>
	<details class="event-stats-summary">
		<summary>View stats summary in text </summary>
		<p class="event-stats-text"><?php echo esc_html( sprintf( 'At the %s event, %d people contributed in %d languages (%s), translated %d strings and reviewed %d strings.', esc_html( $event_title ), esc_html( $event_stats->totals()->users ), count( $event_stats->rows() ), esc_html( implode( ',', array_keys( $event_stats->rows() ) ) ), esc_html( $event_stats->totals()->created ), esc_html( $event_stats->totals()->reviewed ) ) ); ?></p>
	</details>
	<?php endif ?>
	</div>
	<div class="event-details-right">
		<div class="event-details-date">
			<p>
				<span class="event-details-date-label">Starts:</span> <time class="event-utc-time" datetime="<?php echo esc_attr( $event_start ); ?>"></time>
				<span class="event-details-date-label">Ends:</span><time class="event-utc-time" datetime="<?php echo esc_attr( $event_end ); ?>"></time>
			</p>
		</div>
		<?php if ( is_user_logged_in() ) : ?>
		<div class="event-details-join">
			<?php
			$current_time = gmdate( 'Y-m-d H:i:s' );
			if ( strtotime( $current_time ) > strtotime( $event_end ) ) :
				?>
				<?php if ( $user_is_attending ) : ?>
					<span class="event-details-join-expired"><?php esc_html_e( 'You attended', 'gp-translation-events' ); ?></span>
				<?php endif ?>
			<?php else : ?>
				<form class="event-details-attend" method="post" action="<?php echo esc_url( gp_url( "/events/attend/$event_id" ) ); ?>">
					<?php if ( ! $user_is_attending ) : ?>
						<input type="submit" class="button is-primary attend-btn" value="Attend Event"/>
					<?php else : ?>
						<input type="submit" class="button is-secondary attending-btn" value="You're attending"/>
					<?php endif ?>
				</form>
			<?php endif ?>
		</div>
		<?php else : ?>
		<div class="event-details-join">
			<p>
				<?php global $wp; ?>
				<a href="<?php echo esc_url( wp_login_url( home_url( $wp->request ) ) ); ?>" class="button is-primary attend-btn"><?php esc_html_e( 'Login to attend', 'gp-translation-events' ); ?></a>
			</p>
		</div>
		<?php endif; ?>
	</div>
</div>
<div class="clear"></div>
<?php gp_tmpl_footer(); ?>
