jQuery(document).ready(function() {
	if ($('#InvoiceCustomerId').length > 0){
		$('#InvoiceCustomerId').change(function(e){
			var url = $('#js-customer-billing-address-ajax').data("url");
			var customerId = $(this).val();
			$.get(
				url+'/'+customerId,
				function(resp){
                    $('#Invoice_texts5').val(resp);
				}
			);
			}
		)
	}


	/*
	jQuery('#editbuttonsnone').click(function(event){
		event.preventDefault();
		jQuery('.newbuttonsmall').toggle();
		jQuery('.deletebuttonsmall').toggle();
	});
	jQuery('#flashMessage').fadeOut(2500);
	*/
});