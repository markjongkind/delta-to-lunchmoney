<?php

/**
 * delta-to-lunchmoney
 * Delta to Lunch Money
 *
 * @author  Mark Jongkind <mark@backscreen.nl>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 *
 * delta-to-lunchmoney reconcile balance
 */

require_once(__DIR__ . '/functions.php');

echo '<h2>Delta to Lunch Money</h2>';
echo '<hr />';

$portfolio = getDeltaPortfolio(deltaSharedPortfolioHashedId);

if( lunchMoneyCurrencyBtc === true )
    $result = updateLunchMoneyAssetBalance(lunchMoneyAssetId, 'btc', $portfolio['worthInBtc']);
else
    $result = updateLunchMoneyAssetBalance(lunchMoneyAssetId, $portfolio['currency'], $portfolio['worth']);

if( $result !== false )
    echo 'Reconciled balance to: ' . $result['balance'] . ' ' . $result['currency'];

?>