<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DriverBehaviorReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $driver;

    public function __construct($driver, $pdf)
    {
        $this->driver = $driver;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject("Driver Behavior Report - {$this->driver->names}")
                    ->markdown('emails.driver.behavior_report')
                    ->attachData($this->pdf->output(), "DriverBehaviorReport-{$this->driver->names}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }
}
