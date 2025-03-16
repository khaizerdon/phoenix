<?php
/**
 * Render admin page for creating a new flipbook
 *
 * @link       https://heyzine.com/
 * @since      1.2.0
 *
 * @package    Cl_Heyzine
 * @subpackage Cl_Heyzine/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! empty( $_POST ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['heyzine_new_nonce'] ) ), 'cl_heyzine_upload_file' ) ) {
    
    $state = null;
    $errorMessage = '';

	$resCreate = $this->set_new_flipbook();


	if ( is_wp_error( $resCreate ) ) {
        $errorMessage = $resCreate->get_error_message();
        $state = 'error';
	}
    
    if (isset($resCreate['state']) && $resCreate['state'] === 'error') {
        $errorMessage = $resCreate['message'];
        $state = 'error';
    } else if (isset($resCreate['state']) && $resCreate['state'] === 'started') {
        $state = 'started';
    } else if (isset($resCreate['state']) && $resCreate['state'] === 'processed') {
        $state = 'processed';
    }

}
?>

<div class="wrap cl-heyzine-options">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Heyzine', 'pdf-flipbook-heyzine' ); ?></h1>

	<hr class="wp-header-end">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Add New Flipbook', 'pdf-flipbook-heyzine' ); ?></h2>

	<?php if ($state != null): ?>
        <?php if ($state === 'started'): ?>
            <script>

                document.addEventListener( 'DOMContentLoaded', () => {
                    document.querySelector('.heyzine-conversion-process-progress').style.display = 'block';
                    document.querySelector('.heyzine-conversion-process-stop').style.display = 'none';


                    tmrHeyzineCheck = setInterval(async function() {
                        const data = await HeyzineApp.checkConversionState('<?php echo $resCreate['id']; ?>');
                        if (data.state === 'processed') {
                            clearInterval(tmrHeyzineCheck);
                            document.querySelector('.heyzine-conversion-process-progress').style.display = 'none';
                            document.querySelector('.heyzine-conversion-process-stop').style.display = 'none';                        
                            document.querySelector('.heyzine-conversion-process-preview').style.display = 'block';
                            document.querySelector('.heyzine-conversion-process-preview iframe').src = data.msg;
                            document.querySelector('.btn-heyzine-customize').setAttribute('data-id', data.id);
                            document.querySelector('.btn-heyzine-copy').setAttribute('data-link', data.msg);
                            document.querySelector('.btn-heyzine-copy-shortcode').setAttribute('data-link', data.msg);                            
                        } else if (data.state === 'error') {
                            clearInterval(tmrHeyzineCheck);
                            document.querySelector('.heyzine-conversion-process-progress').style.display = 'none';
                            document.querySelector('.heyzine-conversion-process-stop').style.display = 'block';                        
                            document.querySelector('.heyzine-conversion-process-preview').style.display = 'none';
                            document.querySelector('.notice-error p').innerText = data.msg;
                        }
                    }, 4000);
                });

            </script>
        <?php elseif ($state === 'processed'): ?>
            <script>
                document.addEventListener( 'DOMContentLoaded', () => {
                    document.querySelector('.heyzine-conversion-process-progress').style.display = 'none';
                    document.querySelector('.heyzine-conversion-process-stop').style.display = 'none';                        
                    document.querySelector('.heyzine-conversion-process-preview').style.display = 'block';
                    document.querySelector('.heyzine-conversion-process-preview iframe').src = '<?php echo esc_js($resCreate['url']); ?>';
                    document.querySelector('.btn-heyzine-customize').setAttribute('data-id', '<?php echo esc_js($resCreate['id']); ?>');
                    document.querySelector('.btn-heyzine-copy').setAttribute('data-link', '<?php echo esc_js($resCreate['url']); ?>');
                    document.querySelector('.btn-heyzine-copy-shortcode').setAttribute('data-link', '<?php echo esc_js($resCreate['url']); ?>');
                    
                    
                });
            </script>
        <?php endif; ?>
    <?php endif; ?>


    <div class="notice notice-error notice-alt is-dismissible" style="<?php echo !empty($errorMessage) ? 'display: block;' : 'display: none;'; ?>">
        <h2><?php esc_html_e( 'Error creating the flipbook', 'pdf-flipbook-heyzine' ); ?></h2>
        <p><?php echo wp_kses_post( $errorMessage ); ?></p>
    </div>            
        

	<div class="postbox-container meta-box-sortables heyzine-info-container">

		<div class="postbox heyzine-postbox">

            <div class="postbox-header">
                <h2><?php esc_html_e( 'Create a new Heyzine Flipbook', 'pdf-flipbook-heyzine' ); ?></h2>
            </div>                


            <div class="inside heyzine-conversion-process-preview">
                <div class="heyzine-preview-container">
                    <div class="heyzine-preview-data">
                        <p>
                            <label for="heyzine-preview-title"><?php esc_html_e( 'Title', 'pdf-flipbook-heyzine' ); ?>:</label>
                            <input id="heyzine-preview-title" type="text" name="title" />
                        </p>
                        <p>
                            <label for="heyzine-preview-subtitle"><?php esc_html_e( 'Subtitle', 'pdf-flipbook-heyzine' ); ?>:</label>
                            <input id="heyzine-preview-subtitle" type="text" name="subtitle" />
                        </p>
                        <p>
                            <label for="heyzine-preview-effect"><?php esc_html_e( 'Page type', 'pdf-flipbook-heyzine' ); ?>:</label>
                            <select id="heyzine-preview-effect" name="heyzine-preview-pagetype">
                                <option value="magazine"><?php esc_html_e( 'Magazine', 'pdf-flipbook-heyzine' ); ?></option>
                                <option value="slideshow"><?php esc_html_e( 'Slider', 'pdf-flipbook-heyzine' ); ?></option>
                                <option value="cards"><?php esc_html_e( 'Cards', 'pdf-flipbook-heyzine' ); ?></option>
                                <option value="onepage"><?php esc_html_e( 'One page', 'pdf-flipbook-heyzine' ); ?></option>
                            </select>
                        </p>
                        <div class="heyzine-preview-data-buttons">
                            <p>
                                <button class="button button-secondary btn-heyzine-save-settings"><?php esc_html_e( 'Save', 'pdf-flipbook-heyzine' ); ?></button>
                                <button class="button button-secondary btn-heyzine-customize"><?php esc_html_e( 'Customize', 'pdf-flipbook-heyzine' ); ?></button>
                            </p>
                            <p>
                                <button class="button button-secondary btn-heyzine-copy"><?php esc_html_e( 'Copy Link', 'pdf-flipbook-heyzine' ); ?></button>
                                <button class="button button-secondary btn-heyzine-copy-shortcode"><?php esc_html_e( 'Copy Shortcode', 'pdf-flipbook-heyzine' ); ?></button>
                            </p>
                        </div>
                    </div>
                    <div class="heyzine-preview-iframe">                
                        <iframe src="" width="580px" height="400px" allowfullscreen="allowfullscreen"></iframe>
                    </div>
                </div>
            </div>

            <div class="inside heyzine-conversion-process-progress">
                <div class="heyzine-conversion-process-progress-content">
                    <span class="dashicons dashicons-update heyzine-conversion-process"></span>
                </div>
            </div>

			<div class="inside heyzine-conversion-process-stop">

				<p><?php esc_html_e( 'Select or upload a document (pdf, docx, pptx) to create a new flipbook.', 'pdf-flipbook-heyzine' ); ?></p>

				<form name="cl-new-heyzine" method="post">
					<?php wp_nonce_field( 'cl_heyzine_upload_file', 'heyzine_new_nonce' ); ?>

					<input type="hidden" name="cl-heyzine-url" value="" id="cl-upload-heyzine-url" />

                    <div>
						<button class="button button-secondary button-hero" id="cl-upload-heyzine-btn"><?php esc_html_e( 'Select file', 'pdf-flipbook-heyzine' ); ?></button>
                        <span class="heyzine-file-selected"></span>
					</div>
					<button class="button button-primary button-hero cl-btn-new-heyzine" id="cl-create-heyzine-btn" type="submit" disabled><?php esc_html_e( 'Create flipbook', 'pdf-flipbook-heyzine' ); ?></button>
				</form>
			</div>
		</div>
	</div>
</div>
