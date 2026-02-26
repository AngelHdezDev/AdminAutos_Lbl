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

        // 1. Definimos las extensiones que sí permitimos
        $extensionesPermitidas = ['jpg', 'jpeg', 'png'];

        foreach ($messages as $message) {
            if ($message->hasAttachments()) {
                foreach ($message->getAttachments() as $attachment) {

                    $nombreOriginal = $attachment->getName();
                    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

                    // 2. Primero verificamos si es imagen por MimeType
                    // 3. Y LUEGO verificamos si la extensión está en nuestra lista permitida
                    if (str_contains($attachment->getMimeType(), 'image') && in_array($extension, $extensionesPermitidas)) {

                        $nombreArchivo = Str::uuid() . '_' . $nombreOriginal;
                        $rutaFinal = 'inbox_fotos/' . $nombreArchivo;

                        Storage::disk('public')->put($rutaFinal, $attachment->getContent());

                        ImagenTemporal::create([
                            'ruta_archivo' => $rutaFinal,
                            'nombre_original' => $nombreOriginal,
                            'correo_origen' => $message->getFrom()[0]->mail,
                            'asunto' => $message->getSubject(),
                            'fecha_correo' => $message->getDate()[0]->format('Y-m-d H:i:s'),
                            'status' => 0
                        ]);

                        $this->line("Imagen guardada correctamente: " . $nombreOriginal);
                    } else {
                        // Cae aquí si no es imagen O si es una imagen con extensión prohibida (ej. .webp)
                        ImagenTemporal::create([
                            'ruta_archivo' => "Este formato no es valido: " . $nombreOriginal,
                            'nombre_original' => $nombreOriginal,
                            'correo_origen' => $message->getFrom()[0]->mail,
                            'asunto' => $message->getSubject(),
                            'fecha_correo' => $message->getDate()[0]->format('Y-m-d H:i:s'),
                            'status' => 3
                        ]);
                        $this->warn("Archivo omitido (Formato no permitido): " . $nombreOriginal);
                    }
                }
            }

            $message->setFlag('Seen');
        }

        $this->info("Proceso terminado.");
    }
}