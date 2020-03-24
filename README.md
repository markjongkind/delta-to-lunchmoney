
# Delta to Lunch Money
Update your cryptocurrency portfolio balance from [Delta](https://delta.app/) to [Lunch Money](https://lunchmoney.app/)

## Usage

### Configuration settings
In order to start syncing transactions to Lunch Money, please update the `config.php` file.

```php
// In the Delta app, open the portfolio you would like to sync
// Click on the 3 dots to the top right and click on 'My Delta Link'
// Follow the guide to create a shareable link to your portfolio
// https://support.delta.app/en/articles/2856286-how-can-i-share-a-single-portfolio
deltaSharedPortfolioHashedId = '[YOUR DELTA SHARED PORTFOLIO HASHED ID]';
```
```php
// Visit https://my.lunchmoney.app/developers to request an access token
lunchMoneyAccessToken = '[YOUR LUNCH MONEY ACCESS TOKEN]';
```
```php
// The asset ID of your Lunch Money cryptocurrency account
// Run index.php to see a list of your Lunch Money accounts and copy the ID
lunchMoneyAssetId = '[YOUR LUNCH MONEY CRYPTOCURRENCY ASSET ID]';
```
```php
// Choose to store your balance in BTC
// If false, the default currency from Delta is used (USD, EUR, etc)
lunchMoneyCurrencyBtc = true;
```

### Start cronjob
Create a cronjob to `sync.php` and every time the script runs, your Delta balance will be reconciled to your Lunch Money cryptocurrency account.