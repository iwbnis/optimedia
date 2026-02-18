( function( $ ) {

	var blockEditorDefaults = {

		postWP54: function() {

			if ( null === wpUserData ) {

				blockEditorDefaults.toggleEditorFeature( 'fixedToolbar' );

			}

			if ( null !== wpUserData ) {

				if ( 'core/edit-post' in wpUserData && 'preferences' in wpUserData['core/edit-post'] && 'features' in wpUserData['core/edit-post'].preferences ) {

					if ( ! ( 'fixedToolbar' in wpUserData['core/edit-post'].preferences.features ) ) {

						blockEditorDefaults.toggleEditorFeature( 'fixedToolbar' );

					}

				} else {

					blockEditorDefaults.toggleEditorFeature( 'fixedToolbar' );

				}

			}

		},

		preWP54: function() {

			if ( null === wpUserData ) {

				blockEditorDefaults.toggleEditorFeature( 'fullscreenMode' );
				blockEditorDefaults.toggleEditorFeature( 'fixedToolbar' );

			}

			if ( null !== wpUserData ) {

				if ( 'core/edit-post' in wpUserData && 'preferences' in wpUserData['core/edit-post'] && 'features' in wpUserData['core/edit-post'].preferences ) {

					if ( ! ( 'fullscreenMode' in wpUserData['core/edit-post'].preferences.features ) ) {

						blockEditorDefaults.toggleEditorFeature( 'fullscreenMode' );

					}

					if ( ! ( 'fixedToolbar' in wpUserData['core/edit-post'].preferences.features ) ) {

						blockEditorDefaults.toggleEditorFeature( 'fixedToolbar' );

					}

				} else {

					blockEditorDefaults.toggleEditorFeature( 'fullscreenMode' );
					blockEditorDefaults.toggleEditorFeature( 'fixedToolbar' );

				}

			}

		},

		toggleEditorFeature: function( feature ) {

			wp.data.dispatch( 'core/edit-post' ).toggleFeature( feature );

		},

		setupCloseReferer: function() {

			if ( false === blockEditorDefaults.referer ) {

				return;

			}

			var updateBackBtnHref = setInterval( function() {

				var $closeButton = jQuery( '.edit-post-fullscreen-mode-close__toolbar a' );

				if ( $closeButton.length < 1 ) {

					return;

				}

				clearInterval( updateBackBtnHref );

				$closeButton.attr( 'href', blockEditorDefaults.referer );

			} );

		},

	};

	var wpUserData = JSON.parse( window.localStorage.getItem( 'WP_DATA_USER_' + wpaasBlockEditorDefaults.userId ) );

	$( document ).ready( wpaasBlockEditorDefaults.isWP54 ? blockEditorDefaults.postWP54 : blockEditorDefaults.preWP54 );
	$( document ).ready( wpaasBlockEditorDefaults.setupCloseReferer );


} )( jQuery );
