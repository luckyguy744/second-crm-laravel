<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kevupton\LaravelCoinpayments\Exceptions\IpnIncompleteException;
use Kevupton\LaravelCoinpayments\Models\Ipn;
use Kevupton\LaravelCoinpayments\Models\Transaction;

use Validator;
use App\states;
use App\country;
use Session;
use Hash;
use File;
use Auth;
use App\User;
use App\banks;
use App\activities;
use App\packages;
use App\investment;
use App\msg;
use App\withdrawal;
use App\deposits;
use App\ref;
use App\fund_transfer;
use App\xpack_inv;
use App\xpack_packages;
use App\site_settings;

class CoinpaymentsController extends Controller
{
    const ITEM_CURRENCY = 'BTC';
    const ITEM_PRICE    = 0.01;

    /**
     * Purchase items using coinpayments payment processor
     *
     * @param Request $request
     * @return array
     */
    public function purchaseItems (Request $request)
    {
        // validate that the request has the appropriate values
        $this->validate($request, [
            'currency' => 'required|string',
            'amount'   => 'required|integer|min:1',
        ]);


        $amount   = $request->get('amount');
        $currency = $request->get('currency');

        /*
         * Calculate the price of the item (qty * ppu)
         */
        $cost = $amount * self::ITEM_PRICE;

        /** @var Transaction $transaction */
        $transaction = \Coinpayments::createTransactionSimple($cost, self::ITEM_CURRENCY, $currency);

        return ['transaction' => $transaction];
    }

    /**
     * Creates a donation transaction
     *
     * @param Request $request
     * @return array
     */
    public function donation (Request $request)
    {
        // validate that the request has the appropriate values
        $this->validate($request, [
            'currency' => 'required|string',
            'amount'   => 'required|integer|min:0.01',
        ]);

        $amount   = $request->get('amount');
        $currency = $request->get('currency');

        /*
         * Here we are donating the exact amount that they specify.
         * So we use the same currency in and out, with the same amount value.
         */
        $transaction = \Coinpayments::createTransactionSimple($amount, $currency, $currency);

        return ['transaction' => $transaction];
    }

    /**
     * Handled on callback of IPN
     *
     * @param Request $request
     */
    public function validateIpn (Request $request)
    {
        try {
            /** @var Ipn $ipn */
            $ipn = \Coinpayments::validateIPNRequest($request);

            // if the ipn came from the API side of coinpayments merchant
            if ($ipn->isApi()) {

                /*
                 * If it makes it into here then the payment is complete.
                 * So do whatever you want once the completed
                 */

                // do something here
                // Payment::find($ipn->txn_id);
            }
        }
        catch (IpnIncompleteException $e) {
            $ipn = $e->getIpn();
            /*
             * Can do something here with the IPN model if desired.
             */
        }
    }
}