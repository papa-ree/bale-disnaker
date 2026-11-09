<?php

namespace Paparee\BaleDisnaker\Services;

use Bale\Tala\Support\TokenStore;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Paparee\BaleDisnaker\Exceptions\WilayahUnavailable;

/**
 * Master wilayah (kecamatan + desa) dari API Nawasara. Tidak ada master
 * wilayah di database: hanya `code` + `name` pilihan user yang disimpan.
 */
class WilayahClient
{
    public function districts(): array
    {
        return $this->options($this->request(
            fn (string $token) => Http::withToken($token)->acceptJson()->timeout(10)
                ->get($this->url('/api/v1/aspirations/regions/districts'))
        ));
    }

    public function villages(string $districtCode): array
    {
        if ($districtCode === '') {
            return [];
        }

        return $this->options($this->request(
            fn (string $token) => Http::withToken($token)->acceptJson()->timeout(10)
                ->get($this->url('/api/v1/aspirations/regions/villages'), ['district' => $districtCode])
        ));
    }

    /**
     * @param  callable(string): Response  $send
     */
    private function request(callable $send): array
    {
        $token = TokenStore::accessToken();

        if ($token === null) {
            throw new WilayahUnavailable(__('Sesi Anda berakhir. Silakan masuk lagi.'), true);
        }

        try {
            $response = $send($token);
        } catch (ConnectionException $e) {
            throw new WilayahUnavailable(__('Layanan wilayah sedang tidak tersedia. Coba beberapa saat lagi.'));
        }

        // Access token Keycloak berumur pendek; ulangi sekali setelah refresh.
        if ($response->status() === 401) {
            $refreshed = TokenStore::refresh();

            if ($refreshed === false) {
                throw new WilayahUnavailable(__('Sesi Anda berakhir. Silakan masuk lagi.'), true);
            }

            if ($refreshed === null) {
                throw new WilayahUnavailable(__('Layanan wilayah sedang tidak tersedia. Coba beberapa saat lagi.'));
            }

            try {
                $response = $send((string) TokenStore::accessToken());
            } catch (ConnectionException $e) {
                throw new WilayahUnavailable(__('Layanan wilayah sedang tidak tersedia. Coba beberapa saat lagi.'));
            }
        }

        if (! $response->successful()) {
            throw new WilayahUnavailable(__('Layanan wilayah sedang tidak tersedia. Coba beberapa saat lagi.'));
        }

        $data = $response->json('data');

        if (! is_array($data)) {
            throw new WilayahUnavailable(__('Respons layanan wilayah tidak dikenali.'));
        }

        return $data;
    }

    private function options(array $rows): array
    {
        $options = [];

        foreach ($rows as $row) {
            if (! is_array($row) || empty($row['code']) || empty($row['name'])) {
                continue;
            }

            $options[] = [
                'code' => (string) $row['code'],
                'name' => (string) $row['name'],
            ];
        }

        // Nama wilayah diurutkan A-Z; urutan API tidak dijamin.
        usort($options, fn (array $a, array $b) => strcasecmp($a['name'], $b['name']));

        return $options;
    }

    private function url(string $path): string
    {
        return rtrim((string) config('bale-disnaker.wilayah_url'), '/').$path;
    }
}
