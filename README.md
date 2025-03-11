# 📦 LinkIO Laravel Package
> **Laravel LinkIO Integration Package**  
> Developed by **Emeka Orjiani** | [emekaorjiani@gmail.com](mailto:emekaorjiani@gmail.com)

---

## 🌐 Introduction

The `emekaorjiani/linkio` package provides a seamless integration of the **LinkIO API** into Laravel applications. This package allows you to manage **On-Ramp**, **Off-Ramp**, **Bridge Transactions**, and **Rates**, as well as handle **secure webhooks** directly from your Laravel backend.

It simplifies complex API interactions, making it easy to initiate transactions, fetch rates, and process webhooks securely—all backend-driven and ready for consumption by your frontend (React, Vue, Inertia.js, Blade).

---

## ✅ Features
- 🔐 Secure **On-Ramp** (fiat → crypto) transactions
- 🔓 Easy **Off-Ramp** (crypto → fiat) transactions
- 🔄 **Bridging** between currencies and networks
- 📈 Retrieve real-time **Rates** (on-ramp, off-ramp, bridge, OTC buy/sell)
- 📡 Secure **Webhook Handling** with signature verification middleware
- 🚀 Clean **Laravel Services**, **Facades**, and **DTOs** for data consistency
- 🎉 Ready for **React**, **Vue**, **Inertia.js**, and **Blade** integration

---

## 📥 Installation

### Step 1: Install via Composer
```bash
composer require emekaorjiani/linkio
```

### Step 2: Publish Configuration (optional)
```bash
php artisan vendor:publish --tag=linkio-config
```

This will create a config file at `config/linkio.php`.

---

## ⚙️ Configuration

Open your `.env` file and add your LinkIO credentials:

```dotenv
LINKIO_API_KEY=your_linkio_api_key
LINKIO_API_SECRET=your_linkio_api_secret
LINKIO_BASE_URL=https://api.linkio.world/v1
LINKIO_WEBHOOK_SECRET=your_linkio_webhook_secret
```

Check or edit the published config file at `config/linkio.php`:

```php
return [
    'api_key'        => env('LINKIO_API_KEY'),
    'api_secret'     => env('LINKIO_API_SECRET'),
    'base_url'       => env('LINKIO_BASE_URL', 'https://api.linkio.world/v1'),
    'webhook_secret' => env('LINKIO_WEBHOOK_SECRET', ''),
];
```

---

## 🚀 Usage Examples

> 💡 Import the **Facade** in your controllers or services:
```php
use EmekaOrjiani\LinkIO\Facades\LinkIO;
```

---

### 1. On-Ramp Transactions (Fiat ➡️ Crypto)

#### Create On-Ramp Transaction
```php
$transaction = LinkIO::onRamp()->createOnRampTransaction(
    walletAddress: '0xYourWalletAddress',
    amount: 1000,
    fiatCurrency: 'NGN'
);

return response()->json($transaction);
```

#### Get On-Ramp Transaction
```php
$transaction = LinkIO::onRamp()->getOnRampTransaction('transaction_id');
```

#### List On-Ramp Transactions
```php
$transactions = LinkIO::onRamp()->listOnRampTransactions([
    'status' => 'completed',
]);
```

---

### 2. Off-Ramp Transactions (Crypto ➡️ Fiat)

#### Create Off-Ramp Transaction
```php
$transaction = LinkIO::offRamp()->createOffRampTransaction(
    walletAddress: '0xYourWalletAddress',
    amount: 0.5,
    cryptoCurrency: 'USDT'
);
```

#### Get Off-Ramp Transaction
```php
$transaction = LinkIO::offRamp()->getOffRampTransaction('transaction_id');
```

#### List Off-Ramp Transactions
```php
$transactions = LinkIO::offRamp()->listOffRampTransactions();
```

---

### 3. Bridge Transactions (Cross-Network / Cross-Currency)

#### Create Bridge Transaction
```php
$transaction = LinkIO::bridge()->createBridgeTransaction(
    walletAddress: '0xYourWalletAddress',
    sourceAmount: 0.5,
    sourceCurrency: 'USDT',
    sourceNetwork: 'TRON',
    destinationCurrency: 'USDT',
    destinationNetwork: 'BSC'
);
```

#### Get Bridge Transaction
```php
$transaction = LinkIO::bridge()->getBridgeTransaction('transaction_id');
```

#### List Bridge Transactions
```php
$transactions = LinkIO::bridge()->listBridgeTransactions();
```

---

### 4. Rates (On-Ramp, Off-Ramp, Bridge, OTC)

#### On-Ramp Rate
```php
$rate = LinkIO::rates()->getOnRampRates('NGN', 'USDT');
```

#### Off-Ramp Rate
```php
$rate = LinkIO::rates()->getOffRampRates('USDT', 'NGN');
```

