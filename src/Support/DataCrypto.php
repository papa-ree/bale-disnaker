<?php

namespace Paparee\BaleDisnaker\Support;

use Illuminate\Encryption\Encrypter;
use RuntimeException;

/**
 * Kunci data pribadi (NIK, WhatsApp) terpisah dari APP_KEY. Nilainya sama
 * dengan PELATIHAN_DATA_KEY di bale-dev karena kedua aplikasi berbagi baris.
 */
final class DataCrypto
{
    private static ?Encrypter $encrypter = null;

    private static function key(): string
    {
        $key = (string) config('bale-disnaker.data_key');

        if ($key === '') {
            throw new RuntimeException('PELATIHAN_DATA_KEY belum diisi di .env');
        }

        return str_starts_with($key, 'base64:') ? base64_decode(substr($key, 7)) : $key;
    }

    public static function encrypter(): Encrypter
    {
        return self::$encrypter ??= new Encrypter(self::key(), 'AES-256-CBC');
    }

    public static function decrypt(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return self::encrypter()->decryptString($value);
    }

    public static function encrypt(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return self::encrypter()->encryptString($value);
    }

    /**
     * Hash exact-match, dipakai admin untuk mencari NIK.
     */
    public static function hash(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return hash_hmac('sha256', $value, self::key());
    }

    /**
     * NIK/nomor telepon tersamar: 4 digit awal dan 4 digit akhir.
     */
    public static function mask(?string $plain): ?string
    {
        if ($plain === null || strlen($plain) < 9) {
            return $plain;
        }

        return substr($plain, 0, 4).str_repeat('*', strlen($plain) - 8).substr($plain, -4);
    }
}
