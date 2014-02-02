/*
 * MoonCake v1.3.1 - Login JS
 *
 * This file is part of MoonCake, an Admin template build for sale at ThemeForest.
 * For questions, suggestions or support request, please mail me at maimairel@yahoo.com
 *
 * Development Started:
 * July 28, 2012
 * Last Update:
 * December 07, 2012
 *
 */

;(function( $, window, document, undefined ) {
	
	var LoginScreen = function() { }

	LoginScreen.prototype = {

		init: function() {
			this.transitionFn = this['_fade'];
			$( '#login-inner .login-inner-form' ).removeClass( 'active' );
			
			var firstInnerForm = $( '#login-inner .login-inner-form:first' ).addClass('active');

			if(this._support( 'Transform', 'TransformOrigin', 'Transition' )) {

				$( '#login-inner' )
					.addClass('rotating')
					.css( 'height', firstInnerForm.outerHeight() )
					.find('.login-inner-form').each($.proxy(function(i, form) {
						$( form ).not( firstInnerForm ).find( ':input' ).attr('tabIndex', -1);
						this._addRotation( form, parseInt($(form).data('angle'), 10) );
					}, this));

				$( '#login-circle' )
					.on( this._transitionEndEventName(), function() {
						$(this).removeClass('rotation-active');
					})

				this.transitionFn = this['_rotate'];
			}

			$( '#login-buttons .btn' ).each($.proxy(function(i, btn) {
				var target = $($(btn).data( 'target' ));

				if( target && target.length ) {
					$(btn).toggleClass('disabled', $(target).is('.active'))
						.on('click', $.proxy(this._clickHandler, this));
				}
			}, this));

			return this;
		}, 

		_clickHandler: function(e) {
			var btn = $(e.currentTarget), 
				target = $(btn.data( 'target' ));

			if( !btn.is('.disabled') ) {
				this.transitionFn.call(this, target);
				$( '#login-buttons .btn' ).not(btn.addClass('disabled')).removeClass('disabled');
			}

			e.preventDefault();
		}, 

		_rotate: function(target) {
			$( '#login-inner' )
				.addClass( 'active' )
				.find( '.login-inner-form' )
				.removeClass( 'active' )
				.find( ':input' )
				.attr('tabindex', -1);

			target
				.find( ':input' )
				.removeAttr( 'tabIndex' );

			if((h = target.addClass( 'active' ).outerHeight()) !== $( '#login-inner' ).height()) {
				$( '#login-inner' ).css({ height: h });
			}

			this._addRotation( $( '#login-circle' ).addClass('rotation-active'), 
				-parseInt(target.data('angle'), 10) );
		}, 

		_fade: function(target) {
			$( '.login-inner-form.active' ).fadeOut( 'normal', function() {
				target.addClass( 'active' ).fadeIn();
				$(this).removeClass( 'active' );
			});
		},  

		_addRotation: function( el, deg ) {
			var r = 'rotate(' + deg + 'deg)';
			$(el).css({ '-webkit-transform': r, '-moz-transform': r, '-ms-transform': r, '-o-transform': r, 'transform': r });
		}, 

		_support: function() {
			var vendorPrefixes = "O Ms Webkit Moz".split( ' ' ),	
				i = vendorPrefixes.length, support = true, 
				divStyle = document.createElement('div').style;

			while( i-- ) {
				for(var a = 0, support = true; a < arguments.length; a++) {
					support = (vendorPrefixes[ i ] + arguments[ a ] in divStyle);
				}

				if( support ) return !!this._transitionEndEventName();
			}

			return false;
		}, 

		_transitionEndEventName: function() {
	        var transEndEventNames = {
	        	'WebkitTransition' : 'webkitTransitionEnd', 
	        	'MozTransition'    : 'transitionend', 
	        	'OTransition'      : 'oTransitionEnd otransitionend', 
	        	'transition'       : 'transitionend'
	        }, el = document.createElement('div');

	        for (var name in transEndEventNames){
	        	if (el.style[name] !== undefined) {
	        		return transEndEventNames[name];
	        	}
	        }
		}, 

		redraw: function() {
			if( $( '#login-inner').hasClass('rotating') ) {

				if((h = $('#login-inner .login-inner-form.active').outerHeight()) !== $( '#login-inner' ).height()) {
					$( '#login-inner' ).addClass('active').css({ height: h });
				}
			}
		}, 

		show: function( target ) {
			target.is( '.login-inner-form' ) && this.transitionFn.call(this, target);
		}
	};

	$.loginScreen = new LoginScreen();

	$( document ).ready( function( e ) {

		$.loginScreen.init();

		// Style checkboxes and radios
		$.fn.uniform && $(':radio.uniform, :checkbox.uniform').uniform();

		// IE Placeholder
		$.fn.placeholder && $('[placeholder]').placeholder();

		// Validations
		if( $.fn.validate ) {

			$( '.login-inner-form > form' ).each(function() {
				$( this ).validate({
					showErrors: function() {
						this.defaultShowErrors();
						$.loginScreen.redraw();
					}
				})
			});
		}
	});

	
}) (jQuery, window, document);
