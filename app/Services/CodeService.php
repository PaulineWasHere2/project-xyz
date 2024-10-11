<?php

namespace App\Services;

use App\Models\Code;
use Illuminate\Support\Str;

class CodeService
{
    static function generateCode(int $amount): array
    {
        $codes = [];
        while (count($codes) < $amount) {
            do {
                $code = Str::upper(Str::random(4) . '-' . rand(1000,9999) . '-' . Str::random(4)) ;
            } while (Code::query()->where('code', $code)->exists());
            $codes[] = $code;
        }
        return $codes;
        //$codeList = Code::all();
        //$generatedCode = Str::upper(Str::random(4) . '-' . rand(1000,9999) . '-' . Str::random(4)) ;
        //while ($codeList->where('code', $generatedCode)->isNotEmpty()) {
        //    $generatedCode = Str::upper(Str::random(4) . '-' . rand(1000,9999) . '-' . Str::random(4)) ;
        //}
        //return $generatedCode;
    }
    static function generateManyCodes(int $numberOfCodes) {
        $codeList = [];
        for ($i = 0; $i< $numberOfCodes; $i++) {
            $codeList[] = CodeService::generateCode($numberOfCodes);
        }
        return $codeList;
    }
}
