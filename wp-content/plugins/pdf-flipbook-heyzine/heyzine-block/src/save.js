/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
export default function save( { attributes } ) {
	const {
		heyzineSelected,
		heyzineLinkPage,
		showBorder,
		showFold,
		responsiveWidth,
		flibookWidth,
		flibookHeight
	} = attributes;

	return (
		<div { ...useBlockProps.save() }>
			{ heyzineSelected && (
				<>
					<script
						dangerouslySetInnerHTML={{
							__html: `
								if (!document.querySelector('script[src="https://cdnc.heyzine.com/release/addons.3.min.js"]')) {
									const script = document.createElement('script');
									script.src = 'https://cdnc.heyzine.com/release/addons.3.min.js';
									document.head.appendChild(script);
								}
							`
						}}
					/>
					<div className="cl-heyzine-embed">
						<iframe className="cl-heyzine-iframe fp-iframe"
							allow="fullscreen"
							allowfullscreen="allowfullscreen"
							style= {{
								border: showBorder ? "1px solid lightgray" : "0px",
								width: responsiveWidth ? (
									"100%"
									) : (
										flibookWidth + "px"
									),
								height: flibookHeight + "px"
							}}
							src= { heyzineLinkPage }
						>
						</iframe>
					</div>
				</>
			) }
		</div>
	);
}
