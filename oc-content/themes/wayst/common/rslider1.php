<?php $random = ''; 
$random = rand(0, 15); //more info about the rand function can be found at the link below. ?>
	<?php osc_query_item(array(
    "category_name" => osc_get_preference('slidercatname1', 'wayst'),
	"results_per_page" => "16",
	// "offset" => $random
    
));
if( osc_count_custom_items() == 0) { ?>
   <h2 class="front-title">
                            <?php echo osc_get_preference('slidercatname1m', 'wayst'); ?>: <?php _e('No Listings', 'wayst') ; ?>                     </h2>
<?php } else { ?>
    <h2 class="front-title">
                            <?php _e('Listings', 'wayst') ; ?>: <?php echo osc_get_preference('slidercatname1m', 'wayst'); ?>                        </h2>
                        <div class="front-covers grid "> 
                        <div class="slider1">
                         <?php $class = "ga-event overlay-5"; ?>
                        <?php while ( osc_has_custom_items() ) { ?>       
                <div class="front-cover front-cover">
                
            <a href="<?php echo osc_item_url(); ?>" class="<?php osc_run_hook("highlight_class"); ?> <?php echo $class. (osc_item_is_premium()?" premium":""); ?>" data-cat="Front" data-label="<?php echo osc_esc_html(osc_item_title()); ?>"></a>
            <?php if( osc_images_enabled_at_items() ) { ?>
            <figure>
            <?php if(osc_count_item_resources()) { ?>
                <img class="img-responsive"  src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>">
                <?php } else { ?>
                        <img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="No Photo">
                    <?php } ?>
                                    <figcaption>
                        <?php echo osc_highlight( strip_tags( osc_item_title() ), 33 ); ?><div class="title2"><?php if ( osc_item_pub_date() != '' ) echo __('', '') . ' ' . osc_format_date( osc_item_pub_date() ); ?></div>                    </figcaption>
                            </figure><?php } ?>
                            <span class="price">
                        <?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { echo osc_item_formated_price(); ?>                    <?php } ?></span>
               
                    </div> <?php $class = ($class == 'ga-event overlay-5') ? 'ga-event overlay-3' : 'ga-event overlay-5'; ?> <?php } ?>
        </div></div><?php } ?>
        <script>
    jQuery(document).ready(function ($) {

      $('.slider1').slick({
  infinite: true,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  prevArrow:'',
  nextArrow:'',
  responsive: [
     {
      breakpoint: 1200,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
		autoplay: true,
  autoplaySpeed: 2000,
        infinite: true,
      }
	 },
	 {
      breakpoint: 900,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
		autoplay: true,
  autoplaySpeed: 2000,
        
      }
    },
	 {
      breakpoint: 800,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
		autoplay: true,
  autoplaySpeed: 2000,
        
      }
    },
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
		autoplay: true,
  autoplaySpeed: 2000,
        
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 6,
        slidesToScroll: 1,
		autoplay: true,
  autoplaySpeed: 2000,
        
      }
    },
	{
      breakpoint: 580,
      settings: {
        slidesToShow: 6,
        slidesToScroll: 1,
		autoplay: true,
  autoplaySpeed: 2000,
        
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
  autoplaySpeed: 2000,
      }
    }
  ]
});
    });
</script>