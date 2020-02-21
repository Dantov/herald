<?php
function debug( $arr, $str = false , $die = 0)
{
    echo '<pre>';
    if ( $str ) echo $str . ' = ';
    print_r( $arr );
    echo '</pre>';

    if ( $die ) die;
}

require_once __DIR__ . "/classes/Herald.php";

$config = [
    'word'=>[1,1]
];

$speaker = new Herald($config);

echo $speaker->openSyllable();
echo "<br>";
echo $speaker->closedSyllable();

echo "<br>";
echo $speaker->word(true);
echo "<br>";
echo $speaker->sentence();
echo "<br>";
echo $speaker->paragraph();

echo "<h4>".$speaker->text()."</h4>";