<?php

/**
 * delta-to-lunchmoney
 * Delta to Lunch Money
 *
 * @author  Mark Jongkind <mark@backscreen.nl>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 *
 * delta-to-lunchmoney functions
 */

require_once(__DIR__ . '/config.php');

/**
 * Get Delta cryptocurrency portfolio
 */
function getDeltaPortfolio($sharedPortfolioHashedId)
{
    try 
    {
        if( !$sharedPortfolioHashedId )
            throw new Exception("Set Delta sharedPortfolioHashedId in configuration", 1);

        $json_array = [
            'sharedPortfolioHashedId' => $sharedPortfolioHashedId,
            'portfolioPeriod' => '1D'
        ]; 

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, deltaApiUrl . '/shared-portfolio');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_array));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
        ]);
        $response = curl_exec($ch);

        if (!$response)
            throw new Exception('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch), 1);

        curl_close($ch);

        $response_array = json_decode($response, true);
        
        return [
            'currency' => strtolower($response_array['currency']),
            'worth' => $response_array['portfolio']['balance']['worth'],
            'worthInBtc' => $response_array['portfolio']['balance']['worthInBtc']
        ];
    }
    catch (Exception $e) 
    {
        echo 'Delta error: ' . $e->getMessage();
        return false;
    }
}

/**
 * List Lunch Money cryptocurrency assets
 */
function listLunchMoneyCryptocurrencyAssets()
{
    try 
    {
        $cryptocurrencyAssets = [];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, lunchMoneyApiUrl . '/assets');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ 
            'Authorization: Bearer ' . lunchMoneyAccessToken,
        ]);
        $response = curl_exec($ch);

        if (!$response)
            throw new Exception('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch), 1);

        $response_array = json_decode($response, true);

        if( isset($response_array['name']) && $response_array['name'] === 'Error' )
            throw new Exception($response_array['message'], 1);

        curl_close($ch);

        foreach($response_array['assets'] as $asset) 
        {
            if( $asset['type_name'] === 'cryptocurrency' )
                array_push($cryptocurrencyAssets, $asset);
        }

        return $cryptocurrencyAssets;
    }
    catch (Exception $e) 
    {
        echo 'Lunch Money error: ' . $e->getMessage();
        return false;
    }
}

/**
 * Update Lunch Money asset balance
 */
function updateLunchMoneyAssetBalance($assetId, $currency, $balance)
{
    try 
    {
        if( !$assetId )
            throw new Exception("Set Lunch Money asset ID in configuration", 1);

        if( !$currency )
            throw new Exception("Currency is not set", 1);

        if( !$balance )
            throw new Exception("Balance is not set", 1);

        $json_array = [
            'currency' => $currency,
            'balance' => strval($balance)
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, lunchMoneyApiUrl . '/assets/' . $assetId);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_array));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . lunchMoneyAccessToken,
            'Content-Type: application/json; charset=utf-8',
        ]);
        $response = curl_exec($ch);

        if (!$response)
            throw new Exception('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch), 1);

        $response_array = json_decode($response, true);

        if( isset($response_array['name']) && $response_array['name'] === 'Error' )
            throw new Exception($response_array['message'], 1);

        if( isset($response_array['name']) && $response_array['name'] === 'ValidateError' )
            throw new Exception($response_array['message'], 1);

        curl_close($ch);

        return $response_array;
    }
    catch (Exception $e) 
    {
        echo 'Lunch Money error: ' . $e->getMessage();
        return false;
    }
}

?>