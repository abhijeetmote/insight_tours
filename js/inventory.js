$(document).ready(function(){
	var baseUrl = $('#baseUrl').val();

	$('#addInventoryItem').click(function(){
		var name = $('#name').val();
		var unit = $('#unit').val();
		var qty = $('#qty').val();
		var cost = $('#cost').val();
		var i = 0; 
		$('.input-error').removeClass('input-error');
		$('.input-text-error').addClass('hidden');

		if(name == ""){
			$('#name-error').removeClass('hidden');
			$('#name').addClass('input-error');
			i++;
		}
		if(unit == ""){
			$('#unit-error').removeClass('hidden');
			$('#unit').addClass('input-error');
			i++;
		}
		if(qty == ""){
			$('#qty-error').removeClass('hidden');
			$('#qty').addClass('input-error');
			i++;
		}
		if(cost == ""){
			$('#cost-error').removeClass('hidden');
			$('#cost').addClass('input-error');
			i++;
		}

		if(i > 0){
			return false;
		}

		jobject = {
			'name' : name,
			'unit' : unit,
			'qty' : qty,
			'cost' : cost
		}
		
		$.ajax({
            url: baseUrl + 'inventory/addItem',
            method: 'POST',
            crossDomain: true,
            data: jobject,
            dataType: 'json',
            beforeSend: function (xhr) {
            	$('.input-error').removeClass('input-error');
				$('.input-text-error').addClass('hidden');
                $('#addInventoryItem').html('<i class="ace-icon fa fa-spinner fa-spin orange bigger-125"></i>');
            },
            success: function (data) {
            	$('#addInventoryItem').html('<i class="ace-icon fa fa-check bigger-110"></i> Submit');
            	$('.alert-box').html('<div class="alert alert-block alert-success">\
						<button type="button" class="close" data-dismiss="alert">\
							<i class="ace-icon fa fa-times"></i>\
						</button>\
						<p>\
							<strong>\
								<i class="ace-icon fa fa-check"></i>\
								Well done!\
							</strong>\
							Successfully Submit.\
						</p>\
					</div>');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
	});
});