<?php

return [
    // Harus sama dengan PELATIHAN_DATA_KEY di bale-dev.
    'data_key' => env('PELATIHAN_DATA_KEY'),

    // API master wilayah (kecamatan + desa), dilindungi Bearer token citizen.
    'wilayah_url' => env('PELATIHAN_WILAYAH_URL', 'https://nawasara.ponorogo.go.id'),
];
