/**
 * Note TinyMCE Theme - /assets/js/note-tinymce-theme.js
 * License: GPLv2 or later
 * Copyright: Janneke Van Dorpe (iseulde), http://iseulde.com/
 *
 * @see https://github.com/iseulde/wp-front-end-editor/
 * @see https://github.com/iseulde/wp-front-end-editor/blob/master/js/tinymce.theme.js
 * @see https://wordpress.org/plugins/wp-front-end-editor/
 *
 * We've used Janneke Van Dorpe's TinyMCE theme as a base and modified it to suit our needs.
 */

/* global tinymce */

tinymce.ThemeManager.add( 'note', function( editor ) {
	var self = this,
		settings = editor.settings,
		Factory = tinymce.ui.Factory,
		each = tinymce.each,
		DOM = tinymce.DOM,
		adminBarHeight = 32,
		focus;

	function getParent( node, nodeName ) {
		while ( node ) {
			if ( node.nodeName === nodeName ) {
				return node;
			}

			node = node.parentNode;
		}

		return false;
	}

	function toolbarItems( array, block ) {
		var items = [],
			buttonGroup;

		if ( ! array ) {
			return;
		}

		each( array, function( item ) {
			var itemName;

			function bindSelectorChanged() {
				var selection = editor.selection;

				if ( itemName === 'bullist' ) {
					selection.selectorChanged( 'ul > li', function( state, args ) {
						var nodeName,
							i = args.parents.length;

						while ( i-- ) {
							nodeName = args.parents[ i ].nodeName;

							if ( nodeName === 'OL' || nodeName === 'UL' ) {
								break;
							}
						}

						item.active( state && nodeName === 'UL' );
					} );
				}

				if ( itemName === 'numlist' ) {
					selection.selectorChanged( 'ol > li', function(state, args) {
						var nodeName,
							i = args.parents.length;

						while ( i-- ) {
							nodeName = args.parents[ i ].nodeName;

							if ( nodeName === 'OL' || nodeName === 'UL' ) {
								break;
							}
						}

						item.active( state && nodeName === 'OL' );
					} );
				}

				if ( item.settings.stateSelector ) {
					selection.selectorChanged( item.settings.stateSelector, function( state ) {
						item.active( state );
					}, true );
				}

				if ( item.settings.disabledStateSelector ) {
					selection.selectorChanged( item.settings.disabledStateSelector, function( state ) {
						item.disabled( state );
					} );
				}
			}

			if ( item === '|' ) {
				buttonGroup = null;
			} else {
				if ( Factory.has( item ) ) {
					item = {
						type: item
					};

					if ( settings.toolbar_items_size ) {
						item.size = settings.toolbar_items_size;
					}

					items.push( item );
					buttonGroup = null;
				} else {
					if ( ! buttonGroup || block ) {
						buttonGroup = {
							type: 'buttongroup',
							items: []
						};
						items.push( buttonGroup );
					}

					if ( editor.buttons[ item ] ) {
						itemName = item;
						item = editor.buttons[ itemName ];

						if ( typeof( item ) === 'function' ) {
							item = item();
						}

						if ( item.icon && item.icon.indexOf( 'dashicons' ) !== -1 ) {
							item.icon = 'dashicon ' + item.icon;
						}

						if ( block ) {
							item.text = item.tooltip;
							item.tooltip = false;
						}

						item.type = item.type || 'button';

						if ( settings.toolbar_items_size ) {
							item.size = settings.toolbar_items_size;
						}

						if ( itemName === 'link' ) {
							item.onPostRender = function() {
								var self = this;

								editor.on( 'NodeChange', function( event ) {
									self.active( getParent( event.element, 'A' ) );
								} );
							};
						} else if ( itemName === 'unlink' ) {
							item.onPostRender = function() {
								var self = this;

								editor.on( 'NodeChange', function( event ) {
									var disabled = event.element.nodeName !== 'A' && editor.selection.getContent().indexOf( '<a' ) === -1;
									self.disabled( disabled );
									DOM.setAttrib( self.getEl(), 'tabindex', disabled ? '0' : '-1' );
								} );
							};

							item.onclick = function() {
								if ( editor.selection.getContent().indexOf( '<a' ) === -1 ) {
									editor.selection.select( editor.selection.getNode() );
								}

								editor.execCommand( 'unlink' );
							};
						}

						item = Factory.create( item );
						buttonGroup.items.push( item );

						if ( editor.initialized ) {
							bindSelectorChanged();
						} else {
							editor.on( 'init', bindSelectorChanged );
						}
					}
				}
			}
		});

		return items;
	}

	function createToolbar( items ) {
		return Factory.create( {
			type: 'panel',
			layout: 'stack',
			classes: 'toolbar-grp',
			ariaRoot: true,
			ariaRemember: true,
			items: [
				{
					type: 'toolbar',
					layout: 'flow',
					items: toolbarItems( items )
				}
			]
		} );
	}

	editor.toolbarItems = toolbarItems;

	self.renderUI = function() {
		var panel, toolbars = {}, hasPlaceholder,
			upperMargin = 0;

		settings.content_editable = true;

		function isEmpty() {
			return editor.getContent( { format: 'raw' } ).replace( /(?:<p[^>]*>)?(?:<br[^>]*>)?(?:<\/p>)?/, '' ) === '';
		}

		editor.on( 'activate focus', function() {
			focus = true;
			DOM.addClass( editor.getBody(), 'mce-edit-focus' );
		} );

		editor.on( 'deactivate blur hide', function() {
			focus = false;
			DOM.removeClass( editor.getBody(), 'mce-edit-focus' );
		} );

		editor.on( 'remove', function() {
			panel && panel.remove();
			panel = null;
		} );

		// Placeholder
		if ( settings.placeholder ) {
			editor.on( 'blur LoadContent deactivate', function() {
				if ( isEmpty() ) {
					editor.setContent( settings.placeholder );
					hasPlaceholder = true;
					DOM.addClass( editor.getBody(), 'mce-placeholder' );
				}
			} );

			editor.on( 'focus activate', function() {
				if ( hasPlaceholder ) {
					editor.setContent( '' );

					// Make sure the cursor appears in editor
					editor.selection.select( editor.getBody(), true );
					editor.selection.collapse( false );
				}
			} );

			editor.on( 'SetContent', function( event ) {
				if ( hasPlaceholder && ! event.load ) {
					hasPlaceholder = false;
					DOM.removeClass( editor.getBody(), 'mce-placeholder' );
				}
			} );

			editor.on( 'PostProcess', function( event ) {
				if ( hasPlaceholder && event.content ) {
					event.content = '';
				}
			} );

			editor.on( 'BeforeAddUndo', function( event ) {
				if ( hasPlaceholder ) {
					event.preventDefault();
				}
			} );
		}

		if ( ! settings.toolbar || ! settings.toolbar.length || panel ) {
			return {};
		}

		if ( DOM.getStyle( document.body, 'position', true ) === 'relative' ) {
			upperMargin =
				parseInt( DOM.getStyle( document.body, 'margin-top', true ), 10 ) +
				parseInt( DOM.getStyle( document.documentElement, 'padding-top', true ), 10 ) +
				parseInt( DOM.getStyle( document.documentElement, 'margin-top', true ), 10 );
		}

		toolbars.normal = createToolbar( settings.toolbar );
		toolbars.img = createToolbar( [ 'imgalignleft', 'imgaligncenter', 'imgalignright', 'imgalignnone', 'edit', 'remove' ] );
		toolbars.view = createToolbar( [ 'editview', 'removeview' ] );

		panel = self.panel = Factory.create( {
			type: 'floatpanel',
			role: 'application',
			classes: 'tinymce tinymce-inline',
			layout: 'stack',
			autohide: true,
			items: [
				toolbars.normal,
				toolbars.img,
				toolbars.view
			]
		} );

		panel.reposition = function( name, view ) {
			var toolbarEl = this.getEl(),
				selection = view || editor.selection.getRng(),
				boundary = selection.getBoundingClientRect(),
				boundaryMiddle = ( boundary.left + boundary.right ) / 2,
				windowWidth = window.innerWidth,
				toolbarWidth, toolbarHalf,
				margin = parseInt( DOM.getStyle( toolbarEl, 'margin-bottom', true ), 10 ) + upperMargin,
				top, left, className;

			toolbarEl.className = ( ' ' + toolbarEl.className + ' ' ).replace( /\smce-arrow-\S+\s/g, ' ' ).slice( 1, -1 );

			name = name || 'normal';

			if ( ! toolbars[ name ]._visible ) {
				each( toolbars, function( toolbar ) {
					toolbar.hide();
				} );

				toolbars[ name ].show();
			}

			toolbarWidth = toolbarEl.offsetWidth;
			toolbarHalf = toolbarWidth / 2;

			if ( boundary.top < toolbarEl.offsetHeight + adminBarHeight ) {
				className = ' mce-arrow-up';
				top = boundary.bottom + margin;
			} else {
				className = ' mce-arrow-down';
				top = boundary.top - toolbarEl.offsetHeight - margin;
			}

			left = boundaryMiddle - toolbarHalf;

			if ( toolbarWidth >= windowWidth ) {
				className += ' mce-arrow-full';
				left = 0;
			} else if ( ( left < 0 && boundary.left + toolbarWidth > windowWidth ) || ( left + toolbarWidth > windowWidth && boundary.right - toolbarWidth < 0 ) ) {
				left = ( windowWidth - toolbarWidth ) / 2;
			} else if ( left < 0 ) {
				className += ' mce-arrow-left';
				left = boundary.left;
			} else if ( left + toolbarWidth > windowWidth ) {
				className += ' mce-arrow-right';
				left = boundary.right - toolbarWidth;
			}

			toolbarEl.className += className;

			DOM.setStyles( toolbarEl, { 'left': left, 'top': top + window.pageYOffset } );

			return this;
		};

		panel.on( 'show', function() {
			//var self = this;

			setTimeout( function() {
				//self._visible && DOM.addClass( self.getEl(), 'mce-inline-toolbar-active' );
				panel.state.data.visible && DOM.addClass( panel.getEl(), 'mce-inline-toolbar-active' );
			}, 100 );
		} );

		panel.on( 'hide', function() {
			// Only hide the panel if the selection is truly collapsed
			if ( ! editor.selection || ( editor.selection &&  editor.selection.isCollapsed() ) ) {
				DOM.removeClass( this.getEl(), 'mce-inline-toolbar-active' );
			}
		} );

		panel.on( 'cancel', function() {
			editor.focus();
		} );

		DOM.bind( window, 'resize', function() {
			panel.hide();
		} );

		editor.on( 'SelectionChange NodeChange', function( event ) {
			var element = event.element || editor.selection.getNode(),
				view = editor.plugins.wpview.getView();

			if ( editor.selection.isCollapsed() && ! view ) {
				panel.hide();
				return;
			}

			setTimeout( function() {
				var content, name;

				if ( ! focus ) {
					return;
				}

				if ( ( ! editor.selection.isCollapsed() &&
						( content = editor.selection.getContent() ) &&
						( content.replace( /<[^>]+>/g, '' ).trim() || content.indexOf( '<' ) === 0 ) &&
						element.nodeName !== 'HR' ) || view ) {

					if ( view ) {
						name = 'view';
					} else if ( element.nodeName === 'IMG' ) {
						name = 'img';
					} else {
						name = 'normal';
					}

					panel.show().reposition( name, view );
				} else {
					panel.hide();
				}
			}, 100 );
		} );

		editor.shortcuts.add( 'Alt+F10', '', function() {
			var item = panel.find( 'toolbar' )[0];

			item && item.focus( true );
		} );

		panel.renderTo( document.body ).reflow().hide();

		each( toolbars, function( toolbar ) {
			toolbar.hide();
		} );

		return {};
	};
} );