<?php
class TTRSS_Allow_Styles extends Plugin {
    function about() {
        return array(
            "1.0.0",
            "Allow styles on selected feeds",
            "zwei");
    }

	public function api_version() {
		return 2;
	}

	private $host;

	public function init( $host ) {
		$this->host = $host;

		$host->add_hook( $host::HOOK_SANITIZE, $this );
	}

	// public function hook_article_export_feed( $line, $feed, $is_cat ) {
	// 	if ( ! in_array( $this, $this->host->get_hooks( $this->host::HOOK_SANITIZE ) ) )
	// 		$this->host->add_hook( $this->host::HOOK_SANITIZE, $this );

	// 	return $line;
	// }

	public function hook_sanitize( $doc, $site_url, $allowed_elements, $disallowed_attributes, $article_id ) {

		$disallowed_attributes = array_filter( $disallowed_attributes, function( $attr ) {
			return $attr !== 'style';
		} );

		return [ $doc, $allowed_elements, $disallowed_attributes ];
	}

}