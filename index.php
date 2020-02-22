<?php

require_once __DIR__ . "/functs.php";
require_once __DIR__ . "/classes/Herald.php";

$config = [
    'word' => [1,15],
	'sentence' => [3,10],
	'paragraph' => [5,12],
];

$speaker = new Herald($config);
//debug($speaker->getConfig());
?>

<h3>Test Herald</h3>

<p> Open syllable:
	<i><b><?= $speaker->openSyllable() ?></b></i>
</p>
<p> Closed syllable:
	<i><b><?= $speaker->closedSyllable() ?></b></i>
</p>
<p> One word:
	<i><b><?= $speaker->word(true) ?></b></i>
</p>
<p> One sentence:
 <i><b><?= $speaker->sentence() ?></b></i>
</p>

<p> Paragraph: <br>
	<i>&nbsp;&nbsp;
		<b><?= $speaker->paragraph() ?></b></i>
</p>