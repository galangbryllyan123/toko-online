<script type="text/javascript">
    $(document).ready(function () {
    	$.ajax({
    		type: "GET",
    		url: "<?php echo mdh_messenger_ajax_url(); ?>",
    		data: {
    			"do": "widget"
    		},
    		dataType: "json",
    		success: function(response, text, jqXHR) {
    			// Inserts a small stamp to notify new messages.
                var $this = $(".js-messenger-widget");
    			$this.html("(" + response.nbUnread + ")");
    		}
    	});
    });
</script>
<a href="<?php echo mdh_messenger_inbox_url(); ?>">
    <?php _e("Messenger", "madhouse_messenger"); ?> <span class="js-messenger-widget"></span>
</a>