<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        // Eliminar contenidos que ya no se usan
        SiteContent::whereIn('key', [
            'entradas_titulo', 'programacion_titulo', 'aliados_titulo',
            'contacto_titulo', 'contacto_subtitulo', 'footer_copy',
        ])->delete();

        $contents = [
            // 1. Hero
            [
                'key' => 'hero_parrafo_1',
                'label' => 'Párrafo 1',
                'section' => 'Hero',
                'type' => 'textarea',
                'value' => 'Cada avance en Enfermedades Raras tiene un rostro, una historia y una lucha silenciosa detrás. Nada de lo que hoy existe ha sido casualidad: ha sido fruto de personas, instituciones e iniciativas que no se rindieron cuando el camino fue más difícil.',
            ],
            [
                'key' => 'hero_parrafo_2',
                'label' => 'Párrafo 2',
                'section' => 'Hero',
                'type' => 'textarea',
                'value' => 'La Segunda Gala de Reconocimientos FECOER es el espacio para decir gracias, para visibilizar a quienes defienden la vida, el acceso a la salud y la dignidad de las personas con Enfermedades Raras en Colombia.',
            ],

            // 2. Evento
            [
                'key' => 'hero_fecha',
                'label' => 'Fecha del evento',
                'section' => 'Evento',
                'type' => 'text',
                'value' => 'Viernes 27 de febrero de 2026 - 6:00 p. m.',
            ],
            [
                'key' => 'hero_lugar',
                'label' => 'Lugar del evento',
                'section' => 'Evento',
                'type' => 'text',
                'value' => 'Hotel Sonesta, Bogotá.',
            ],

            // 3. Entradas
            [
                'key' => 'entradas_nota',
                'label' => 'Nota de entradas',
                'section' => 'Entradas',
                'type' => 'textarea',
                'value' => 'Tu aporte nos ayudará a continuar trabajando por las personas con enfermedades raras.<br><strong>¡Gracias por ser parte de esta causa!</strong>',
            ],

            // 4. Footer - Redes sociales
            [
                'key' => 'facebook_url',
                'label' => 'Facebook URL',
                'section' => 'Redes Sociales',
                'type' => 'text',
                'value' => '#',
            ],
            [
                'key' => 'x_url',
                'label' => 'X (Twitter) URL',
                'section' => 'Redes Sociales',
                'type' => 'text',
                'value' => '#',
            ],
            [
                'key' => 'instagram_url',
                'label' => 'Instagram URL',
                'section' => 'Redes Sociales',
                'type' => 'text',
                'value' => '#',
            ],
            [
                'key' => 'tiktok_url',
                'label' => 'TikTok URL',
                'section' => 'Redes Sociales',
                'type' => 'text',
                'value' => '#',
            ],

            // 5. ePayco - Pasarela de pagos
            [
                'key' => 'epayco_public_key',
                'label' => 'Llave pública',
                'section' => 'ePayco',
                'type' => 'text',
                'value' => '',
            ],
            [
                'key' => 'epayco_private_key',
                'label' => 'Llave privada',
                'section' => 'ePayco',
                'type' => 'text',
                'value' => '',
            ],
            [
                'key' => 'epayco_p_cust_id',
                'label' => 'P_CUST_ID_CLIENTE',
                'section' => 'ePayco',
                'type' => 'text',
                'value' => '',
            ],
            [
                'key' => 'epayco_p_key',
                'label' => 'P_KEY',
                'section' => 'ePayco',
                'type' => 'text',
                'value' => '',
            ],
            [
                'key' => 'epayco_test_mode',
                'label' => 'Modo de prueba',
                'section' => 'ePayco',
                'type' => 'text',
                'value' => 'true',
            ],

            // 6. Streaming
            [
                'key' => 'streaming_youtube_url',
                'label' => 'URL de YouTube',
                'section' => 'Streaming',
                'type' => 'text',
                'value' => '',
            ],
            [
                'key' => 'streaming_title',
                'label' => 'Título del streaming',
                'section' => 'Streaming',
                'type' => 'text',
                'value' => 'Segunda Gala FECOER - En Vivo',
            ],
            [
                'key' => 'streaming_description',
                'label' => 'Descripción',
                'section' => 'Streaming',
                'type' => 'textarea',
                'value' => '',
            ],
            [
                'key' => 'streaming_enabled',
                'label' => 'Streaming activo',
                'section' => 'Streaming',
                'type' => 'text',
                'value' => 'false',
            ],
        ];

        foreach ($contents as $content) {
            SiteContent::updateOrCreate(
                ['key' => $content['key']],
                $content
            );
        }
    }
}
