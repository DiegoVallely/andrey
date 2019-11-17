
(function($){

	/**
	 * AIOSRS Schema 
	 *
	 * @class AIOSRS_Schema
	 * @since 1.0
	 */
	AIOSRS_Schema = {
		
		/**
		 * Initializes a AIOSRS Schema.
		 *
		 * @since 1.0
		 * @method init
		 */
		container: '',

		init: function() {

			var self = this;
			self.container = $('#aiosrs-schema-settings');
			
			// Init backgrounds.
			$( document ).ready( function( $ ) {
				$('.select2-class').select2();
			});

			self.container.on( 'change', 'select.bsf-aiosrs-schema-meta-field', function() {
				var self = $(this),
					parent   = self.parent(),
					value    = self.val();

				var text_wrapper = parent.find('.bsf-aiosrs-schema-custom-text-wrap');
				if( 'custom-text' == value ) {
					text_wrapper.removeClass( 'bsf-hidden-field' );
				} else if ( ! text_wrapper.hasClass( 'bsf-hidden-field' ) ) {
					text_wrapper.addClass( 'bsf-hidden-field' );
				}

				var text_wrapper = parent.find('.bsf-aiosrs-schema-fixed-text-wrap');
				if( 'fixed-text' == value ) {
					text_wrapper.removeClass( 'bsf-hidden-field' );
				} else if ( ! text_wrapper.hasClass( 'bsf-hidden-field' ) ) {
					text_wrapper.addClass( 'bsf-hidden-field' );
				}

				var specific_meta_wrapper = parent.find('.bsf-aiosrs-schema-specific-field-wrap');
				if( 'specific-field' == value ) {
					specific_meta_wrapper.removeClass( 'bsf-hidden-field' );
				} else if ( ! specific_meta_wrapper.hasClass( 'bsf-hidden-field' ) ) {
					specific_meta_wrapper.addClass( 'bsf-hidden-field' );
				}
			});

			
			self.container.on('change','.bsf-aiosrs-schema-row-rating-type select.bsf-aiosrs-schema-meta-field', function(e) {
				e.preventDefault();

				$(this).closest('.bsf-aiosrs-schema-table').find('.bsf-aiosrs-schema-row').css( 'display', '' );
				if( 'accept-user-rating' == $(this).val() ){
					var review_count_wrap = $(this).closest('.bsf-aiosrs-schema-row').next('.bsf-aiosrs-schema-row'),
						name = review_count_wrap.find('.bsf-aiosrs-schema-meta-field').attr('name');

					if( name.indexOf('[review-count]') >= 0 ) {
						review_count_wrap.hide();
					}
				}
			});
			self.container.find('select.bsf-aiosrs-schema-meta-field').trigger('change');

			$( 'select.bsf-aiosrs-schema-select2' ).each(function(index, el) {
				self.init_target_rule_select2( el );
			});
			
			self.container.on( 'click', '.bsf-repeater-add-new-btn', function( event ) {
				event.preventDefault();
				self.add_new_repeater( $(this) );
			});

			self.container.on( 'click', '.bsf-repeater-close', function( event ) {
				event.preventDefault();
				self.add_remove_repeater( $(this) );
			});

			self.schemaTypeDependency();
			self.bindTooltip();

		},

		add_new_repeater: function( selector ) {
			
			var self = this,
				parent_wrap = selector.closest( '.bsf-aiosrs-schema-type-wrap' ),
				total_count = parent_wrap.find('.aiosrs-pro-repeater-table-wrap').length,
				template    = parent_wrap.find('.aiosrs-pro-repeater-table-wrap').first().clone();

			template.find('.bsf-aiosrs-schema-custom-text-wrap, .bsf-aiosrs-schema-specific-field-wrap').each(function(index, el) {

				if( ! $(this).hasClass( 'bsf-hidden-field' ) ) {
					$(this).addClass( 'bsf-hidden-field' );
				}
			});
			
			template.find( 'select.bsf-aiosrs-schema-meta-field' ).each(function(index, el) {
				$(this).val('none');
				
				var field_name  = 'undefined' != typeof $(this).attr('name') ? $(this).attr('name').replace('[0]', '['+ total_count +']') : '',
					field_class = 'undefined' != typeof $(this).attr('class') ? $(this).attr('class').replace('-0-', '-'+ total_count +'-') : '',
					field_id	= 'undefined' != typeof $(this).attr('id') ? $(this).attr('id').replace('-0-', '-'+ total_count +'-') : '';

				$(this).attr( 'name', field_name );
				$(this).attr( 'class', field_class );
				$(this).attr( 'id', field_id );
			});
			template.find( 'input, textarea, select:not(.bsf-aiosrs-schema-meta-field)' ).each(function(index, el) {
				$(this).val('');

				var field_name  = 'undefined' != typeof $(this).attr('name') ? $(this).attr('name').replace('[0]', '['+ total_count +']') : '',
					field_class = 'undefined' != typeof $(this).attr('class') ? $(this).attr('class').replace('-0-', '-'+ total_count +'-') : '',
					field_id	= 'undefined' != typeof $(this).attr('id') ? $(this).attr('id').replace('-0-', '-'+ total_count +'-') : '';

				$(this).attr( 'name', field_name );
				$(this).attr( 'class', field_class );
				$(this).attr( 'id', field_id );
			});

			template.find('span.select2-container').each(function(index, el) {
				$(this).remove();				
			});

			template.insertBefore(selector);
			template.find( 'select.bsf-aiosrs-schema-select2' ).each(function(index, el) {
				self.init_target_rule_select2( el );
			});
		},

		add_remove_repeater: function( selector ) {
			var parent_wrap = selector.closest( '.bsf-aiosrs-schema-type-wrap' ),
				repeater_count = parent_wrap.find('> .aiosrs-pro-repeater-table-wrap').length;

			if ( repeater_count > 1 ) {
				selector.closest('.aiosrs-pro-repeater-table-wrap').remove();
			}
		},

		bindTooltip: function() {

			// Call Tooltip
			$('.bsf-aiosrs-schema-heading-help').tooltip({
				content: function() {
					return $(this).prop('title');
				},
				tooltipClass: 'bsf-aiosrs-schema-ui-tooltip',
				position: {
					my: 'center top',
					at: 'center bottom+10',
				},
				hide: {
					duration: 200,
				},
				show: {
					duration: 200,
				},
			});
		},

		schemaTypeDependency: function() {

			var container = this.container;
			this.container.on( 'change', 'select[name="bsf-aiosrs-schema-type"]', function() {

				container.find('.bsf-aiosrs-schema-meta-wrap').css('display', 'none');
				var schema_type = $(this).val();
				if( 'undefined' != typeof schema_type && '' != schema_type ) {
					container.find('#bsf-'+ schema_type +'-schema-meta-wrap').css('display', '');
				}
			});
		},

		init_target_rule_select2: function( selector ) {
		
			$(selector).select2({

				placeholder: "Search Fields...",

				ajax: {
					url: ajaxurl,
					dataType: 'json',
					method: 'post',
					delay: 250,
					data: function (params) {
						return {
							q: params.term, // search term
							page: params.page,
							action: 'bsf_get_specific_meta_fields'
						};
					},
					processResults: function (data) {
						return {
							results: data
						};
					},
					cache: true
				},
				minimumInputLength: 2,
			});
		},
	}

	/* Initializes the AIOSRS Schema. */
	$(function(){
		AIOSRS_Schema.init();
	});

})(jQuery);