#### Bridge Rate
```php
$rate = LinkIO::rates()->getBridgeRates('USDT', 'USDT', 'TRON', 'BSC');
```

#### OTC Buy Rate
```php
$rate = LinkIO::rates()->getOTCBuyRates('NGN', 'USDT');
```

#### OTC Sell Rate
```php
$rate = LinkIO::rates()->getOTCSellRates('USDT', 'NGN');
```

---

## 🛡️ Webhook Handling

### 1. Register Webhook Route in `routes/api.php`
```php
use EmekaOrjiani\LinkIO\Http\Controllers\WebhookController;

Route::post('/webhook/linkio', [WebhookController::class, 'handle'])
    ->middleware('linkio.signature');
```

### 2. Handle the Webhook in `WebhookController`
This is already set up with:
```php
public function handle(Request $request)
{
    $payload = WebhookPayloadDTO::fromRequest($request);

    if ($payload->eventType === 'transaction.completed') {
        // Process your completed transaction
    }

    return response()->json(['status' => 'ok']);
}
```

### 3. Middleware Security (`EnsureSignature.php`)
The `linkio.signature` middleware verifies incoming webhook requests by validating the signature with your `LINKIO_WEBHOOK_SECRET`.

---

## 🛠️ How it Works (Under the Hood)
- **Services**: Each core process (OnRamp, OffRamp, Bridge, Rates) has its own dedicated Service class under `src/Services`.
- **Client**: `LinkIOClient.php` handles API requests using Laravel’s `Http` facade, with signature verification and response validation.
- **DTOs**: Each API response is transformed into a Data Transfer Object (DTO) for clean, predictable data structures.
- **Middleware**: `EnsureSignature` middleware protects your webhook routes from spoofed or unauthorized requests.

---

## 📝 Example Laravel Controller

You can easily wire this into your Laravel project, exposing clean REST APIs for your frontend (React, Vue, Inertia.js).

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EmekaOrjiani\LinkIO\Facades\LinkIO;

class OnRampController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'wallet_address' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'fiat_currency' => 'required|string|size:3'
        ]);

        $transaction = LinkIO::onRamp()->createOnRampTransaction(
            $request->wallet_address,
            $request->amount,
            $request->fiat_currency
        );

        return response()->json($transaction);
    }
}
```

---

## 🔗 Frontend Consumption Example (React)
This Laravel package is backend-centric. Your React frontend can consume the endpoints you expose.

```jsx
import axios from 'axios';

async function initiateOnRamp(wallet, amount, fiatCurrency) {
  try {
    const res = await axios.post('/api/on-ramp', {
      wallet_address: wallet,
      amount: amount,
      fiat_currency: fiatCurrency,
    });

    console.log('Transaction created:', res.data);
  } catch (error) {
    console.error('OnRamp Error:', error.response?.data);
  }
}
```

---

## ✅ Requirements
- PHP `^8.0`
- Laravel `9.x` or `10.x`
- LinkIO API Credentials (get them from your LinkIO dashboard)

---

## 🏗️ Project Structure

```
emekaorjiani/linkio
├── src/
│   ├── LinkIOServiceProvider.php
│   ├── Facades/LinkIO.php
│   ├── Http/
│   │   ├── Controllers/WebhookController.php
│   │   └── Middleware/EnsureSignature.php
│   ├── Services/
│   │   ├── LinkIOClient.php
│   │   ├── OnRampService.php
│   │   ├── OffRampService.php
│   │   ├── BridgeService.php
│   │   └── RatesService.php
│   ├── DTOs/
│   │   ├── OnRampTransactionDTO.php
│   │   ├── OffRampTransactionDTO.php
│   │   ├── BridgeTransactionDTO.php
│   │   ├── RateDTO.php
│   │   └── WebhookPayloadDTO.php
│   └── Exceptions/LinkIOException.php
├── config/linkio.php
└── README.md
```

---

## ✉️ Author
**Emeka Orjiani**  
📧 [emekaorjiani@gmail.com](mailto:emekaorjiani@gmail.com)

---

## 📄 License
This Laravel package is open-sourced software licensed under the [MIT license](LICENSE).

---

## ❤️ Contributing
Feel free to submit issues or pull requests!  
Fork the repo → create a feature branch → submit a pull request.

---

## 🚀 Future Roadmap (Optional)
- Add **support for LinkIO Widget Integration**
- Add **Laravel Events** for Webhook callbacks
- Add **Caching** for Rates endpoints
- Add **Optional Notifications** for transactions in Laravel

---

Let me know if you'd like to:
- Customize the **future roadmap** section  
- Include **live API testing** guidance  
- Add **GitHub Actions** for tests  
- Publish to **Packagist**

