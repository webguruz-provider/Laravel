<?php

namespace App\Sided;

use App\User;
use App\SocialAccount;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{

    /**
     * Authenticate or create user based on Facebook user object
     * @param  ProviderUser $providerUser [description]
     * @return User $user
     */
    public function getFaceBookUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::where('provider_id', $providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        }

        $account = new SocialAccount([
            'provider_id' => $providerUser->getId(),
            'provider_url' => $providerUser->profileUrl,
            'provider' => 'Facebook'
        ]);

        $user = User::where('email', $providerUser->getEmail())->first();
        if (!$user) {
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'avatar_url' => $providerUser->avatar,
                'gender' => $providerUser->user['gender'],
            ]);
        }
        $account->user()->associate($user);
        $account->save();
        return $user;
    }


    /**
     * Authenticate or create user based on Twitter user object
     * @param  ProviderUser $providerUser [description]
     * @return User $user
     */
    public function getTwitterUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::where('provider_id', $providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        }

        $account = new SocialAccount([
            'provider_id' => $providerUser->getId(),
            'provider_url' => 'https://twitter.com/' . $providerUser->nickname,
            'provider' => 'Twitter'
        ]);

        $user = User::where('email', $providerUser->getEmail())->first();
        if (!$user) {
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'avatar_url' => $providerUser->avatar,
                'timezone' => $providerUser->user['time_zone'],
            ]);
        }
        $account->user()->associate($user);
        $account->save();
        return $user;
    }

    /**
     * Authenticate or create user based on Twitter user object
     * @param  ProviderUser $providerUser [description]
     * @return User $user
     */
    public function getGoogleUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::where('provider_id', $providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        }

        $account = new SocialAccount([
            'provider_id' => $providerUser->getId(),
            'provider' => 'Google'
        ]);

        $user = User::where('email', $providerUser->getEmail())->first();
        if (!$user) {
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'avatar_url' => $providerUser->avatar
            ]);
        }
        $account->user()->associate($user);
        $account->save();
        return $user;
    }

}
