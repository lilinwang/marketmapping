// autocomplet : this function will be executed every time we change the text
function autocomplet(value) {
	var min_length = 0; // min caracters to display the autocomplete
	var $top_list=$('#axis_top_list');
	$top_list.hide();
	var $bottom_list=$('#axis_bottom_list');
	$bottom_list.hide();
	var $left_list=$('#axis_left_list');
	$left_list.hide();
	var $right_list=$('#axis_right_list');
	$right_list.hide();
	
	var $list=$('#'+value.id+'_list');
	var $input=$('#'+value.id);
	var keyword = $input.val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'ajax/auto_complete',
			type: 'POST',
			data: {keyword:keyword,input:value.id},
			success:function(data){
				$list.show();
				$list.html(data);
			}
		});
	} else {
		$list.hide();
	}
}
 
// set_item : this function will be executed when we select an item
function set_item(item,value) {	
	var $list=$('#'+value+'_list');
	var $input=$('#'+value);
	// change input value
	$input.val(item);
	// hide proposition list
	$list.hide();
}