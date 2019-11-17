<div class="httemplates-templates-area">
    <div class="httemplate-row">

        <!-- PopUp Content Start -->
        <div id="httemplate-popup-area" style="display: none;">
            <div class="httemplate-popupcontent">
                <div class='htspinner'></div>
                <div class="htmessage" style="display: none;">
                    <p></p>
                    <span class="httemplate-edit"></span>
                </div>
                <div class="htpopupcontent">
                    <p><?php esc_html_e( 'Import template to your Library', 'htmega-addons' );?></p>
                    <span class="htimport-button-dynamic"></span>
                    <div class="htpageimportarea">
                        <p> <?php esc_html_e( 'Create a new page from this template', 'htmega-addons' ); ?></p>
                        <input id="htpagetitle" type="text" name="htpagetitle" placeholder="<?php echo esc_attr_x( 'Enter a Page Name', 'placeholder', 'htmega-addons' ); ?>">
                        <span class="htimport-button-dynamic-page"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- PopUp Content End -->

        <!-- Top banner area Start -->
        <div class="httemplate-top-banner-area">
            <div class="htbanner-content">
                <div class="htbanner-desc">
                    <h3><?php esc_html_e( 'HTMega Templates Library', 'htmega-addons' ); ?></h3>
                <?php
                    $alltemplates = sizeof( HTMega_Template_Library::instance()->get_templates_info( true )['templates'] ) ? sizeof( HTMega_Template_Library::instance()->get_templates_info( true )['templates'] ) : 0;
                ?>
                <?php if( is_plugin_active('htmega-pro/htmega_pro.php') ): ?>
                    <p>
                        <?php
                            echo '<span class="httemplatesetcount"></span>'.sprintf( '%1$s %2$s %3$s', esc_html__( ' Template set &', 'htmega-addons' ), $alltemplates, esc_html__( 'Templates.', 'htmega-addons' ) );
                        ?>
                    </p>
                <?php else:?>
                    <p>
                        <?php
                            echo sprintf( '%1$s %2$s %3$s', esc_html__( '15 Templates are Free &', 'htmega-addons' ), $alltemplates, esc_html__( 'Templates are Premium.', 'htmega-addons' ) );
                        ?>
                    </p>
                <?php endif; ?>
                </div>
                <?php if( !is_plugin_active('htmega-pro/htmega_pro.php') ){ ?>
                    <a href="https://hasthemes.com/plugins/ht-mega-pro/" target="_blank"><?php esc_html_e( 'Buy HTMega Pro Version', 'htmega-addons' );?></a>
                <?php } ?>
            </div>
        </div>
        <!-- Top banner area end -->

        <?php if( HTMega_Template_Library::instance()->get_templates_info( true )['templates'] ): ?>
            
            <div class="htmega-topbar">
                <span id="htmegaclose">&larr; <?php esc_html_e( 'Back to Library', 'htmega-addons' ); ?></span>
                <h3 id="htmega-tmp-name"></h3>
            </div>

            <ul id="tp-grid" class="tp-grid">

                <?php foreach ( HTMega_Template_Library::instance()->get_templates_info( true )['templates'] as $httemplate ): 
                    
                    $allcat = explode( ' ', $httemplate['category'] );

                    $htimp_btn_atr = [
                        'templpateid' => $httemplate['id'],
                        'templpattitle' => $httemplate['title'],
                        'message' => esc_html__( 'Successfully '.$httemplate['title'].' has been imported.', 'htmega-addons' ),
                        'htbtnlibrary' => esc_html__( 'Import to Library', 'htmega-addons' ),
                        'htbtnpage' => esc_html__( 'Import to Page', 'htmega-addons' ),
                    ];

                ?>

                    <li data-pile="<?php echo esc_attr( implode(' ', $allcat ) ); ?>">
                        <div class="htsingle-templates-laibrary">
                            <div class="httemplate-thumbnails">
                                <img src="<?php echo esc_url( $httemplate['thumbnail'] ); ?>" alt="<?php echo esc_attr( $httemplate['title'] ); ?>">
                                <div class="httemplate-action">
                                    <?php if( $httemplate['is_pro'] == 1 ):?>
                                        <a href="https://hasthemes.com/plugins/ht-mega-pro/" target="_blank">
                                            <?php esc_html_e( 'Buy Now', 'htmega-addons' ); ?>
                                        </a>
                                    <?php else:?>
                                        <a href="#" class="httemplateimp" data-templpateopt='<?php echo wp_json_encode( $htimp_btn_atr );?>' >
                                            <?php esc_html_e( 'Import', 'htmega-addons' ); ?>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo esc_url( $httemplate['demourl'] ); ?>" target="_blank"><?php esc_html_e( 'Preview', 'htmega-addons' ); ?></a>
                                </div>
                            </div>
                            <div class="httemplate-content">
                                <h3><?php echo esc_html__( $httemplate['title'], 'htmega-addons' ); if( $httemplate['is_pro'] == 1 ){ echo ' <span>( '.esc_html__('Pro','htmega-addons').' )</span>'; } ?></h3>
                                <div class="httemplate-tags">
                                    <?php echo implode( ' / ', explode( ',', $httemplate['tags'] ) ); ?>
                                </div>
                            </div>
                        </div>
                    </li>

                <?php endforeach; ?>

            </ul>

            <script type="text/javascript">
                jQuery(document).ready(function($) {

                    $(function() {
                        var $grid = $( '#tp-grid' ),
                            $name = $( '#htmega-tmp-name' ),
                            $close = $( '#htmegaclose' ),
                            $loaderimg = '<?php echo HTMEGA_ADDONS_PL_URL . 'admin/assets/images/ajax-loader.gif'; ?>',
                            $loader = $( '<div class="htmega-loader"><span><img src="'+$loaderimg+'" alt="" /></span></div>' ).insertBefore( $grid ),
                            stapel = $grid.stapel( {
                                onLoad : function() {
                                    $loader.remove();
                                },
                                onBeforeOpen : function( pileName ) {
                                    $( '.htmega-topbar,.httemplate-action' ).css('display','flex');
                                    $( '.httemplate-content span' ).css('display','inline-block');
                                    $close.show();
                                    $name.html( pileName );
                                },
                                onAfterOpen : function( pileName ) {
                                    $close.show();
                                }
                            } );
                        $close.on( 'click', function() {
                            $close.hide();
                            $name.empty();
                            $( '.htmega-topbar,.httemplate-action,.httemplate-content span' ).css('display','none');
                            stapel.closePile();
                        } );
                    } );

                });
            </script>
        <?php endif; ?>

    </div>
</div>