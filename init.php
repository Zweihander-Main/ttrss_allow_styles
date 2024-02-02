<?php
class TTRSS_Allow_Styles extends Plugin
{
	function about()
	{
		return array(
			"1.0.0",
			"Allow styles on selected feeds",
			"zwei"
		);
	}

	public function api_version()
	{
		return 2;
	}

	private function get_stored_array($name)
	{
		$tmp = $this->host->get($this, $name);

		if (!is_array($tmp))
			$tmp = [];

		return $tmp;
	}


	private $host;

	public function init($host)
	{
		$this->host = $host;

		$host->add_hook($host::HOOK_SANITIZE, $this);
		$host->add_hook($host::HOOK_PREFS_EDIT_FEED, $this);
		$host->add_hook($host::HOOK_PREFS_SAVE_FEED, $this);
	}

	public function hook_sanitize($doc, $site_url, $allowed_elements, $disallowed_attributes, $article_id)
	{
		$enabled_feeds = $this->get_stored_array("enabled_feeds");

		$feed_id = -1;

		$sth = $this->pdo->prepare("SELECT feed_id FROM ttrss_user_entries WHERE ref_id = ? LIMIT 1");
		$sth->execute([$article_id]);
		$result = $sth->fetch();

		if ($result && isset($result['feed_id'])) {
			$feed_id = (int) $result['feed_id'];
		}

		if (in_array($feed_id, $enabled_feeds)) {
			$disallowed_attributes = array_filter($disallowed_attributes, function ($attr) {
				return $attr !== 'style';
			});
		}

		return [$doc, $allowed_elements, $disallowed_attributes];
	}

	public function hook_prefs_edit_feed($feed_id)
	{
		$enabled_feeds = $this->get_stored_array("enabled_feeds");
		?>

		<header><?= __("Styles") ?></header>
		<section>
			<fieldset>
				<label class='checkbox'>
					<?= \Controls\checkbox_tag("ttrss_allow_styles", in_array($feed_id, $enabled_feeds)) ?>
					<?= __('Allow \'styles\' attribute in feed items') ?>
				</label>
			</fieldset>
		</section>
		<?php
	}

	function hook_prefs_save_feed($feed_id)
	{
		$enabled_feeds = $this->get_stored_array("enabled_feeds");

		$enable = checkbox_to_sql_bool($_POST["ttrss_allow_styles"] ?? "");

		$enable_key = array_search($feed_id, $enabled_feeds);

		if ($enable) {
			if ($enable_key === false) {
				array_push($enabled_feeds, $feed_id);
			}
		} else {
			if ($enable_key !== false) {
				unset($enabled_feeds[$enable_key]);
			}
		}

		$this->host->set($this, "enabled_feeds", $enabled_feeds);
	}


	// TODO: create preference and hookup
}