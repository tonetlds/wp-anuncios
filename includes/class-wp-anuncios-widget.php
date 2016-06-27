<?php
	/**
	 * Adds Anuncio_Widget widget.
	 */
	class Anuncio_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'Anuncio_Widget', // Base ID
				__('Anúncio', 'wp-anuncios'), // Name
				array('description' => __( '', 'wp-anuncios' ),) // Args
			);
		}
		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			
			// get the excerpt of the required story
			if ( $instance['post_id'] == 0 ) {
			
				$gp_args = array(
					'posts_per_page' => 1,
					'post_type' => 'advertising',
					'orderby' => 'post_date',
					'order' => 'desc',
					'post_status' => 'publish'
				);
				$posts = get_posts( $gp_args );
				
				if ( $posts ) {
					$post = $post[0];
				} else {
					$post = null;
				}
			
			} else {
			
				$post = get_post( $instance['post_id'] );	
			
			}
					
			if ( array_key_exists('before_widget', $args) ) echo $args['before_widget'];
			
			if ( $post ) { 

				$anuncio['url'] = get_post_meta( $post->ID, 'anuncio_url', true );
				$anuncio['views'] = get_post_meta( $post->ID, 'anuncio_views', true );
				$anuncio['sessions'] = get_post_meta( $post->ID, 'anuncio_sessions', true );
				
				$anuncio['image_desktop'] = get_post_meta( $post->ID, 'anuncio_image_desktop', true );
				$anuncio['image_tablet'] = get_post_meta( $post->ID, 'anuncio_image_tablet', true );
				$anuncio['image_mobile'] = get_post_meta( $post->ID, 'anuncio_image_mobile', true );


					?>

						<a href="<?php echo $anuncio['url'] ?>" class="wp-anuncio visible-lg visible-md" target="_new" data-id="<?php echo $post->ID ?>">						
							<?php echo wp_get_attachment_image($anuncio['image_desktop'], 'original', false, ["class" => "img-responsive", "target" => "_blank"] ); ?>
						</a>

						<a href="<?php echo $anuncio['url'] ?>" class="wp-anuncio visible-sm hidden-xs" target="_new" data-id="<?php echo $post->ID ?>">												
							<?php echo wp_get_attachment_image($anuncio['image_tablet'], 'original', false, ["class" => "img-responsive", "target" => "_blank"] ); ?>
						</a>

						<a href="<?php echo $anuncio['url'] ?>" class="wp-anuncio hidden-sm visible-xs text-center" target="_new" data-id="<?php echo $post->ID ?>">							
							<?php echo wp_get_attachment_image($anuncio['image_mobile'], 'original', false, ["class" => "img-responsive", "target" => "_blank"] ); ?>
						</a>						
					
			
				<?php					

				// SET ANUNCIO VIEWS
				$ad = new Wp_Anuncios();
				$ad->setAnuncioViews( $post->ID );
				$ad->setAnuncioSessions( $post->ID );
				
				if( WP_DEBUG ){
					echo '<i class="fa fa-eye"></i> ' . $ad->getAnuncioViews( $post->ID ) . ' | <i class="fa fa-user"></i> ' . $ad->getAnuncioSessions( $post->ID ) . ' | <i class="fa fa-mouse-pointer" aria-hidden="true"></i> ' . $ad->getAnuncioClicks( $post->ID );					
				}

			} else {
			
				echo __( 'No advertising found.', 'wp-anuncios' );
			}
				
			if ( array_key_exists('after_widget', $args) ) echo $args['after_widget'];
		}
		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			
			if ( isset( $instance[ 'post_id' ] ) ) {
				$post_id = $instance[ 'post_id' ];
			}
			else {
				$post_id = 0;
			}
			?>
			
			<p>
				Anúncio à exibir:
			</p>
			<p>
				<select id="<?php echo $this->get_field_id( 'post_id' ); ?>" name="<?php echo $this->get_field_name( 'post_id' ); ?>">
					<option>-- Selecione um anúncio --</option> 
					<?php 
					// get the exceprt of the most recent story
					$gp_args = array(
						'posts_per_page' => -1,
						'post_type' => 'advertising',
						'orderby' => 'post_date',
						'order' => 'desc',
						'post_status' => 'publish'
					);
					
					$posts = get_posts( $gp_args );
						foreach( $posts as $post ) {
						
							$selected = ( $post->ID == $post_id ) ? 'selected' : ''; 
							
							if ( strlen($post->post_title) > 30 ) {
								$title = substr($post->post_title, 0, 27) . '...';
							} else {
								$title = $post->post_title;
							}
							echo '<option value="' . $post->ID . '" ' . $selected . '>' . $title . '</option>';
						}
					?>
				</select>
			</p>
			<?php 
		}
		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			
			$instance = array();
			$instance['post_id'] = ( ! empty( $new_instance['post_id'] ) ) ? strip_tags( $new_instance['post_id'] ) : '';
			return $instance;
		}
	} // class Anuncio_Widget