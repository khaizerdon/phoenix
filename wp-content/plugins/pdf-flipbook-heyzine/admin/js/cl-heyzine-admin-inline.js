document.addEventListener( 'DOMContentLoaded', () => {
	let button = document.getElementById( 'cl-upload-heyzine-btn' );

	let heyzine_link = '';
	let responsive_width = true
	let flipbook_width = 800;
	let flipbook_height = 500;
	let flipbook_page = 0;

	if ( button ) {
		button.addEventListener( 'click', ( e ) => {
			let media_uploader;

			e.preventDefault();

			// If the media frame already exists, reopen it.
			if ( media_uploader ) {
				media_uploader.open();
				return;
			}

			media_uploader = wp.media.frames.media_uploader = wp.media( {
				title: CL_HEYZINE.title,
				button: {
					text: CL_HEYZINE.button,
				},
				multiple: false,
				library: {
					type: [
						'application/pdf',
						'application/msword',
						'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
						'application/vnd.openxmlformats-officedocument.presentationml.presentation',
						'application/vnd.ms-powerpoint',
						'application/vnd.oasis.opendocument.text',
						'application/vnd.oasis.opendocument.presentation',
						'application/rtf',
					]
				}
			} );

			media_uploader.on( 'select', () => {
				let attachment         = media_uploader.state().get( 'selection' ).first().toJSON();
				
				document.querySelector( '.heyzine-file-selected' ).textContent = attachment.filename;

				let url                = attachment.url;
				let heyzine_url        = document.getElementById( 'cl-upload-heyzine-url' );
				let btn_create_heyzine = document.getElementById( 'cl-create-heyzine-btn' );

				if ( heyzine_url ) {
					heyzine_url.value = url;
					btn_create_heyzine.disabled = false;
				}

			} );

			media_uploader.open();
		} );
	}

	const set_options_page_select = ( n_pages ) => {
		let select = document.getElementById( 'cl_heyzine_select_page' );

		select.innerHTML = '';

		if ( 0 === n_pages ) {
			select.disabled = true;
			return;
		}

		for ( let i = 1; i <= n_pages; i++ ) {
			let option = document.createElement( 'option' );
			option.value = i;
			option.text = CL_HEYZINE.page + ' ' + i;
			select.add( option );
		}

		select.disabled = false;
	}

	const generate_shortcode = (url) => {
		let shortcode = '[heyzine_flipbook';

		if (! heyzine_link && url) {
			heyzine_link = url;
		}

		if ( responsive_width ) {
			shortcode += ' responsive_width="true"';
		} else if (flipbook_width) {
			shortcode += ' flipbook_width="' + flipbook_width + '"';
		} else {
			shortcode += ' responsive_width="true"';
		}

		if ( flipbook_height ) {
			shortcode += ' flipbook_height="' + flipbook_height + '"';
		}

		if ( heyzine_link ) {
			shortcode += ' heyzine_link="' + heyzine_link + '"';
		} 

		if ( flipbook_page ) {
			shortcode += ' heyzine_page="' + flipbook_page + '"';
		}

		shortcode += ']';

		if ( ! heyzine_link ) {
			shortcode = '[heyzine_flipbook]';
		}
		
		return shortcode;
	};


	const update_shortcode = (url) => {
		const shortcode = generate_shortcode(url);
		document.getElementById( 'cl-heyzine-shortcode' ).innerText = shortcode;
	}

	const responsive_width_control = document.getElementById( 'responsive_width' );
	if (responsive_width_control) {
		responsive_width_control.addEventListener( 'change', ( e ) => {
			if ( e.target.checked ) {
				responsive_width = true;
				document.getElementById( 'flipbook_width' ).disabled = true;
			} else {
				responsive_width = false;
				document.getElementById( 'flipbook_width' ).disabled = false;
			}
			update_shortcode();
		} );
	}

	const flipbook_width_control = document.getElementById( 'flipbook_width' );
	if ( flipbook_width_control ) {
		flipbook_width_control.addEventListener( 'change', ( e ) => {
			flipbook_width = e.target.value;
			document.getElementById( 'flipbook_width_value' ).textContent = '(' + e.target.value + 'px)';
			update_shortcode();
		} );
	}

	const flipbook_height_control = document.getElementById( 'flipbook_height' );
	if ( flipbook_height_control ) {
		flipbook_height_control.addEventListener( 'change', ( e ) => {
			flipbook_height = e.target.value;
			document.getElementById( 'flipbook_height_value' ).textContent = '(' + e.target.value + 'px)';
			update_shortcode();
		} );
	}


	const heyzine_select_control = document.getElementById( 'cl_heyzine_select' );
	if ( heyzine_select_control ) {
		heyzine_select_control.addEventListener( 'change', ( e ) => {
			const selectedOption = e.target.selectedOptions[0];

			heyzine_link = e.target.value;

			if ( 'none' === heyzine_link ) {
				heyzine_link = '';
				n_pages      = 0;
			} else {
				id           = selectedOption.getAttribute( 'data-id' );
				n_pages      = selectedOption.getAttribute( 'data-pages' );
			}
			set_options_page_select( n_pages );

			update_shortcode();
		} );
	}

	
	const heyzine_select_page_control = document.getElementById( 'cl_heyzine_select_page' );
	if ( heyzine_select_page_control ) {
		heyzine_select_page_control.addEventListener( 'change', ( e ) => {
			flipbook_page = e.target.value;

			update_shortcode();
		} );
	}


	const shortcode_control = document.getElementById( 'cl-heyzine-shortcode' );
	if ( shortcode_control ) {
		shortcode_control.addEventListener( 'click', ( e ) => {
			const codeText = e.target.innerText;

			navigator.clipboard.writeText( codeText )
				.then( () => {
					console.log('Copied to clipboard');
				} )
				.catch( ( error ) => {
					console.error( error );
				} );
		} );
	}

	const copy_shortcode_control = document.getElementById( 'cl-heyzine-copy-shortcode' );
	if ( copy_shortcode_control ) {
		copy_shortcode_control.addEventListener( 'click', ( e ) => {

			const codeText = e.target.parentElement.querySelector( '.cl-heyzine-shortcode' ).innerText;

			navigator.clipboard.writeText( codeText )
				.then( () => {
					console.log('Copied to clipboard');
				} )
				.catch( ( error ) => {
					console.error( error );
				} );
		} );	
	}

	
	document.querySelectorAll( '.btn-heyzine-shortcode' ).forEach( ( el ) => {
		el.addEventListener( 'click', ( e ) => {
			const id = e.target.getAttribute('data-id');
			const select = document.getElementById('cl_heyzine_select');
			const options = select.options;

			for (let i = 0; i < options.length; i++) {
				if (options[i].getAttribute('data-id') === id) {
					select.selectedIndex = i;
					break;
				}
			}

			// Trigger change event
			const changeEvent = new Event('change');
			select.dispatchEvent(changeEvent);

			// Open shortcode generator section
			const gencont = document.querySelector('.heyzine-toggle-container.shortcode-generator');
			if (gencont && gencont.classList.contains('closed')) {
				gencont.classList.remove('closed');
			}

			// Get and copy shortcode
			const shortcode = document.getElementById('cl-heyzine-shortcode');
			navigator.clipboard.writeText(shortcode.innerText)
				.then(() => {
					console.log('Copied to clipboard');
				})
				.catch((error) => {
					console.error(error);
				});
		} );
	} );

	document.querySelectorAll( '.btn-heyzine-copy-shortcode' ).forEach( ( el ) => {
		el.addEventListener( 'click', ( e ) => {
			const link = e.target.getAttribute('data-link');
			const shortcode = generate_shortcode(link);
			navigator.clipboard.writeText(shortcode)
			.then(() => {
				console.log('Copied to clipboard');
			})
			.catch((error) => {
				console.error(error);
			});
		} );
	} );

	document.querySelectorAll( '.btn-heyzine-copy' ).forEach( ( el ) => {
		el.addEventListener( 'click', ( e ) => {

			const link = e.target.getAttribute( 'data-link' );

			navigator.clipboard.writeText( link )
			.then( () => {
				console.log('Copied to clipboard');
			} )
			.catch( ( error ) => {
				console.error( error );
			} );
		} );
	} );

	document.querySelectorAll( '.btn-heyzine-customize' ).forEach( ( el ) => {
		el.addEventListener( 'click', ( e ) => {
			const heyzine_id = e.target.getAttribute( 'data-id' );
			window.open( 'https://heyzine.com/admin/view?n=' + heyzine_id, '_BLANK' );
		} );
	} );

	document.querySelectorAll( '.heyzine-toggle-container .postbox-header' ).forEach( ( el ) => {
		el.addEventListener( 'click', ( e ) => {
			e.target.parentElement.classList.toggle('closed');
		} );
	} );

	document.querySelectorAll( '.heyzine-toggle-container .toggle-indicator' ).forEach( ( el ) => {
		el.addEventListener( 'click', ( e ) => {
			e.target.parentElement.parentElement.parentElement.parentElement.classList.toggle('closed');
			e.stopPropagation();
		} );
	} );	

	document.querySelectorAll( '.btn-heyzine-save-settings' ).forEach( ( el ) => {
		el.addEventListener( 'click', async ( e ) => {
			const name = document.querySelector( '.btn-heyzine-customize' ).getAttribute( 'data-id' );
			const title = document.getElementById( 'heyzine-preview-title' ).value;
			const subtitle = document.getElementById( 'heyzine-preview-subtitle' ).value;
			const effect = document.getElementById( 'heyzine-preview-effect' ).value;

			const res = await HeyzineApp.saveBasicSettings(name, title, subtitle, effect);
			if (res.success) {
				const iframe = document.querySelector('.heyzine-conversion-process-preview iframe');
				const currentSrc = iframe.src;
				const url = new URL(currentSrc);
				url.searchParams.delete('refresh');
				url.searchParams.append('refresh', Date.now());
				iframe.src = url.toString();
			}
			
		} );
	} );

} );

const HeyzineApp = {
	checkConversionState: async function(name) {
		try {
			const response = await fetch(CL_HEYZINE.api_url + '/flipbook-state/' + name, {
				method: 'GET',
				headers: {
					'Content-Type': 'application/json', 
					'X-WP-Nonce': CL_HEYZINE.nonce,
				}			
			});
			return response.json();
		} catch (error) {
			console.error('Error checking conversion state:', error);
		}
	},
	saveBasicSettings: async function(name, title, subtitle, effect) {
		try {
			const response = await fetch(CL_HEYZINE.api_url + '/flipbook-settings/' + name, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'X-WP-Nonce': CL_HEYZINE.nonce,
				},
				body: `title=${encodeURIComponent(title)}&subtitle=${encodeURIComponent(subtitle)}&effect=${encodeURIComponent(effect)}`
			});
			return response.json();
		} catch (error) {
			console.error('Error saving basic settings:', error);
		}		
	}
};