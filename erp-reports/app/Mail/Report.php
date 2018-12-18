<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Report extends Mailable
{
    use Queueable, SerializesModels;

    public $reportInfo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reportInfo)
    {
        $this->reportInfo = $reportInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Rapport ' . $this->reportInfo->reportName
                . ' du ' . $this->reportInfo->dateFrom
                . ' au '. $this->reportInfo->dateTo;
        return $this->subject($subject)
            ->from('support@sopami.com', 'BitSolutions')
            ->view('emails.report')
            ->attach($this->reportInfo->filePath, [
                'mime' => 'type'
            ]);;
    }
}
