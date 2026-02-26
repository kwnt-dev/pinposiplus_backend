<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PdfStorageService
{
    /**
     * Base64エンコードされたPDFをS3にアップロード
     */
    public function upload(string $base64Pdf, string $targetDate, string $course): string
    {
        $pdf = base64_decode($base64Pdf);
        $filename = "pin-positions/{$targetDate}_{$course}_".now()->format('His').'.pdf';

        Storage::disk('s3')->put($filename, $pdf, 'public');

        return Storage::disk('s3')->url($filename);
    }
}
