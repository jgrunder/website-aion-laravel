<?php

namespace App\Http\Controllers;

use App\Events\UserWasPurchasedShopPoint;

use App\Models\Loginserver\AccountData;
use App\Models\Webserver\LogsAllopass;
use App\Models\Webserver\LogsPaypal;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class PaiementController extends Controller {

    /**
     * GET /user/allopass
     */
    public function allopass()
    {
        return view('paiement.allopass');
    }

    /**
     * GET /allopass/success
     */
    public function allopassSuccess(Request $request)
    {
        $recall = htmlentities($request::input('RECALL'));

        // Recall is empty so redirect with error message
        if(trim($recall) == ""){
            return redirect(route('allopass'))->with('error', Lang::get('flashMessage.paiement.wrong_allopass'));
        }

        // Contain the allopass code
        $recall = urlencode($recall);

        // Code of the document Allopass
        $auth = urlencode(Config::get('aion.allopass.documentId'));

        // Read status
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, "http://payment.allopass.com/api/checkcode.apu?code=$recall&auth=$auth");

        $r = curl_exec($curl);
        curl_close($curl);

        if (substr($r, 0, 2) == 'OK') {

            // Check if code is in our database
            if (LogsAllopass::check($recall) === null){

                if (LogsAllopass::insert($recall, Session::get('user.id')) !== null) {

                    AccountData::me(Session::get('user.id'))->increment('points', Config::get('aion.allopass.pointsGiven'));
                    event(new UserWasPurchasedShopPoint(Session::get('user.id')));
                    return redirect(route('allopass'))->with('success', Lang::get('flashMessage.paiement.success_allopass')." ".Config::get('aion.allopass.pointsGiven'));

                }

                return redirect(route('allopass'))->with('error', Lang::get('flashMessage.paiement.error_allopass'));

            }

            return redirect(route('allopass'))->with('error', Lang::get('flashMessage.paiement.already_used_allopass'));


        }

        return redirect(route('allopass'))->with('error', Lang::get('flashMessage.paiement.error_allopass'));

    }

    /**
     * GET /paypal
     */
    public function paypal()
    {
        return view('paiement.paypal', [
            'step' => 1,
            'uid'  => Session::get('user.id')
        ]);
    }

    /**
     * GET /paypal-ipn
     */
    public function paypalIpn()
    {

        $emailAccount = Config::get('aion.paypal.email');

        // Prepare the URL to send via cURL
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($_POST as $key => $value) {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // Initial cURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.paypal.com");
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

        // Return result
        $result = curl_exec($ch);

        // Close cURL connection
        curl_close($ch);

        // If condition
        if($result == 'VERIFIED') {
            $item_name        = $_POST['item_name'];
            $item_number      = $_POST['item_number'];
            $payment_status   = $_POST['payment_status'];
            $payment_amount   = $_POST['mc_gross'];
            $payment_tax      = $_POST['tax'];
            $payment_ht       = $payment_amount - $payment_tax;
            $payment_currency = $_POST['mc_currency'];
            $address          = $_POST['address_street'];
            $country          = $_POST['address_country'];
            $city             = $_POST['address_city'];
            $name             = $_POST['address_name'];
            $txn_id           = $_POST['txn_id'];
            $receiver_email   = $_POST['receiver_email'];
            $payer_email      = $_POST['payer_email'];
            parse_str($_POST['custom'],$custom);

            if ($emailAccount == $receiver_email) {

                $points  = $custom['points'];
                $uid     = $custom['uid'];

                // Check if it's the good payment number
                if($payment_ht = $points / Config::get('aion.paypal.points_per_euro')) {

                    // Increment tolls
                    AccountData::me($uid)->increment('shop_points', $points);

                    // Add logs in database
                    LogsPaypal::create([
                        'id_account' => $uid,
                        'price'	     => $payment_ht,
                        'status'     => $payment_status,
                        'tax'	     => $payment_tax,
                        'email'	     => $payer_email,
                        'txnid'      => $txn_id,
                        'amount'     => $points,
                        'name'       => $name,
                        'country'    => $country,
                        'city'	     => $city,
                        'address'    => $address
                    ]);

                    event(new UserWasPurchasedShopPoint($uid));
                }
            }
        }
    }

    /**
     * GET /paypal-valid
     */
    public function paypalValid()
    {
        return view('paiement.paypal', [
            'step' => 2
        ]);
    }

}
