<script type="text/javascript">
$(".upload-image").change(function () {
	var imagePreviewId = $(this).attr('id');
    imagePreview(this, imagePreviewId);
});
function imagePreview(input, imagePreviewId) {
	// Create an instance of Notyf
    var notyf = new Notyf({
        duration: 2000,
        ripple: true,
        position: {x:'right',y:'top'},
        dismissible: false
    });

    if (input.files && input.files[0]) {		
		if (input.files[0].size > {{config('global.MAX_UPLOAD_IMAGE_SIZE')}}) {
			notyf.error("{{ __('custom_admin.error_max_size_image') }}");
		} else {
			var fileName = input.files[0].name;
			var extension = fileName.substring(fileName.lastIndexOf('.') + 1);		
			if (extension == 'jpeg' || extension == 'jpg' || extension == 'gif' || extension == 'png' || extension == 'bmp') {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#image_holder_'+imagePreviewId).html('<img id="image_preview" class="mt-2" style="display: none;" />');
					$('#'+imagePreviewId+'_preview + div').remove();

					$('#'+imagePreviewId+'_preview').after('<div class="image-preview-holder upload_image_position_absolute" id="image_holder_'+imagePreviewId+'"><img src="'+e.target.result+'" class="d-block rounded image-preview-border" width="100" height="100"/><span class="delete-preview-image upload_image_delete_position_absolute" data-cid="'+imagePreviewId+'"><i class="bx bx-x-circle"></i></span></div>');
				};
				reader.readAsDataURL(input.files[0]);
			} else {
				$('#'+imagePreviewId).val('');
				$('#'+imagePreviewId+'_preview + img').remove();
				notyf.error("{{ __('custom_admin.error_image') }}");
			}
		}
    } else {
		notyf.error("{{ __('custom_admin.error_image') }}");
	}
}
$(document).on('click', '.delete-preview-image', function() {
	var imageInputId = $(this).data('cid');
	$('#'+imageInputId).val('');
	$('#'+imageInputId+'_preview + div').remove();
	$('#image_holder_'+imageInputId).html('');
});
</script>