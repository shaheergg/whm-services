<?php

use Illuminate\Support\Str;


return [
    "EDIS_EMAIL"=> env("EDIS_EMAIL","vender@navicosoft.com"),
    "EDIS_PASSWORD"=> env("EDIS_PASSWORD"),
    "EDIS_BASE_URL"=>env("EDIS_BASE_URL", "https://session.edisglobal.com/kvm/v2/get/auth"),
];