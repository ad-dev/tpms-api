<?php
namespace App\Faker\Provider;

use Faker\Provider\Base;

class LicensePlateProvider extends Base {
    // https://www.regitra.lt/lt/paslaugos/numerio-zenklai/numerio-zenklu-tipai-ir-ju-aprasymai/bendrojo-naudojimo
    const LICENSE_PLATE_FORMAT_TRUCK = "??? ###";
    const LICENSE_PLATE_FORMAT_TRAILER = "?? ###";

    public function getTruckLicensePlate(): string {
        return strtoupper(static::bothify($this::LICENSE_PLATE_FORMAT_TRUCK));
    }
    public function getTrailerLicensePlate(): string {
        return strtoupper(static::bothify($this::LICENSE_PLATE_FORMAT_TRAILER));
    }
}
