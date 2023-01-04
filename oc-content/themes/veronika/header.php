<?php 
  osc_goto_first_locale();

  if(function_exists('im_messages')) {
    if(osc_is_web_user_logged_in()) {
      $message_count = ModelIM::newInstance()->countMessagesByUserId( osc_logged_user_id() );
      $message_count = $message_count['i_count'];
    } else {
      $message_count = 0;
    }
  }
?>


<div id="header-bar">
  <div class="inside">
    <a href="#" id="h-options" class="header-menu resp is767" data-link-id="#menu-options">
      <span class="line tr1"></span>
      <span class="line tr1"></span>
      <span class="line tr1"></span>
    </a>

    <a id="h-search" class="header-menu resp is767 tr1" data-link-id="#menu-search">
      <span class="tr1"></span>
    </a>

    <a id="h-user" class="header-menu resp is767 tr1" data-link-id="#menu-user">
      <span class="tr1"></span>
      <?php if(function_exists('im_messages')) { ?>
        <div class="counter"><?php echo $message_count; ?></div>
      <?php } ?>
    </a>


    <div class="left-block">
      <div class="logo not767">
        <a class="resp-logo" href="<?php echo osc_base_url(); ?>"><?php echo logo_header(); ?></a>
      </div>

      <?php if(osc_is_ad_page()) { ?>
        <a id="history-back" class="is767" href="<?php echo osc_search_url(veronika_search_params()); ?>"><i class="fa fa-angle-left"></i><span><?php _e('Search', 'veronika'); ?></span></a>
      <?php } else if(osc_is_home_page()) { ?>
        <a class="logo-text is767" href="<?php echo osc_base_url(); ?>"><span><?php echo osc_get_preference('logo_text', 'veronika_theme'); ?></span></a>
      <?php } else { ?>
        <a id="history-back" class="is767" href="<?php echo osc_base_url(); ?>"><i class="fa fa-angle-left"></i><span><?php _e('Home', 'veronika'); ?></span></a>
      <?php } ?>

      <div class="language not767">
        <?php if ( osc_count_web_enabled_locales() > 1) { ?>
          <?php $current_locale = mb_get_current_user_locale(); ?>

          <?php osc_goto_first_locale(); ?>
          <span id="lang-open-box">
            <div class="mb-tool-cover">
              <span id="lang_open" class="round3<?php if( osc_is_web_user_logged_in() ) { ?> logged<?php } ?>">
                <span>
                  <span class="non-resp"><?php echo $current_locale['s_short_name']; ?></span>
                  <span class="resp"><?php echo strtoupper(substr($current_locale['pk_c_code'], 0, 2)); ?></span>

                  <i class="fa fa-angle-down"></i></span>
              </span>

              <div id="lang-wrap" class="mb-tool-wrap">
                <div class="mb-tool-cover">
                  <ul id="lang-box">
                    <span class="info"><?php _e('Select language', 'veronika'); ?></span>

                    <?php $i = 0 ;  ?>
                    <?php while ( osc_has_web_enabled_locales() ) { ?>
                      <li <?php if( $i == 0 ) { echo "class='first'" ; } ?> title="<?php echo osc_esc_html(osc_locale_field("s_description")); ?>"><a id="<?php echo osc_locale_code() ; ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ) ; ?>"><img src="<?php echo osc_current_web_theme_url();?>images/country_flags/<?php echo strtolower(substr(osc_locale_code(), 3)); ?>.png" alt="<?php _e('Country flag', 'veronika');?>" /><span><?php echo osc_locale_name(); ?></span></a><?php if (osc_locale_code() == $current_locale['pk_c_code']) { ?><i class="fa fa-check"></i><?php } ?></li>
                      <?php $i++ ; ?>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
          </span>
        <?php } ?>
      </div>


      <?php if(!osc_is_home_page() && !osc_is_search_page()) { ?>
        <div id="top-search" class="non-resp">
          <a href="<?php echo osc_search_url(veronika_search_params()); ?>" class="btn"><i class="fa fa-search"></i><span><?php _e('Search', 'veronika'); ?></span></a>
        </div>
      <?php } ?>
    </div>

    <div class="right-block not767">

      <?php if(osc_is_web_user_logged_in()) { ?>
        <a class="logout round3 tr1" href="<?php echo osc_user_logout_url(); ?>"><i class="fa fa-sign-out"></i></a>
      <?php } ?>

      <a class="publish round3 tr1" href="<?php echo osc_item_post_url(); ?>">
        <span class="non-resp"><?php _e('Pasang Iklan Gratis', 'veronika'); ?></span>
        <span class="resp"><?php _e('Pasang Iklan Gratis', 'veronika'); ?></span>
      </a>

      <div class="account<?php if(osc_is_web_user_logged_in() || 1==1) { ?> has-border<?php } ?>">
        <?php if(osc_is_web_user_logged_in()) { ?>
          <a class="profile tr1" href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'veronika'); ?></a>
        <?php } else { ?>
          <a class="profile tr1" href="<?php echo osc_user_login_url(); ?>"><?php _e('Sign in', 'veronika'); ?></a>
        <?php } ?>

        <?php if(function_exists('profile_picture_show') && osc_is_web_user_logged_in()) { ?>
          <a class="picture tr1" href="<?php echo osc_user_profile_url(); ?>"><?php profile_picture_show(null, null, 80, null, osc_logged_user_id()); ?></a>
        <?php } else { ?>
          <a class="picture tr1" href="<?php echo osc_user_profile_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/profile-default.png'); ?>"/></a>
        <?php } ?>
      </div>

