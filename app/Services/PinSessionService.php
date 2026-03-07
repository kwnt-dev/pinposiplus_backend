<?php

namespace App\Services;

use App\Mail\PinPositionMail;
use App\Models\PinHistory;
use App\Models\PinSession;
use Illuminate\Support\Facades\Mail;

class PinSessionService
{
    public function __construct(
        private PdfStorageService $pdfStorageService,
    ) {}

    public function send(PinSession $session, ?string $pdfBase64): PinSession
    {
        if ($pdfBase64) {
            $session->pdf_url = $this->pdfStorageService->upload(
                $pdfBase64,
                $session->target_date->format('Y-m-d'),
                $session->course
            );
        }

        $this->savePinsToHistory($session);

        $session->update([
            'status' => 'sent',
            'pdf_url' => $session->pdf_url,
        ]);

        $this->sendMail($session);

        return $session;
    }

    private function savePinsToHistory(PinSession $session): void
    {
        $targetDate = $session->target_date
            ? date('Y-m-d', strtotime($session->target_date))
            : date('Y-m-d');

        foreach ($session->pins as $pin) {
            PinHistory::where('hole_number', $pin->hole_number)
                ->where('date', $targetDate)
                ->delete();

            PinHistory::create([
                'hole_number' => $pin->hole_number,
                'x' => $pin->x,
                'y' => $pin->y,
                'date' => $targetDate,
                'submitted_by' => $session->submitted_by,
            ]);
        }
    }

    private function sendMail(PinSession $session): void
    {
        $masterEmail = config('pinposi.master_room_email');

        if ($masterEmail && $session->pdf_url) {
            Mail::to($masterEmail)->send(
                new PinPositionMail(
                    $session->target_date->format('Y-m-d'),
                    $session->pdf_url
                )
            );
        }
    }
}
