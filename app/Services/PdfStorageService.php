<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PdfStorageService
{
    // Base64エンコードされたPDFをS3にアップロードし、公開URLを返す
    public function upload(string $base64Pdf, string $targetDate, string $course): string
    {
        $pdf = base64_decode($base64Pdf);
        $filename = "pin-positions/{$targetDate}_{$course}_".now()->format('His').'.pdf';

        /** @var \Illuminate\Filesystem\AwsS3V3Adapter $disk */
        $disk = Storage::disk('s3');
        $disk->put($filename, $pdf, 'public');

        return $disk->url($filename);
    }
}
