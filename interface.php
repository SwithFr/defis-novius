<?php
require __DIR__.'/libs/Helper.php';
require_once "./libs/Model.php";
$DB = new Model();

if (isset($_GET['url'])) {
	$trackID = \Novius\SoundCloud\Helper::urlToTrackId($_GET['url']);
	if ($trackID) {
		$embed = \Novius\SoundCloud\Helper::trackIdToEmbed($trackID);
	}
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>YEAH</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/foundation/6.2.0/foundation.min.css">
	<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="">
	<div class="row">
		<div class="columns">
			<h2>Add Sound</h2>
			<div class="addbox">
				<div class="row">
					<div class="large-12 columns">
						<form action="<?= $_REQUEST["PHP_SELF"]; ?>?user=<?= $_GET['user']; ?>" method="get">
							<input name="url" type="text" placeholder="Url">
							<div class="row">
								<div class="large-2 columns">
									<input name="duration" type="text" placeholder="Durée (secondes)">
								</div>
								<div class="large-2 columns">
									<select name="category" title="Categorie">
										<option>Catégorie</option>
										<option>Rock</option>
										<option>Rap</option>
									</select>
								</div>
								<div class="large-2 columns">
									<input type="submit" class="button small large-12" value="Add"/>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="columns">
			<h2>Player</h2>
			<?= isset($embed) ? $embed : 'Rentrer une URL soundcloud valdie please' ?>
			Son proposé par <?= $_GET['user'] ?>.
		</div>
	</div>
	<div class="row">
		<div class="columns">
			<h2>Stats</h2>

			<h3>Top 5 des auteurs</h3>
			<ul>
				<?php
					$top = $DB->getTopAuthors();
				?>
				<?php foreach($top as $author): ?>
				    <li>
					    <?= $author["auth_pseudo"] ?> (<?= $author["total"] ?>)
				    </li>
				<?php endforeach; ?>
			</ul>

			<h3>Nombre de chansons par catégorie</h3>
			<ul>
				<?php
				$topCat = $DB->getTopCat();
				?>
				<?php foreach($topCat as $cat): ?>
					<li>
						<?= $cat["cat_label"] ?> (<?= $cat["total"] ?>)
					</li>
				<?php endforeach; ?>
			</ul>

			<h3>Durée totale des chansons uploadées ces 2 dernières heures</h3>

			<ul class="histogrammes">
				<li style="height: 60px">62 min</li>
				<li style="height: 82px">85 min</li>
				<li style="height: 40px">85 min</li>
				<li style="height: 45px">85 min</li>
				<li style="height: 50px">85 min</li>
				<li style="height: 60px">85 min</li>
				<li style="height: 43px">85 min</li>
				<li style="height: 18px">16 min</li>
				<li style="height: 79px">96 min</li>
				<li style="height: 18px">85 min</li>
				<li style="height: 06px">04 min</li>
				<li style="height: 52px">85 min</li>
			</ul>

			<h3>Catégorie préférée de chaque auteur</h3>
			<ul>
				<li>
					Bobby : Rock
				</li>
				<li>
					Martine : Rock
				</li>
				<li>
					Bella : Rap
				</li>
				<li>
					Justin : Rock
				</li>
				<li>
					Justine : Folk
				</li>
			</ul>
		</div>
	</div>
</div>

</body>
</html>