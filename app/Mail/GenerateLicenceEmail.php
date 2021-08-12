<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class GenerateLicenceEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->newData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $backgroundURL = public_path('admin/dist-assets/images/licence-bg.jpg');
        $profilePhoto = $this->newData->user->photo ? public_path('images/'. $this->newData->user->photo) : public_path('admin/dist-assets/images/avatar.jpg');
        $pdf = PDF::loadView('pdf.licence', ['data' => $this->newData, 'background' => $backgroundURL, 'photo' => $profilePhoto]);

        return $this->markdown('mail.generate-licence',['data'=>$this->newData])
        ->attachData($pdf->output(), "licence.pdf")
        ->subject(env('APP_NAME') . ' - Licence Generate for PPMV Application');
    }
}
