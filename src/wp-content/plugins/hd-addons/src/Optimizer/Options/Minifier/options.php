<?php

$minify_html = $minify_html ?? 0;

$dns_prefetch = $dns_prefetch ?? [];
$dns_prefetch = implode( PHP_EOL, $dns_prefetch );

?>
<div class="section section-checkbox" id="section_minify_html">
	<label class="heading !block" for="minify_html"><?php _e( 'Minify HTML', ADDONS_TEXT_DOMAIN ); ?></label>
	<div class="desc">Remove unnecessary characters from your HTML output to reduce data size and improve your site's loading speed.</div>
	<div class="option">
        <div class="controls">
            <input type="checkbox" class="hd-checkbox hd-control" name="minify_html" id="minify_html" <?php checked( $minify_html, 1 ); ?> value="1">
        </div>
        <div class="explain"><?php _e( 'Check to activate', ADDONS_TEXT_DOMAIN ); ?></div>
    </div>
</div>

<div class="section section-textarea" id="section_dns_prefetch">
	<label class="heading" for="dns_prefetch"><?php _e( 'DNS Pre-fetch', ADDONS_TEXT_DOMAIN ) ?></label>
	<div class="desc">Enabling DNS pre-fetch for a domain will resolve it before resources are requested from it, resulting in faster loading of those resources.</div>
	<div class="option">
		<div class="controls">
			<textarea class="hd-textarea hd-control" name="dns_prefetch" id="dns_prefetch" rows="4"><?php echo $dns_prefetch; ?></textarea>
		</div>
	</div>
</div>
