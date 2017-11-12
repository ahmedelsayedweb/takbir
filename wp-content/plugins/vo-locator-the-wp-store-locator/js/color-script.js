// JavaScript Document
(function( $ ) {
 
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('#color-field').wpColorPicker();
		$('#color-field-text').wpColorPicker();
		$('#color-field-text-bg').wpColorPicker();
    });
     
})( jQuery );