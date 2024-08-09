<?php

namespace App\Services\SiteService;

use App\Models\MagicLoginToken;
use App\Models\Site;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MagicLoginService
{
    public function storeMagicLoginToken(Site $site): MagicLoginToken
    {
        return $site->magicLoginTokens()
            ->create([
                'token' => $this->generateToken(),
                'expires_at' => $this->getExpiry(),
            ]);
    }

    private function encode(string $string): string
    {
        return base64_encode($string);
    }

    public function generateSiteDashboardRedirectUrl(Site $site): string
    {
        $magicLoginToken = $this->storeMagicLoginToken(site: $site);

        $query = $this->prepareQuery(site: $site, magicLoginToken: $magicLoginToken);

        return $site->url . '?' . http_build_query([
                'magic_login_token' => $this->encode($query),
            ]);
    }

    public function getSiteByToken(string $token): ?Site
    {
        $magicLoginToken = $this->getValidMagicToken(token: $token);

        if (!$magicLoginToken) {
            return null;
        }

        $magicLoginToken->markAsUsed();

        return $magicLoginToken->site;
    }

    public function getValidMagicToken(string $token): ?MagicLoginToken
    {
        return MagicLoginToken::query()
            ->isNotExpired()
            ->unused()
            ->where('token', $token)
            ->first();
    }

    private function prepareQuery(Site $site, MagicLoginToken $magicLoginToken): string
    {
        return http_build_query([
            'token' => $magicLoginToken->token,
            'email' => $site->admin_email,
            'hash' => $this->generateHash(
                token: $magicLoginToken->token,
                email: $site->admin_email,
                secretKey: $site->secret_key,
            ),
        ]);
    }

    private function generateToken(): string
    {
        return Str::random(60);
    }

    private function getExpiry(): Carbon
    {
        return now()->addMinutes(15);
    }

    private function generateHash(string $token, string $email, string $secretKey): string
    {
        return hash_hmac('sha256', $token . $email, $secretKey);
    }
}
