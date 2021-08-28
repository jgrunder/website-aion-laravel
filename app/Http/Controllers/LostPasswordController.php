<?php

namespace App\Http\Controllers;

use App\Models\Loginserver\AccountData;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class LostPasswordController extends Controller
{

    /**
     * GET /user/lost-password
     */
    public function index(Request $request)
    {

        // SEO
        SEOMeta::setTitle(Lang::get('seo.lost_password.title'));
        SEOMeta::setDescription(Lang::get('seo.lost_password.description'));
        OpenGraph::setDescription(Lang::get('seo.lost_password.description'));

        $success = null;
        $errors  = null;

        if($request->isMethod('post')) {

            $email   = $request->input('email');
            $account = AccountData::where('email', '=', $email)->first();

            if($account !== null) {

                // We generate a token and add it to database
                $token = uniqid();
                AccountData::where('email', '=', $email)->update(['token' => $token]);

                // We send a beautiful email
                Mail::send('lostpassword.email_lost_password_1', ['account' => $account, 'link' => url('reset-password', [$token, $account->name])], function($m) use ($account) {
                    $m->to($account->email)->subject(Lang::get('all.forgot_password.mail1_subject'));
                });

                $success = Lang::get('all.forgot_password.mail1_sent');
            } else {
                $errors  = Lang::get('all.forgot_password.mail1_error');
            }

        }

        return view('lostpassword.lost_password', [
            'step'    => 1,
            'success' => $success,
            'errors'  => $errors
        ]);
    }

    /**
     * GET /reset-password
     */
    public function reset($token, $name)
    {

        $success = null;
        $errors  = null;
        $account = AccountData::where('name', '=', $name)->where('token', '=', $token)->first();

        if($account !== null) {

            // We update the password and reset the token
            AccountData::where('name', '=', $name)->update([
                'password' => base64_encode(sha1($token, true)),
                'token'    => null
            ]);

            // We send a beautiful email
            Mail::send('lostpassword.email_lost_password_2', ['account' => $account, 'password' => $token], function($m) use ($account) {
                $m->to($account->email)->subject(Lang::get('all.forgot_password.mail2_subject'));
            });

            $success = Lang::get('all.forgot_password.mail2_confirm');


        } else {
            $errors = Lang::get('all.forgot_password.mail2_error');
        }

        return view('lostpassword.lost_password', [
            'step'    => 2,
            'success' => $success,
            'errors'  => $errors
        ]);

    }

}
