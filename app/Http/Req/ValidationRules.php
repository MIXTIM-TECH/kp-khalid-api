<?php

return [
    "nik"   => "string|required|max:16|unique:anggota_keluarga,nik",
    "no_kk" => "string|required|unique:kk,no_kk|max:16"
];
