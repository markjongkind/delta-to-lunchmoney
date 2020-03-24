<?php

/**
 * delta-to-lunchmoney
 * Delta to Lunch Money
 *
 * @author  Mark Jongkind <mark@backscreen.nl>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 *
 * delta-to-lunchmoney
 */

require_once(__DIR__ . '/functions.php');

echo '<h2>Delta to Lunch Money</h2>';
echo '<hr />';

$cryptocurrencyAssets = listLunchMoneyCryptocurrencyAssets();

echo '<table><tr><th>Account ID</th><th>Description</th><th>Institution</th></tr>';

foreach($cryptocurrencyAssets as $asset) 
{
    echo '<tr><td><code>' . $asset['id'] . '</code></td><td>' . $asset['name'] . '</td><td>' . $asset['institution_name'] . '</td></tr>';
}

echo '</table>';

?>