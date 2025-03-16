<?php
/**
 * Render admin page for valid token
 *
 * @link       https://heyzine.com/
 * @since      1.0.0
 *
 * @package    Cl_Heyzine
 * @subpackage Cl_Heyzine/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flipbooks = $this->get_flipbook_list();
$email = $this->get_db_oauth_email();

?>

<div class="wrap cl-heyzine-options">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Heyzine', 'pdf-flipbook-heyzine' ); ?></h1>
	<a href="<?php echo esc_url( admin_url( 'admin.php?page=heyzine&hzaction=new' ) ); ?>" class="page-title-action"><?php esc_html_e( 'Add New Flipbook', 'pdf-flipbook-heyzine' ); ?></a>					
	<hr class="wp-header-end">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Flipbooks list', 'pdf-flipbook-heyzine' ); ?></h2>

	<div class="postbox-container meta-box-sortables">

		<div class="postbox heyzine-info-container">
			<div class="inside">
				<p><?php esc_html_e( 'You can now create a new Heyzine Flipbook and add it to your posts or pages.', 'pdf-flipbook-heyzine' ); ?></p>
				<p><?php esc_html_e( 'Select the flipbook, copy and paste the shortcode, or add a new Heyzine block in the Gutenberg editor.', 'pdf-flipbook-heyzine' ); ?></p>
			</div>
		</div>

		<?php if (!empty($flipbooks)): ?>
			<div class="heyzine-table-container">
				<table class="heyzine-table wp-list-table widefat striped table-view-list">
				<?php
					foreach ( $flipbooks as $heyzine ) {
						if ( empty( $heyzine['links']['custom'] ) ) {
							$heyzine_link = $heyzine['links']['base'];
						} else {
							$heyzine_link = $heyzine['links']['custom'];
						}
						$heyzine_id          = $heyzine['id'];
						$heyzine_title       = $heyzine['title'];
						$heyzine_sub_title   = $heyzine['subtitle'];
						$heyzine_description = $heyzine['description'];
						$heyzine_pages       = $heyzine['pages'];
						$heyzine_date        = $heyzine['date'];

						$date = new DateTime($heyzine_date); 
						$formattedDate = $date->format('F j, Y');
						

						$text = ! empty( $heyzine_title ) && ! empty( $heyzine_sub_title ) ? $heyzine_title . ' - ' . $heyzine_sub_title : (!empty( $heyzine_title ) ? $heyzine_title : $heyzine_sub_title);
						echo '<tr>';
						echo '<td><img width="55px" src="' . esc_url( $heyzine['links']['thumbnail'] ) . '" alt="' . esc_html__( 'Cover', 'pdf-flipbook-heyzine' ) . '" onerror="this.src=\'https://cdnc.heyzine.com/assets-admin/assets/img/core/broken.jpg\'" /></td>';
						echo '<td><p>' . esc_html( $text ) . '</p><p>' . esc_html( $formattedDate ) . '</p></td>';
						echo '<td><button class="button button-secondary btn-heyzine-customize" data-id="' . esc_html( $heyzine_id ) . '">' . esc_html__( 'Customize', 'pdf-flipbook-heyzine' ) . '</button></td>';
						echo '<td><button class="button button-secondary btn-heyzine-copy" data-link="' . esc_url( $heyzine_link ) . '">' . esc_html__( 'Copy link', 'pdf-flipbook-heyzine' ) . '</button></td>';
						echo '<td><button class="button button-secondary btn-heyzine-shortcode" data-id="' . esc_html( $heyzine_id ) . '">' . esc_html__( 'Shortcode', 'pdf-flipbook-heyzine' ) . '</button></td>';
						echo '</tr>';

					}
				?>
				</table>
			</div>
		

			<div class="postbox heyzine-toggle-container shortcode-generator closed">
				<div class="postbox-header">
					<h2><?php esc_html_e( 'Shortcode Generator', 'pdf-flipbook-heyzine' ); ?></h2>
					<div class="handle-actions hide-if-no-js">
						<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text"><?php esc_html_e( 'Toggle panel', 'pdf-flipbook-heyzine' ); ?></span><span class="toggle-indicator" aria-hidden="true"></span></button>
					</div>
				</div>			
				<div class="inside">

					<p><?php esc_html_e( 'Select your Heyzine title to view the shortcode to embed it.', 'pdf-flipbook-heyzine' ); ?></p>

					<select name="cl_heyzine_select" id="cl_heyzine_select">
						<option value="none"><?php esc_html_e( 'Select a Heyzine Flipbook', 'pdf-flipbook-heyzine' ); ?></option>
						<?php
						// Create array to store text values for sorting
						$sorted_flipbooks = array();
						foreach ($flipbooks as $heyzine) {
							if (empty($heyzine['links']['custom'])) {
								$heyzine_link = $heyzine['links']['base'];
							} else {
								$heyzine_link = $heyzine['links']['custom'];
							}
							
							$text = !empty($heyzine['title']) && !empty($heyzine['subtitle']) ? 
								$heyzine['title'] . ' - ' . $heyzine['subtitle'] : 
								(!empty($heyzine['title']) ? $heyzine['title'] : $heyzine['subtitle']);
							
							if (empty($text)) {
								$parsed = parse_url($heyzine_link);
								$text = isset($parsed['path']) ? ltrim($parsed['path'], '/') : '';
							}
							
							$sorted_flipbooks[] = array(
								'text' => $text,
								'heyzine' => $heyzine
							);
						}

						// Sort by text
						usort($sorted_flipbooks, function($a, $b) {
							return strcasecmp($a['text'], $b['text']);
						});

						// Output sorted options
						foreach ($sorted_flipbooks as $item) {
							$heyzine = $item['heyzine'];
							if (empty($heyzine['links']['custom'])) {
								$heyzine_link = $heyzine['links']['base'];
							} else {
								$heyzine_link = $heyzine['links']['custom'];
							}
							
							echo '<option value="' . esc_url($heyzine_link) . '" ' .
								'data-id="' . esc_html($heyzine['id']) . '" ' .
								'data-title="' . esc_html($heyzine['title']) . '" ' .
								'data-sub-title="' . esc_html($heyzine['subtitle']) . '" ' .
								'data-description="' . esc_html($heyzine['description']) . '" ' .
								'data-pages="' . absint($heyzine['pages']) . '">' .
								esc_html($item['text']) . '</option>';
						}
						?>
					</select>

					<label>
						<?php esc_html_e( 'Open on ', 'pdf-flipbook-heyzine' ); ?>
						<select name="cl_heyzine_select_page" id="cl_heyzine_select_page" disabled>
							<option value="0"><?php esc_html_e( 'Select page', 'pdf-flipbook-heyzine' ); ?></option>
						</select>					
					</label>

					<label class="toggle">
						<input class="toggle-checkbox" type="checkbox" name="responsive_width" id="responsive_width" checked>
						<div class="toggle-switch"></div>
						<span class="toggle-label"><?php esc_html_e( 'Responsive width', 'pdf-flipbook-heyzine' ); ?></span>
					</label>

					<label class="range">
						<input type="range" value="800" max="1200" min="150" step="10" name="flibook_width" id="flibook_width" disabled />
						<?php esc_html_e( 'Flipbook width', 'pdf-flipbook-heyzine' ); ?> <span class="range-value" id="flipbook_width_value">(800px)</span>
					</label>

					<label class="range">
						<input type="range" value="500" max="900" min="100" step="10" name="flibook_height" id="flibook_height" />
						<?php esc_html_e( 'Flipbook height', 'pdf-flipbook-heyzine' ); ?> <span class="range-value" id="flipbook_height_value">(500px)</span>
					</label>


					<div class="cl-heyzine-shortcode-container">
						<code class="cl-heyzine-shortcode" id="cl-heyzine-shortcode" title="<?php esc_html_e( 'Click to copy the shortcode to clipboard', 'pdf-flipbook-heyzine' ); ?>">
							[heyzine_flipbook]
						</code>
						<div class="cl-heyzine-copy-shortcode" id="cl-heyzine-copy-shortcode" title="<?php esc_html_e( 'Click to copy the shortcode to clipboard', 'pdf-flipbook-heyzine' ); ?>"></div>
					</div>

				</div>
			</div>
		<?php endif; ?>

		<div class="postbox heyzine-toggle-container closed">
			<div class="postbox-header">
				<h2><?php esc_html_e( 'Settings', 'pdf-flipbook-heyzine' ); ?></h2>
				<div class="handle-actions hide-if-no-js">
					<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text"><?php esc_html_e( 'Toggle panel', 'pdf-flipbook-heyzine' ); ?></span><span class="toggle-indicator" aria-hidden="true"></span></button>
				</div>
			</div>			
			<div class="inside">

				<?php if ($email): ?>
					<p><?php echo esc_html__( 'Connected with ', 'pdf-flipbook-heyzine' ) . '<strong>' . $email . '</strong>'; ?></p>
				<?php endif; ?>
				<details>
					<summary><span class="dashicons dashicons-database-remove"></span> <?php esc_html_e( 'Disconnect Heyzine Account', 'pdf-flipbook-heyzine' ); ?></summary>

					<p>
						<?php echo esc_html__( 'All the embedded flipbooks will keep working, but you will need to reconnect your Heyzine account to add new flipbooks.', 'pdf-flipbook-heyzine' ); ?>
						<br/>
						<br/>
						<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=heyzine&cl_action=cl_heyzine_delete_token' ), 'cl_heyzine_delete_token', 'heyzine_nonce' ) ); ?>" class="button button-secondary"><?php esc_html_e( 'Disconnect', 'pdf-flipbook-heyzine' ); ?></a>
					</p>
				</details>
			</div>
		</div>
	</div>
</div>
