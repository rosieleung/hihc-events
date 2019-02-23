<?php

get_header();
the_core_header_image();
$the_core_sidebar_position = function_exists( 'fw_ext_sidebars_get_current_position' ) ? fw_ext_sidebars_get_current_position() : 'right';
?>
	<section class="fw-main-row <?php the_core_get_content_class( 'main', $the_core_sidebar_position ); ?>" role="main" itemprop="mainEntity" itemscope="itemscope" itemtype="https://schema.org/Blog">
		<div class="fw-container">
			<div class="fw-row">
				<div class="fw-content-area <?php the_core_get_content_class( 'content', $the_core_sidebar_position ); ?>">
					<div class="fw-col-inner">
						
						<?php
						$status = get_hihc_event_status();
						if ( $status == 'ended' || $status == 'ended recurring' ) {
							$events_link = get_post_type_archive_link( 'hihc-event' );
						} else {
							$events_link = get_the_permalink( 850 );
						}
						?>
						
						<div class="hihc-breadcrumbs">
							<a href="<?php echo home_url(); ?>">Home</a> &raquo;
							<a href="<?php echo $events_link; ?>">Events</a> &raquo;
							<?php echo get_the_title(); ?>
						</div>
						<?php while( have_posts() ) : the_post();
							
							
							$the_core_post_options          = the_core_single_post_options( $post->ID );
							$the_core_related_articles_type = defined( 'FW' ) ? fw_get_db_settings_option( 'posts_settings/related_articles/yes/related_type', 'related-articles-1' ) : 'related-articles-1'; ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( "post post-details" ); ?> itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">
								<div class="fw-col-inner">
									<header class="entry-header">
										<?php the_core_single_post_title( $post->ID, 'post' ); ?>
									</header>
									
									<?php if ( $the_core_post_options['image'] && $the_core_post_options['featured_image'] != 'no' ) : ?>
										<div class="fw-post-image fw-block-image-parent <?php echo esc_attr( $the_core_post_options['frame'] ); ?>">
											<a href="<?php echo esc_url( $the_core_post_options['image']['original_image_url'] ); ?>" data-rel="prettyPhoto" class="post-thumbnail fw-block-image-child <?php echo esc_attr( $the_core_post_options['ratio_class'] ); ?>">
												<?php echo( $the_core_post_options['image']['img'] ); ?>
											</a>
											<?php if ( ! empty( $the_core_post_options['image']['caption'] ) ) : ?>
												<div class="fw-block-image-caption"><?php echo( $the_core_post_options['image']['caption'] ); ?></div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
									
									<div class="entry-content clearfix" itemprop="text">
										<?php
										the_content();
										
										$registration = get_field( "registration" );
										$form         = $registration['form_type'];
										if ( $form != 'none' ) {
											
											// display form if event is upcoming and allows registration
											$status = get_hihc_event_status( $post->ID );
											if ( $status == 'upcoming' || $status == 'upcoming recurring' ) {
												if ( $form == 'adult' ) {
													// form with just the basic fields
													$gform = 5;
												} else {
													// form with fields for kids
													$gform = 4;
												}
												
												$price = (float) $registration["price"];
												if ( $price ) {
													
													$title = esc_attr( get_the_title() );
													if ( $date = get_field( "date" ) ) {
														$datetime = strtotime( $date );
														$day      = date( 'n/j/Y', $datetime );
														$title    = $day . ' ' . $title;
													}
													
													echo '<div class="event">';
													echo do_shortcode( '[gravityform id="' . $gform . '" title="false" description="false" field_values="price=' . $price . '&event=' . $title . '"]' );
													echo '</div>';
												}
											} else {
												echo '<p><em>Registration has closed.</em></p>';
											}
										}
										
										?>
									</div>
								
								</div>
							</article>
							
							
							<?php
							break;
						endwhile; ?>
					</div><!-- /.inner -->
				</div><!-- /.content-area -->
				
				<?php get_sidebar(); ?>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</section>
<?php get_footer(); ?>