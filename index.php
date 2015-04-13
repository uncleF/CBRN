<!DOCTYPE HTML>

<html lang="en">
	<head>
		<title>CBRN</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>

		<?php

			$INDEX = 0;
			$COMICS_DIRECTORY = opendir("./comics/");
			while($COMIC_ISSUE_DIRECTORY = readdir($COMICS_DIRECTORY)) {
				if ($COMIC_ISSUE_DIRECTORY != '.' && $COMIC_ISSUE_DIRECTORY != '..') {
					$COMICS[$INDEX] = $COMIC_ISSUE_DIRECTORY;
					$INDEX++;
				}
			}
			sort ($COMICS);
			for ($INDEX = 0; $INDEX < sizeof($COMICS); $INDEX++) {
				$COMIC_ISSUE = opendir("./comics/" . $COMICS[$INDEX] . "/");
				$PAGES = 0;
				while($PAGE = readdir($COMIC_ISSUE)) {
					if ($PAGE != '.' && $PAGE != '..') {
						$PAGES++;
					}
				}
				$COMIC_ISSUE = opendir("./comics/" . $COMICS[$INDEX] . "/");
				$PAGE_NUMBER = 0;
				mkdir("./comics/" . $COMICS[$INDEX] . "/renamed/");
				while($PAGE = readdir($COMIC_ISSUE)) {
					if ($PAGE != '.' && $PAGE != '..' && $PAGE != 'renamed') {
						$SIZE = GetImageSize("./comics/" . $COMICS[$INDEX] . "/" . $PAGE);
						if ($SIZE[0] > $SIZE[1]) {
							$NEXT_PAGE_NUMBER = $PAGE_NUMBER + 1;
							if ($NEXT_PAGE_NUMBER < 10) {
								if ($PAGES >= 100) {
									$PAGE_NUMBER_STRING = "00" . $PAGE_NUMBER . " - 00" . $NEXT_PAGE_NUMBER;
								} else {
									$PAGE_NUMBER_STRING = "0" . $PAGE_NUMBER . " - 0" . $NEXT_PAGE_NUMBER;
								}
							}
							else if ($NEXT_PAGE_NUMBER > 9 && $PAGE_NUMBER <= 9) {
								if ($PAGES >= 100) {
									$PAGE_NUMBER_STRING = "00" . $PAGE_NUMBER . " - 0" . $NEXT_PAGE_NUMBER;
								} else {
									$PAGE_NUMBER_STRING = "0" . $PAGE_NUMBER . " - " . $NEXT_PAGE_NUMBER;
								}
							}
							else {
								if ($PAGES >= 100) {
									if ($NEXT_PAGE_NUMBER < 100) {
										$PAGE_NUMBER_STRING = "0" . $PAGE_NUMBER . " - 0" . $NEXT_PAGE_NUMBER;
									} else if ($NEXT_PAGE_NUMBER > 99 && $PAGE_NUMBER <= 99) {
										$PAGE_NUMBER_STRING = "0" . $PAGE_NUMBER . " - " . $NEXT_PAGE_NUMBER;
									} else {
										$PAGE_NUMBER_STRING = $PAGE_NUMBER . " - " . $NEXT_PAGE_NUMBER;
									}
								} else {
									$PAGE_NUMBER_STRING = $PAGE_NUMBER . " - " . $NEXT_PAGE_NUMBER;
								}
							}
							$PAGE_NUMBER++;
						} else {
							if ($PAGE_NUMBER <= 9) {
								if ($PAGES >= 100) {
									$PAGE_NUMBER_STRING = "00" . $PAGE_NUMBER;
								} else {
									$PAGE_NUMBER_STRING = "0" . $PAGE_NUMBER;
								}
							}
							else {
								if ($PAGES >= 100) {
									if ($NEXT_PAGE_NUMBER < 100) {
										$PAGE_NUMBER_STRING = "0" . $PAGE_NUMBER;
									} else {
										$PAGE_NUMBER_STRING = $PAGE_NUMBER;
									}
								} else {
									$PAGE_NUMBER_STRING = $PAGE_NUMBER;
								}
							}
						}
						$NEW_PAGE_NAME = $COMICS[$INDEX] . " - " . $PAGE_NUMBER_STRING . ".jpg";
						rename("./comics/" . $COMICS[$INDEX] . "/" . $PAGE, "./comics/" . $COMICS[$INDEX] . "/renamed/" . $NEW_PAGE_NAME);
						$PAGE_NUMBER++;
					}
				}
				$COMIC_ISSUE = opendir("./comics/" . $COMICS[$INDEX] . "/renamed/");
				while($PAGE = readdir($COMIC_ISSUE)) {
					if ($PAGE != '.' && $PAGE != '..') {
						rename("./comics/" . $COMICS[$INDEX] . "/renamed/" . $PAGE, "./comics/" . $COMICS[$INDEX] . "/" . $PAGE);
						$PAGE_NUMBER++;
					}
				}
				rmdir("./comics/" . $COMICS[$INDEX] . "/renamed/");
				$COMIC_ISSUE = opendir("./comics/" . $COMICS[$INDEX] . "/");
				echo "<b>" . $COMICS[$INDEX] . "</b><br>";
				while($PAGE = readdir($COMIC_ISSUE)) {
					if ($PAGE != '.' && $PAGE != '..' && $PAGE != 'renamed') {
						$SIZE = GetImageSize("./comics/" . $COMICS[$INDEX] . "/" . $PAGE);
						if (($SIZE[0] / $SIZE[1]) > 1.4 && $SIZE[1] < $SIZE[0]) {
							echo "<span style='color: red'>" . $PAGE  . "</span><br>";
						}
					}
				}
				echo "<hr><br><br>";
			}
			echo "Done.";

		?>

	</body>
</html>