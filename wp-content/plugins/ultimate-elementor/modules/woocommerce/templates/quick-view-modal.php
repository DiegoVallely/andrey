<?php
/**
 * WooCommerce - Quick View Modal
 *
 * @package UAEL
 */

?>
<div class="uael-quick-view-<?php echo $widget_id; ?>">
	<div class="uael-quick-view-bg"><div class="uael-quick-view-loader"></div></div>
	<div id="uael-quick-view-modal">
		<div class="uael-content-main-wrapper"><?php /*Don't remove this html comment*/ ?><!--
		--><div class="uael-content-main">
				<div class="uael-lightbox-content">
					<div class="uael-content-main-head">
						<a href="#" id="uael-quick-view-close" class="uael-quick-view-close-btn fa fa-close"></a>
					</div>
					<div id="uael-quick-view-content" class="woocommerce single-product"></div>
				</div>
			</div>
		</div>
	</div>
</div>
