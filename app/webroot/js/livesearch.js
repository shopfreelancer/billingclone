jQuery.fn.livesearch = function() { 

return jQuery(this).each(function() {

jQuery(this).find('#searchable').keyup(function(){
var input = jQuery(this).text();
	if(input != ''){
	sendForm(input);
	}
}
);

function sendForm(input){
   jQuery.post(
	'customers/livesearch/',
  {
    'data' : input
  },
	function(resp){
		
		jQuery('#searchcontainer').remove();
		if(resp != "\"\"" && resp != null){
			var customers = jQuery.parseJSON(resp);
	
			var customer_result = '<div id="searchcontainer">';
			for(var i = 0; i < customers.length; i++){
				if ((i+1)%2) { 
				var zebra = 'livesearch_even';
				} else {
				var zebra = 'livesearch_odd';
				}
			customer_result += '<div class="'+zebra+'"><a href="customers/view/'+ customers[i].id+'">'+ customers[i].firstname +' '+ customers[i].lastname +'<br/>'+customers[i].companyname+'</a></div>';
			}
			customer_result += '</div>';
			jQuery('#livesearch').append(customer_result);
			jQuery('#searchcontainer').mouseleave(function(){jQuery(this).remove();});
		}
		
	}
  );  

}



});
}

jQuery(document).ready(function() {
	jQuery('#livesearch').livesearch();
	
});