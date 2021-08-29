<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectUserRequest;
use App\Http\Requests\SubscribeUserRequest;
use App\Models\Gameserver\Player;
use App\Models\Loginserver\AccountData;
use App\Models\Loginserver\AccountLevel;
use App\Models\Webserver\Pages;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{

    /**
     * GET /user/subscribe
     */
    public function subscribe()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.subscribe.title'));

        $content = Pages::where('page_name', '=', 'subscribe')->first([$this->language]);

        return view('user.subscribe', [
            'content' => $content[$this->language]
        ]);
    }

    /**
     * POST /user/subscribe
     *
     * @param SubscribeUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccount(SubscribeUserRequest $request)
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.subscribe.title'));

        $user = AccountData::create([
            'name'      => $request->input('username'),
            'pseudo'    => $request->input('pseudo'),
            'password'  => base64_encode(sha1($request->input('password'), true)),
            'email'     => $request->input('email')
        ]);

        $this->createSession($user);

        return redirect()->route('user.account')->with('success', Lang::get('flashMessage.user.subscribe_and_logged'));

    }

    /**
     * POST /user/login
     *
     * @param ConnectUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function connect(ConnectUserRequest $request)
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.login.title'));

        $user = AccountData::activated()
            ->where('name', $request->get('username'))
            ->where('password', base64_encode(sha1($request->get('password'), true)))
            ->first();

        if($user !== null){
            $this->createSession($user);
            return redirect(route('user.account'))->with('success', Lang::get('flashMessage.user.logged'));
        } else {
            return redirect(route('home'))->with('error', Lang::get('flashMessage.user.no_account'))->withInput();
        }

    }

    /**
     * GET /user/logout
     */
    public function logout()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.logout.title'));

        session()->flush();

        return redirect(route('home'))->with('success', Lang::get('flashMessage.user.logout'));
    }

    /**
     * GET /user/acount
     */
    public function account()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.account.title'));

        $players        = Player::legion()->where('account_id', '=', session()->get('user.id'))->get();
        $accountLevel   = AccountLevel::where('account_id', session()->get('user.id'))->first();
        $levels         = Config::get('aion.levels');

        if(!$accountLevel){
            $nextLevel = $levels[1];
        } else {
            $reverseLevels  = array_reverse($levels);;

            if($accountLevel['level'] + 1 > $reverseLevels[0]['level']){
                $nextLevel = $reverseLevels[0];
            } else {
                $nextLevel = $levels[$accountLevel['level'] + 1];
            }
        }

        return view('user.account', [
            'user'      => session()->get('user'),
            'players'   => $players,
            'level'     => $accountLevel,
            'nextLevel' => $nextLevel
        ]);
    }

    /**
     * GET /user/edit
     */
    public function edit(Request $request)
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.account.title'));

        $errors  = [];
        $success = [];

        if($request->isMethod('post')){
            $data = $request->all();

            // Password
            if($data['password'] && ($data['password'] !== $data['password_confirmation'])){
                $errors['password'] = 'Les mots de passe ne correspondent pas';
            } else if($data['password'] && ($data['password'] === $data['password_confirmation'])){
                AccountData::where('id', session()->get('user.id'))->update([
                    'password' => base64_encode(sha1($data['password'], true))
                ]);
                $success['password'] = 'Mot de passe sauvegardé';
            }

            // Pseudo
            if($data['pseudo']) {
                $accountBaseOnPseudo = AccountData::where('pseudo', $data['pseudo'])->where('id', '<>', session()->get('user.id'))->first();

                if($accountBaseOnPseudo){
                    $errors['pseudo'] = 'Le pseudo est déjà pris';
                } else {
                    AccountData::where('id', session()->get('user.id'))->update([
                        'pseudo' => $data['pseudo']
                    ]);
                    session()->put('user.pseudo', $data['pseudo']);
                    $success['pseudo'] = 'Pseudo sauvegardé';
                }
            }

            // PushBullet
            if(isset($data['pushbullet']) && $data['pushbullet']){
                if(!filter_var($data['pushbullet'], FILTER_VALIDATE_EMAIL)){
                    $errors['pushbullet'] = 'Merci de rentrer un email valide';
                } else {
                    AccountData::where('id', session()->get('user.id'))->update([
                        'pushbullet' => $data['pushbullet']
                    ]);
                    $success['pushbullet'] = 'Pushbullet sauvegardé';
                }
            }

        }

        $user = AccountData::where('id', session()->get('user.id'))->first();

        return view('user.edit', [
            'user'      => $user,
            'errors'    => $errors,
            'success'   => $success
        ]);
    }

    /**
     * GET /user/unlock/{playerId)/{accountId}
     */
    public function unlockPlayer($playerId, $accountId)
    {
        $player = Player::where('account_id', $accountId)->where('id', $playerId)->first();

        if(!$player){
            return 'NO_PLAYER';
        }

        if($player->online == 1) {
            return 'PLAYER_CONNECTED';
        }

        // Teleport the character
        Player::where('id', $playerId)->update([
            'world_id'  => ($player->race === 'ELYOS') ? Config::get('aion.spawn.elyos.world_id') : Config::get('aion.spawn.asmodians.world_id'),
            'x'         => ($player->race === 'ELYOS') ? Config::get('aion.spawn.elyos.x') : Config::get('aion.spawn.asmodians.x'),
            'y'         => ($player->race === 'ELYOS') ? Config::get('aion.spawn.elyos.y') : Config::get('aion.spawn.asmodians.y'),
            'z'         => ($player->race === 'ELYOS') ? Config::get('aion.spawn.elyos.z') : Config::get('aion.spawn.asmodians.z'),
            'heading'   => ($player->race === 'ELYOS') ? Config::get('aion.spawn.elyos.heading') : Config::get('aion.spawn.asmodians.heading')
        ]);

        // Success
        return 'OK';
    }

    /**
     * Create Session with information
     *
     * @param $user
     */
    private function createSession($user)
    {
        session()->put('connected', true);
        session()->put('user.id', $user->id);
        session()->put('user.name', $user->name);
        session()->put('user.pseudo', $user->pseudo);
        session()->put('user.email', $user->email);
        session()->put('user.access_level', $user->access_level);
    }

}
