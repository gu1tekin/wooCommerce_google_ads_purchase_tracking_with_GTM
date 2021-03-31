<?php
/**
 * @snippet       WooCommerce Google Ads Purchase Tracking with gtag.js
 * @author        Gultkein Cirik
 * @Compatible    WooCommerce 2.6.14  or Newer AND WordPress 4.1.1 or Newer
 */


// Implementing the GTM container <script> to <head>
add_action('wp_head', 'add_gtm_container_script');
    function add_gtm_container_script(){ ?>
		<!-- Google Tag Manager -->
		<script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-XXXX');
        </script>
		<!-- End Google Tag Manager -->
  <?php } 

// Implementing the GTM container <noscript> to <body>
add_action('wp_body_open', 'add_gtm_noscript');
     function add_gtm_noscript(){ ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXX"
        height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
<?php } 

// Implementing dataLeyer for Google Ads Purchase Conversion traking to Order Confirmation Page
add_action('woocommerce_thankyou', 'ads_purchase_tracking');
    function ads_purchase_tracking($order_id){
	   $order = new WC_Order($order_id);
	   $currency = $order->get_order_currency();
	   $total = $order->get_total(); ?>
        <script>
			dataLayer.push({
			  'conversionValue': <?php echo $total ?>,
			  'currency': '<?php echo $currency ?>',
			  'transactionId': '<?php echo $order_id ?>',
			  'event': 'orderTrackingAdsConversion' //event for trigger
			});
		</script>
<?php }