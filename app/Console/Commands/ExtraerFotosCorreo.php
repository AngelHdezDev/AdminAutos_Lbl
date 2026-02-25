<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use App\Models\ImagenTemporal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExtraerFotosCorreo extends Command
{
    protected $signature = 'app:extraer-fotos';
    protected $description = 'Descarga imágenes de autos desde el correo ';

    public function handle()
    {
        $client = Client::account('default');
        $client->connect();

        
        $folder = $client->getFolder('INBOX');
        $messages = $folder->query()->unseen()->get();

        $this->info("Procesando " . $messages->count() . " correos nuevos...");

        foreach ($messages as $message) {
            if ($message->hasAttachments()) {
                foreach ($message->getAttachments() as $attachment) {

                    if (str_contains($attachment->getMimeType(), 'image')) {

                        $nombreArchivo = Str::uuid() . '_' . $attachment->getName();
                        $rutaFinal = 'inbox_fotos/' . $nombreArchivo;

                        
                        Storage::disk('public')->put($rutaFinal, $attachment->getContent());

                        
                        ImagenTemporal::create([
                            'ruta_archivo' => $rutaFinal,
                            'nombre_original' => $attachment->getName(),
                            'correo_origen' => $message->getFrom()[0]->mail,
                            'asunto' => $message->getSubject(),
                            'fecha_correo' => $message->getDate()[0]->format('Y-m-d H:i:s'),
                            'status' => 0
                        ]);

                        $this->line("Imagen guardada: " . $attachment->getName());
                    }
                }
            }
           
            $message->setFlag('Seen');
        }

        $this->info("Proceso terminado.");
    }
}