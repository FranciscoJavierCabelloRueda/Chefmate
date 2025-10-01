<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Receta;

class RecetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recetas = [
            [
                'titulo'       => 'Tortilla de patatas',
                'descripcion'  => 'La clásica tortilla española con huevo y patatas.',
                'ingredientes' => "4 huevos\n3 patatas medianas\nSal\nAceite de oliva",
                'pasos'        => "Pelar y cortar las patatas.\nFreír en abundante aceite.\nBatir los huevos.\nMezclar y cuajar en sartén.",
                'foto'         => 'recetas/tortilla.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Paella Valenciana',
                'descripcion'  => 'Arroz tradicional con conejo, pollo y judías verdes.',
                'ingredientes' => "Arroz\nPollo\nConejo\nJudías verdes\nGarrofón\nTomate\nAceite\nSal",
                'pasos'        => "Sofreír carne.\nAñadir verduras.\nIncorporar arroz y caldo.\nCocer 20 minutos.",
                'foto'         => 'recetas/paella.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Gazpacho Andaluz',
                'descripcion'  => 'Sopa fría de tomate, pepino y pimiento.',
                'ingredientes' => "1kg tomates maduros\n1 pepino\n1 pimiento verde\n1 diente de ajo\nAceite\nVinagre\nSal",
                'pasos'        => "Trocear ingredientes.\nTriturar todo.\nPasar por colador.\nServir frío.",
                'foto'         => 'recetas/gazpacho.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Croquetas de jamón',
                'descripcion'  => 'Croquetas caseras de bechamel y jamón.',
                'ingredientes' => "Leche\nHarina\nMantequilla\nJamón serrano\nHuevo\nPan rallado",
                'pasos'        => "Preparar bechamel con jamón.\nEnfriar y dar forma.\nRebozar y freír.",
                'foto'         => 'recetas/croquetas.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Flan de huevo',
                'descripcion'  => 'Postre tradicional con caramelo líquido.',
                'ingredientes' => "4 huevos\n500ml leche\n100g azúcar\nCaramelo líquido",
                'pasos'        => "Batir huevos y azúcar.\nAñadir leche.\nVerter en molde con caramelo.\nHornear al baño maría.",
                'foto'         => 'recetas/flan.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Ensaladilla rusa',
                'descripcion'  => 'Patata, zanahoria, guisantes y mayonesa.',
                'ingredientes' => "3 patatas\n2 zanahorias\n100g guisantes\n2 huevos\nAtún\nMayonesa",
                'pasos'        => "Cocer los ingredientes.\nTrocear todo.\nMezclar con atún y mayonesa.",
                'foto'         => 'recetas/ensaladilla.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Salmorejo cordobés',
                'descripcion'  => 'Sopa espesa de tomate con pan, ajo y aceite.',
                'ingredientes' => "1kg tomates\n200g pan del día anterior\n1 diente de ajo\nAceite de oliva\nSal\nHuevo duro\nJamón picado",
                'pasos'        => "Triturar tomates con pan y ajo.\nAñadir aceite y sal.\nServir con huevo y jamón.",
                'foto'         => 'recetas/salmorejo.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Pollo al ajillo',
                'descripcion'  => 'Pollo frito con ajo y vino blanco.',
                'ingredientes' => "1 pollo troceado\n6 dientes de ajo\nVino blanco\nAceite\nSal\nPimienta",
                'pasos'        => "Freír ajos.\nAñadir pollo y dorar.\nIncorporar vino y cocinar a fuego lento.",
                'foto'         => 'recetas/pollo-ajillo.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Empanada gallega',
                'descripcion'  => 'Masa rellena de atún, pimiento y cebolla.',
                'ingredientes' => "Masa de empanada\n2 latas de atún\n1 cebolla\n1 pimiento rojo\nTomate frito",
                'pasos'        => "Preparar sofrito.\nRellenar la masa.\nHornear hasta dorar.",
                'foto'         => 'recetas/empanada.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Crema de calabaza',
                'descripcion'  => 'Crema suave de calabaza y zanahoria.',
                'ingredientes' => "500g calabaza\n2 zanahorias\n1 cebolla\nCaldo de verduras\nAceite\nSal",
                'pasos'        => "Sofreír cebolla.\nAñadir verduras y caldo.\nCocinar y triturar.",
                'foto'         => 'recetas/crema-calabaza.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Huevos rellenos',
                'descripcion'  => 'Huevos duros rellenos de atún y mayonesa.',
                'ingredientes' => "6 huevos\n2 latas de atún\nMayonesa\nPimiento morrón",
                'pasos'        => "Cocer huevos.\nPartir y vaciar yemas.\nMezclar con atún y mayonesa.\nRellenar y decorar.",
                'foto'         => 'recetas/huevos-rellenos.png',
                'idUsu'        => 1,
            ],
            [
                'titulo'       => 'Natillas caseras',
                'descripcion'  => 'Postre cremoso con leche, huevos y canela.',
                'ingredientes' => "500ml leche\n4 yemas\n100g azúcar\n1 cucharada de maicena\nCanela en rama\nGalletas",
                'pasos'        => "Calentar leche con canela.\nMezclar yemas con azúcar y maicena.\nCocinar todo sin hervir.\nServir con galleta.",
                'foto'         => 'recetas/natillas.png',
                'idUsu'        => 1,
            ]
        ];

        foreach ($recetas as $receta) {
            Receta::create($receta);
        }
    }
}