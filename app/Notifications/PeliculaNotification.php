<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Pelicula;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PeliculaNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $titulo,$fecha,$asunto,$texto;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Pelicula $pelicula,$fechaAct= false)
    {
        $this->titulo = $pelicula->titulo;
        if ($fechaAct == false) {
            $this->asunto = 'Pelicula Creada';
            $this->texto = "creó";
            $this->fecha = $pelicula->created_at;
        } else {
            $this->asunto = 'Pelicula Actualizada';
            $this->texto = "actualizo";
            $this->fecha = $pelicula->updated_at;
        }      

    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->greeting('Saludos!')
        ->subject($this->asunto)
        ->line("Se " . $this->texto . " la pelicula " . $this->titulo . " a las " . $this->fecha);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
