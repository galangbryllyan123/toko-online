<br /><div align="center"><?php osc_show_widgets('footer'); ?></div><footer class="footer"> 
            <meta itemprop="name">            <link itemprop="url">            <link itemprop="logo">            <div class="container">
                
                <div class="col ">
                    <h6><?php _e("Pages"); ?></h6>
                    <ul class="dept-stats">
                        <li class="active-dept"><span class="dept"><a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact us', 'wayst'); ?></a></span></li>
                        
                        <?php osc_reset_static_pages(); ?>
        <?php while( osc_has_static_pages() ) { ?>
            <li> <a href="<?php echo osc_static_page_url(); ?>"><span class="dept"><?php echo osc_static_page_title(); ?></span></a></li>
        <?php } ?>
                        
                  </ul>
                </div>
                <div class="col">
                <?php if (osc_get_preference('footer-partners', 'wayst')){ echo '<h6>' .osc_get_preference('footer-partners', 'wayst'). " <i class='fa fa-external-link' aria-hidden='true'></i></h6>";} else { echo '<h6>Partners <i class="fa fa-external-link" aria-hidden="true"></i></h6>'; } ?>
                    
                    <ul>
                        <?php if (osc_get_preference('footer-partners1', 'wayst')){ echo '<li><a target="_blank" href="'.osc_get_preference('footer-partnersl1', 'wayst').'">' .osc_get_preference('footer-partners1', 'wayst'). "</a></li>";} else { echo '<li><a target="_blank" href="http://waitaraweb,com/">www.WaitaraWeb.com</a>
</li>'; } ?>
                  <?php if (osc_get_preference('footer-partners2', 'wayst')){ echo '<li><a target="_blank" href="'.osc_get_preference('footer-partnersl2', 'wayst').'">' .osc_get_preference('footer-partners2', 'wayst'). "</a></li>";} else { echo '<li><a target="_blank" href="http://themehelp.us/">www.themehelp.us</a>
</li>'; } ?>
                  <?php if (osc_get_preference('footer-partners3', 'wayst')){ echo '<li><a target="_blank" href="'.osc_get_preference('footer-partnersl3', 'wayst').'">' .osc_get_preference('footer-partners3', 'wayst'). "</a></li>";} else { echo '<li><a target="_blank" href="http://wordpressthemes.xyz">www.wordpressthemes.xyz</a></li>'; } ?>
                  <?php if (osc_get_preference('footer-partners4', 'wayst')){ echo '<li><a target="_blank" href="'.osc_get_preference('footer-partnersl4', 'wayst').'">' .osc_get_preference('footer-partners4', 'wayst'). "</a></li>";} else { echo '<li><a target="_blank" href="http://musicmd.org">www.musicmd.org</a></li>'; } ?>
                  <?php if (osc_get_preference('footer-partners5', 'wayst')){ echo '<li><a target="_blank" href="'.osc_get_preference('footer-partnersl5', 'wayst').'">' .osc_esc_html(osc_get_preference('footer-partners5', 'wayst')). "</a></li>";} else { echo '<li><a target="_blank" href="http://stackoverflow.com/">www.stackoverflow.com</a>
</li>'; } ?>
                  <?php if (osc_get_preference('footer-partners6', 'wayst')){ echo '<li><a target="_blank" href="'.osc_get_preference('footer-partnersl6', 'wayst').'">' .osc_get_preference('footer-partners6', 'wayst'). "</a></li>";} else { echo '<li><a target="_blank" href="http://paypal.com/">www.paypal.com</a>
</li>'; } ?>                    </ul>
                   
                </div> <div class="col col-help">
                
                <?php if ( osc_count_web_enabled_locales() > 1 ) { echo ('');} else { echo '<h6> '.osc_esc_html(__('Language:', 'wayst')) . "</h6>";} ?> <?php if ( osc_count_web_enabled_locales() > 1 ) { echo ('');} else { echo '<ul>
                    <li> ' . osc_esc_html(osc_locale_name()); "</li></ul>";} ?>
                    
                                <?php if ( osc_count_web_enabled_locales() > 1) { ?>
            <?php osc_goto_first_locale(); ?>
            <h6><?php _e('Language:', 'wayst'); ?></h6>
            
            <ul>
            <?php while ( osc_has_web_enabled_locales() ) { ?>
                    <li><a  id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a></li><?php } ?></ul><?php } ?>
            
            
                
                   
                    
                </div>
                <div class="col">
                    <h6>Social</h6>
                    <ul class="social">
                         <li> <?php if( osc_get_preference('facebook-top', 'wayst') != '') {?><a target='_blank' href="<?php echo osc_esc_html(osc_get_preference('facebook-top', 'wayst')); ?>"> <i class="fa fa-facebook-official fa-lg" style="color:#006699" aria-hidden="true"></i> </a>
                    <?php } else { ?> <a target='_blank' href="javascript:;"><i class="fa fa-facebook-official fa-lg" style="color:#006699" aria-hidden="true"></i> </a> <?php } ?> </li>
                    <li> <?php if( osc_get_preference('twitter-top', 'wayst') != '') {?><a target='_blank' href="<?php echo osc_get_preference('twitter-top', 'wayst'); ?>"> <i class="fa fa-twitter fa-lg" style="color:#00CCFF" aria-hidden="true"></i>
  </a> <?php } else { ?><a target='_blank' href="javascript:;"> <i class="fa fa-twitter fa-lg" style="color:#00CCFF" aria-hidden="true"></i>
  </a> <?php } ?>  </li>
                    <li> <?php if( osc_get_preference('google-plus-top', 'wayst') != '') {?><a target='_blank' href="<?php echo osc_get_preference('google-plus-top', 'wayst'); ?>"><i class="fa fa-google-plus fa-lg" style="color:#CC2020" aria-hidden="true"></i>
  </a> <?php } else { ?> <a target='_blank' href="javascript:;"><i class="fa fa-google-plus fa-lg" style="color:#CC2020" aria-hidden="true"></i>
  </a> <?php } ?> </li><div class="clearfix"></div>
                    <li> <?php if( osc_get_preference('email-top', 'wayst') != '') {?> <a target='_blank' href="mailto:<?php echo osc_esc_html(osc_get_preference('email-top', 'wayst')); ?>"> <i class="fa fa-envelope-o fa-lg" style="color:#99CC99" aria-hidden="true"></i>
  </a> <?php } else { ?> <a target='_blank' href="javascript:;"> <i class="fa fa-envelope-o fa-lg" style="color:#99CC99" aria-hidden="true"></i>
  </a> <?php } ?> </li>
                    <li> <?php if( osc_get_preference('skype-top', 'wayst') != '') {?> <a target='_blank' href="skype:<?php echo osc_get_preference('skype-top', 'wayst'); ?>"> <i class="fa fa-skype fa-lg" style="color:#00AFF0" aria-hidden="true"></i>
  </a> <?php } else { ?> <a target='_blank' href="javascript:;"> <i class="fa fa-skype fa-lg" style="color:#00AFF0" aria-hidden="true"></i>
  </a> <?php } ?> </li>
                     
  <li> <?php if( osc_get_preference('youtube-top', 'wayst') != '') {?><a target='_blank' href="<?php echo osc_get_preference('youtube-top', 'wayst'); ?>"> <i class="fa fa-youtube fa-lg"n style="color:#FF0000" aria-hidden="true"></i>
  </a> <?php } else { ?> <a target='_blank' href="javascript:;"> <i class="fa fa-youtube fa-lg" style="color:#FF0000" aria-hidden="true"></i>
  </a> <?php } ?> </li>
                        
                    </ul>
                    
                        
                                    </div>
            </div><div class="clearfix"></div>
            <div class="container text-center">
                &copy; <a class="" href="<?php echo osc_base_url(); ?>"><?php echo osc_page_title(); ?></a></strong> - <a class="" href="<?php echo osc_contact_url(); ?>"><?php _e('Contact us', 'wayst'); ?></a>. <?php
            if( osc_get_preference('footer_link', 'wayst') ) {
                echo '  ' . __('Powered by <a class="link_primary txt_underline" title="Osclass web" href="http://osclass.org/">Osclass.org</a>.', 'wayst');
            }
        ?> Friends: <a class="link_primary txt_underline" title="WordPress Themes" href="http://themehelp.us/">ThemeHelp.Us</a> <br>
            </div>
            <div align="center"><?php osc_show_widgets('footer') ; ?></div>
                    </footer>
                                <script src="<?php echo osc_current_web_theme_url('script/jquery-1.11.1.min.js'); ?>"></script>
                        <script src="<?php echo osc_current_web_theme_url('script/wayst-combo.js'); ?>"></script>
                            <script>
                var deptSlug = '/1';

                var searchResult = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: deptSlug + '/typeahead/%QUERY',
                        wildcard: '%QUERY'
                    }
                });

                $(document).ready(function() {
                    $('#search').typeahead({
                        minLength: 3,
                        hint: true,
                        highlight: true
                    }, {
                        name: 'search',
                        display: 'value',
                        source: searchResult,
                        limit: 20,
                        templates: {
                            suggestion: function (data) {
                                return '<div class="tt-row">' +
                                            '<span class="tt-value">' + data.value + '</span>' +
                                            '<span class="tt-count">' + data.count + ' results</span>' +
                                            '<span class="tt-dept">' + data.dept + '</span>'+
                                       '</div>';
                            }
                        }
                    }).bind('typeahead:select', function(e, suggestion) {
                        $('#search-dept').val(suggestion.slug);
                        $('#search-form').submit();
                    });

                    $('#search-dept').change(function(e){
                        var deptID = $(e.target).find('option:selected').attr('data-deptid');
                        deptSlug = (deptID) ? '/' + deptID : '';
                        searchResult.remote.url = deptSlug + '/typeahead/%QUERY';
                        var searchElem = $('#search');
                        var searchText = searchElem.val();
                        searchElem.val('').typeahead('val', '').typeahead('val', searchText).trigger('input');
                    });
                });
            </script>
                        <script>
            var globalQuickBrowse = {"ProductIDs":[,,,,,,,,,,,,,],"Current":0,"Results":32,"Offset":0,"Params":""};

            function quickView(index) {
                if (index >= 0 && index < globalQuickBrowse.ProductIDs.length) {
                    globalQuickBrowse.Current = index;
                }
                if (index >= globalQuickBrowse.ProductIDs.length && index < globalQuickBrowse.Results) {
                    quickFetch(index);
                }
                if (index < 0 && globalQuickBrowse.Offset > 0) {
                    quickFetch(index);
                    return;
                }

                var id = globalQuickBrowse.ProductIDs[globalQuickBrowse.Current];
                if (id) {
                    var url = encodeURI('/product-quick/' + id);
                    var quickModal = $('#quick-modal');
                    if (quickModal.hasClass('in')) {
                        $('#quick-frame').attr('src', url);
                    } else {
                        quickModal.modal('show');
                        var theFrame = '<iframe src="' + url + '" id="quick-frame"></iframe>';
                        $('#quick-modal-body').html(theFrame);
                    }
                }
                var itemNumber = globalQuickBrowse.Offset + globalQuickBrowse.Current + 1;
                var urlDetails = '/quick/' + globalQuickBrowse.ProductIDs[globalQuickBrowse.Current] + '-' + itemNumber;
                $('#quick-btn-details').attr('href', urlDetails);
                $('#quick-btn-details-new').attr('href', urlDetails);
                $('#quick-btn-left').prop('disabled', (globalQuickBrowse.Current == 0 && globalQuickBrowse.Offset == 0));
                $('#quick-btn-right').prop('disabled', (itemNumber == globalQuickBrowse.Results));
                $('#quick-item-no').text('Item ' + itemNumber + ' of ' + globalQuickBrowse.Results.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                if (history.replaceState) {
                    history.replaceState('', '', '#item=' + itemNumber);
                }
            }

            function quickItem(itemNumber) {
                quickView(itemNumber - globalQuickBrowse.Offset - 1);
            }

            function quickFetch(index) {
                var defaultPageSize = parseInt('15');
                var pageSize = (index < 0 && globalQuickBrowse.Offset > 0) ? Math.min(globalQuickBrowse.Offset, defaultPageSize) : defaultPageSize;
                var offset = (index < 0) ? globalQuickBrowse.Offset - pageSize : globalQuickBrowse.Offset + globalQuickBrowse.ProductIDs.length;
                var url = '/search?json=ids&jsonPageSize=' + pageSize + '&offset=' + offset + '&params=' + globalQuickBrowse.Params;
                $.getJSON(url, function(data) {
                    if (index < 0) {
                        globalQuickBrowse.ProductIDs = data.concat(globalQuickBrowse.ProductIDs);
                        globalQuickBrowse.Current = data.length + index;
                        globalQuickBrowse.Offset = Math.max(offset, 0);
                    } else {
                        globalQuickBrowse.ProductIDs = globalQuickBrowse.ProductIDs.concat(data);
                        globalQuickBrowse.Current = index;
                    }
                    if (data.length) {
                        quickView(globalQuickBrowse.Current);
                    }
                })
            }

            function setLayout(theClass) {
                var layout = $('#search-layout');
                layout.removeClass('list');
                layout.removeClass('grid');
                layout.addClass(theClass);
                $.removeCookie('layout', {path: '/'});
                if (theClass != 'grid') {
                    $.cookie('layout', theClass, {expires: 30, path: '/'});
                }
            }
            function sortSearchResults() {
                $('#sort-form').submit();
            }

            function toggleMore(id) {
                $('#'+id).toggleClass('hidden');
                var toggleElem = $('#toggle-'+id);
                if (toggleElem.html() == '+') {
                    toggleElem.html('-');
                } else {
                    toggleElem.html('+');
                }
            }

            $(document).ready(function() {
                $('#options-button').click(function() {
                    $('#search-options').toggleClass('hidden');
                });

                $('[data-toggle="tooltip"]').tooltip({
                    animation: false,
                    container: 'body',
                    placement: 'top'
                }).hover(function() {
                    var tooltip = $('.tooltip');
                    tooltip.css('top',parseInt(tooltip.css('top')) + 28 + 'px')
                });

                // show hints when facets are cut off
                if ($(window).width() < 1183) {
                    var facets = $('.facets');
                    var maxWidth = facets.width() - 58;
                    facets.find('.label').each(function() {
                        var $this = $(this);
                        if ($this.width() > maxWidth) {
                            $this.attr('title', $this.text());
                        }
                    });
                }

                // quick view events
                var quickBrowseButton = $("#quick-browse");
                                    quickBrowseButton.click(function() {
                        quickView(globalQuickBrowse.Current);
                    });
                                $('#quick-btn-left').click(function() {
                    quickView(globalQuickBrowse.Current - 1);
                });
                $('#quick-btn-right').click(function() {
                    quickView(globalQuickBrowse.Current + 1);
                });
                $('#quick-modal').keyup(function(e) {
                    if (e.which == 37) { //left
                        if (globalQuickBrowse.Current > 0) {
                            quickView(globalQuickBrowse.Current - 1);
                        }
                    }
                    if (e.which == 39) { //right
                        if (globalQuickBrowse.Current < globalQuickBrowse.Results) {
                            quickView(globalQuickBrowse.Current + 1);
                        }
                    }
                    if (e.which == 13) {
                        window.location = $('#quick-btn-details').attr('href');
                    }
                }).on('hidden.bs.modal', function() {
                    if (history.replaceState) {
                        history.replaceState('', '', window.location.pathname + window.location.search);
                    }
                });
                var hash = parseHash();
                if (hash && hash.item) {
                    quickItem(hash.item);
                }

            });

        </script>
        
      
        <script>
            // ratings events
            $('input[type=radio]').click(function() {
                $('form#starRating').submit();
            });

            $('[data-toggle="popover"]').popover();

                    </script>
                