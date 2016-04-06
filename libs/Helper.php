<?php

namespace Novius\SoundCloud;

class Helper
{
	/**
	 * Retourne le trackID à partir d'une url SoundCloud
	 *
	 * @param string    $url    url SoundCloud (avec un path)
	 *
	 * @return int|null
	 * @throws \Exception       si url non valide.
	 */
	public static function urlToTrackId($url)
	{
		// L'url doit être valide et avoir un path
		if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) === false) {
			throw new \Exception('ERROR urlToTrackId : '.$url.' n\'est pas une url valide.');
		}

		// La balise <meta property="al:android:url"> contient le trackID
		$metas = static::getMetaProperties($url);

		$urlProp = 'al:android:url';
		if (empty($metas[$urlProp])) {
			return null;
		}

		$e = explode(':', $metas[$urlProp]);
		$trackID = end($e);
		if (!ctype_digit($trackID)) {
			return null;
		}

		return (int) $trackID;
	}

	/**
	 * Retourne l'embed à partir d'un trackID
	 *
	 * @param int       $trackID
	 *
	 * @return string
	 */
	public static function trackIdToEmbed($trackID)
	{
		return '<iframe width="100%" height="190" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.(int)$trackID.'&amp;auto_play=true&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false&amp;visual=false"></iframe>';
	}

	/**
	 * Retourne les <meta property="xx">
	 * (là où get_meta_tags() retourne uniquement les <meta name="xx">
	 *
	 * @param string    $url
	 *
	 * @return array
	 */
	protected static function getMetaProperties($url)
	{
		libxml_use_internal_errors(true);
		ini_set('user_agent', 'Mozilla/5.0');

		$dom = new \DOMDocument();
		$dom->loadHTMLFile($url);

		$metaData = array();
		foreach ($dom->getElementsByTagName('meta') as $meta) {
			$metaData[$meta->getAttribute('property')] = $meta->getAttribute('content');
		}

		return $metaData;
	}
}