<!--
<?php
    osc_run_hook('mdh_messenger_widget'); // Includes the widget who will display : Message ({NUMBER UNREAD MESSAGE})
?>
-->

      <div class="notification">
        <?php if(osc_is_web_user_logged_in() || 1==1) { ?>
          <?php if(function_exists('im_messages')) { ?>
            <a class="message tr1" title="<?php _e('Instant Messages', 'veronika'); ?>" href="<?php echo osc_route_url( 'im-threads'); ?>"><i class="fa fa-envelope-o"></i> <span class="counter"><?php echo $message_count; ?></span></a>
          <?php } ?>

          <a class="alert tr1" title="<?php _e('Alerts', 'veronika'); ?>" href="<?php echo osc_user_alerts_url(); ?>"><i class="fa fa-bell-o"></i> <span class="counter"><?php echo (osc_is_web_user_logged_in() ? count(Alerts::newInstance()->findByUser(osc_logged_user_id())) : 0); ?></span></a>
          <a class="item tr1" title="<?php _e('Listings', 'veronika'); ?>" href="<?php echo osc_user_list_items_url(); ?>"><i class="fa fa-list"></i> <span class="counter"><?php echo (osc_is_web_user_logged_in() ? Item::newInstance()->countByUserID(osc_logged_user_id()) : 0); ?></span></a>
        <?php } ?>
      </div>

    </div>   
  </div>
</div>


<?php
  // SHOW SEARCH BAR AND CATEGORY LIST ON HOME & SEARCH PAGE
  if(osc_is_home_page()) {
    osc_current_web_theme_path('inc.search.php');
  }

  if(osc_is_home_page() or osc_is_search_page()) {
    osc_current_web_theme_path('inc.category.php');
  }

  // GET CURRENT POSITION
  $position = array(osc_get_osclass_location(), osc_get_osclass_section());
  $position = array_filter($position);
  $position = implode('-', $position);
?>

<div class="container-outer <?php echo $position; ?>">


<?php if(!osc_is_home_page()) { ?>
  <div class="container">
<?php } ?>


<?php if ( veronika_is_demo() ) { ?>
  <div id="piracy" class="noselect" title="Click to hide this box">This theme is ownership of MB Themes and can be bought only on http://www.mb-themes.com or via Osclass Market that is official reseller. When you buy this theme on other site, you will have no support for this theme, you will be supporting piracy and violate ACTA anti-piracy agreement!</div>
  <script>$(document).ready(function(){ $('#piracy').click(function(){ $(this).fadeOut(200); }); });</script>
<?php } ?>


<?php if(function_exists('scrolltop')) { scrolltop(); } ?>


<div class="clear"></div>


<div class="flash-wrap">
  <?php osc_show_flash_message(); ?>
</div>


<?php
  osc_show_widgets('header');
  $breadcrumb = osc_breadcrumb('<span class="bread-arrow"><i class="fa fa-angle-right"></i></span>', false);
  $breadcrumb = str_replace(osc_page_title(), __('Home', 'veronika'), $breadcrumb);
?>

<?php if( $breadcrumb != '' && !osc_is_search_page()) { ?>
  <div class="breadcrumb">
    <div class="bread-home"><i class="fa fa-home"></i></div><?php echo $breadcrumb; ?>

    <?php if(osc_is_ad_page() && (osc_item_field('i_condition') <> '' || osc_item_field('i_transaction') <> '')) { ?>
      <div class="status-line">
        <?php if(osc_item_field('i_condition') <> '') { ?>
          <div class="condition"><?php _e('Condition', 'veronika'); ?>: <span><?php echo (osc_item_field('i_condition') == 1 ? __('New', 'veronika') : __('Used', 'veronika')); ?></span></div>
        <?php } ?>

        <?php if(osc_item_field('i_transaction') <> '') { ?>
          <?php
            $id = osc_item_field('i_transaction');

            if ($id == 1) {
              $transaction = __('Sell', 'veronika');
            } else if ($id == 2) {
              $transaction = __('Buy', 'veronika');
            } else if ($id == 3) {
              $transaction = __('Rent', 'veronika');
            } else if ($id == 4) {
              $transaction = __('Exchange', 'veronika');
            }
          ?>

          <div class="transaction"><?php _e('Transaction', 'veronika'); ?>: <span><?php echo $transaction; ?></span></div>
        <?php } ?>
      </div>
    <?php } ?>

    <?php if(osc_is_ad_page()) { ?>
      <div class="bread-stats clicks" title="<?php _e('Shows how many times was seller contacted by phone', 'veronika'); ?>">
        <img src="<?php echo osc_current_web_theme_url(); ?>images/item-stat-phone-clicks.png"/>
        <div class="block">
          <div class="top"><?php echo veronika_phone_clicks(osc_item_id()); ?>x</div>
          <div class="bottom"><?php _e('calls', 'veronika'); ?></div>
        </div>
      </div>

      <div class="bread-stats views" title="<?php _e('Shows how many times was listing viewed', 'veronika'); ?>">
        <img src="<?php echo osc_current_web_theme_url(); ?>images/item-stat-views.png"/>
        <div class="block">
          <div class="top"><?php echo osc_item_views(); ?>x</div>
          <div class="bottom"><?php _e('views', 'veronika'); ?></div>
        </div>
      </div>
    <?php } ?>

  </div>
<?php } ?>

<?php View::newInstance()->_erase('countries'); ?>
<?php View::newInstance()->_erase('regions'); ?>
<?php View::newInstance()->_erase('cities'); ?>