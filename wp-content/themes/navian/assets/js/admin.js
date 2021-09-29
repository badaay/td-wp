(function($){
    "use strict";
	jQuery(document).ready(function($) {
		jQuery('body').on('change', 'input[type="range"]', function(e) {
			var val = jQuery(this).val();
			var name = jQuery(this).attr('name');
			jQuery('input[type="text"][name="'+ name +'"]').val(val);
		});
		jQuery('body').on('click', '.tlg-icons i', function(e) {
			jQuery('.tlg-icons i').removeClass('active');
			jQuery(this).addClass('active').parents('.tlg-icons').find('input').attr('value', jQuery(this).attr('data-icon-class'));
			jQuery(jQuery(this).attr('data-icon-input')).attr('value', jQuery(this).attr('data-icon-class'));
		});
		jQuery('body').on('click', '.tlg-icon-trigger', function(e) {
			jQuery(jQuery(this).attr('data-target')).toggleClass('active');
			return false;
		});
		jQuery('body').on('click', '.tlg-icon-clear', function(e) {
			jQuery(jQuery(this).attr('data-target')).attr('value', '');
			return false;
		});
		if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
			jQuery('body').on('click', '.tlg-image-trigger', function(e) {
                e.preventDefault();
                var button = jQuery(this);
                var id = button.prev();
                wp.media.editor.send.attachment = function(props, attachment) {
                    id.val(attachment.id);
                };
                wp.media.editor.open(button);
                return false;
            });
        }
	});
})(jQuery);