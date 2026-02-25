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

        // Accedemos a la bandeja de entrada
        $folder = $client->getFolder('INBOX');
        $messages = $folder->query()->unseen()->get();

        $this->info("Procesando " . $messages->count() . " correos nuevos...");

        foreach ($messages as $message) {
            if ($message->hasAttachments()) {
                foreach ($message->getAttachments() as $attachment) {

                    if (str_contains($attachment->getMimeType(), 'image')) {

                        $nombreArchivo = Str::uuid() . '_' . $attachment->getName();
                        $rutaFinal = 'inbox_fotos/' . $nombreArchivo;

                        // Guardamos físicamente
                        Storage::disk('public')->put($rutaFinal, $attachment->getContent());

                        // Creamos el registro en la tabla auxiliar
                        ImagenTemporal::create([
                            'ruta_archivo' => $rutaFinal,
                            'nombre_original' => $attachment->getName(),
                            'correo_origen' => $message->getFrom()[0]->mail,
                            'asunto' => $message->getSubject(),
                            'fecha_correo' => $message->getDate()[0]->format('Y-m-d H:i:s')
                        ]);

                        $this->line("Imagen guardada: " . $attachment->getName());
                    }
                }
            }
            // Marcamos como leído para no repetir el proceso
            $message->setFlag('Seen');
        }

        $this->info("Proceso terminado.");
    }
}