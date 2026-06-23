<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TenantBaseSeeder extends Seeder
{
    public function run()
    {
        // ============================================================
        // MATERIALES BASE
        // ============================================================
        $materials = [
            ['code' => 'MAT001', 'name' => 'Cemento Portland', 'unit' => 'bolsa', 'price' => 25.50, 'category' => 'Construcción', 'termino' => 'POR CONTRATO'],
            ['code' => 'MAT002', 'name' => 'Arena Fina', 'unit' => 'm3', 'price' => 45.00, 'category' => 'Construcción', 'termino' => 'CONTADO'],
            ['code' => 'MAT003', 'name' => 'Grava', 'unit' => 'm3', 'price' => 35.00, 'category' => 'Construcción', 'termino' => 'CONTADO'],
            ['code' => 'MAT004', 'name' => 'Acero de Refuerzo', 'unit' => 'kg', 'price' => 1.99, 'category' => 'Estructural', 'termino' => 'POR CONTRATO'],
            ['code' => 'MAT005', 'name' => 'Tubería PVC 315mm', 'unit' => 'm', 'price' => 11.92, 'category' => 'Alcantarillado', 'termino' => 'POR CONTRATO'],
            ['code' => 'MAT006', 'name' => 'Tubería PVC 200mm', 'unit' => 'm', 'price' => 6.83, 'category' => 'Alcantarillado', 'termino' => 'POR CONTRATO'],
            ['code' => 'MAT007', 'name' => 'Tubería PVC 160mm', 'unit' => 'm', 'price' => 4.26, 'category' => 'Alcantarillado', 'termino' => 'POR CONTRATO'],
            ['code' => 'MAT008', 'name' => 'Cemento', 'unit' => 'bolsa', 'price' => 8.50, 'category' => 'Construcción', 'termino' => 'CONTADO'],
            ['code' => 'MAT009', 'name' => 'Madera', 'unit' => 'pulgadas', 'price' => 2.50, 'category' => 'Estructural', 'termino' => 'CONTADO'],
            ['code' => 'MAT010', 'name' => 'Pintura', 'unit' => 'galón', 'price' => 35.00, 'category' => 'Acabados', 'termino' => 'CONTADO'],
        ];

        foreach ($materials as $material) {
            DB::table('materials')->insert($material);
        }
        $this->command->info('✅ Materiales base creados: ' . count($materials));

        // ============================================================
        // EQUIPOS BASE
        // ============================================================
        $equipments = [
            ['code' => 'EQ001', 'name' => 'Excavadora', 'category' => 'Pesada', 'unit' => 'hora', 'price' => 85.00, 'termino' => 'POR CONTRATO'],
            ['code' => 'EQ002', 'name' => 'Retroexcavadora', 'category' => 'Pesada', 'unit' => 'hora', 'price' => 65.00, 'termino' => 'CONTADO'],
            ['code' => 'EQ003', 'name' => 'Motoniveladora', 'category' => 'Pesada', 'unit' => 'hora', 'price' => 75.00, 'termino' => 'POR CONTRATO'],
            ['code' => 'EQ004', 'name' => 'Rodillo Vibratorio', 'category' => 'Pesada', 'unit' => 'hora', 'price' => 45.00, 'termino' => 'CONTADO'],
            ['code' => 'EQ005', 'name' => 'Mezcladora de Cemento', 'category' => 'Liviana', 'unit' => 'hora', 'price' => 25.00, 'termino' => 'ALQUILER'],
            ['code' => 'EQ006', 'name' => 'Camión Volquete', 'category' => 'Transporte', 'unit' => 'hora', 'price' => 55.00, 'termino' => 'POR CONTRATO'],
            ['code' => 'EQ007', 'name' => 'Compresor de Aire', 'category' => 'Liviana', 'unit' => 'hora', 'price' => 30.00, 'termino' => 'ALQUILER'],
            ['code' => 'EQ008', 'name' => 'Generador Eléctrico', 'category' => 'Liviana', 'unit' => 'hora', 'price' => 20.00, 'termino' => 'CONTADO'],
        ];

        foreach ($equipments as $equipment) {
            DB::table('equipments')->insert($equipment);
        }
        $this->command->info('✅ Equipos base creados: ' . count($equipments));

        // ============================================================
        // MANO DE OBRA BASE
        // ============================================================
        $labors = [
            ['code' => 'LAB001', 'name' => 'Albañil', 'category' => 'Oficial', 'unit' => 'hora', 'hourly_rate' => 5.50, 'daily_rate' => 44.00, 'termino' => 'POR CONTRATO'],
            ['code' => 'LAB002', 'name' => 'Peón', 'category' => 'Ayudante', 'unit' => 'hora', 'hourly_rate' => 4.25, 'daily_rate' => 34.00, 'termino' => 'CONTADO'],
            ['code' => 'LAB003', 'name' => 'Yesero', 'category' => 'Oficial', 'unit' => 'hora', 'hourly_rate' => 6.00, 'daily_rate' => 48.00, 'termino' => 'POR CONTRATO'],
            ['code' => 'LAB004', 'name' => 'Fierrero', 'category' => 'Oficial', 'unit' => 'hora', 'hourly_rate' => 5.80, 'daily_rate' => 46.40, 'termino' => 'CONTRATO'],
            ['code' => 'LAB005', 'name' => 'Encofrador', 'category' => 'Oficial', 'unit' => 'hora', 'hourly_rate' => 5.80, 'daily_rate' => 46.40, 'termino' => 'CONTRATO'],
            ['code' => 'LAB006', 'name' => 'Pintor', 'category' => 'Oficial', 'unit' => 'hora', 'hourly_rate' => 5.00, 'daily_rate' => 40.00, 'termino' => 'POR CONTRATO'],
            ['code' => 'LAB007', 'name' => 'Electricista', 'category' => 'Especializado', 'unit' => 'hora', 'hourly_rate' => 6.50, 'daily_rate' => 52.00, 'termino' => 'POR CONTRATO'],
            ['code' => 'LAB008', 'name' => 'Plomero', 'category' => 'Especializado', 'unit' => 'hora', 'hourly_rate' => 6.00, 'daily_rate' => 48.00, 'termino' => 'CONTADO'],
        ];

        foreach ($labors as $labor) {
            DB::table('labors')->insert($labor);
        }
        $this->command->info('✅ Mano de obra base creados: ' . count($labors));

        // ============================================================
        // TRANSPORTE BASE
        // ============================================================
        $transports = [
            ['code' => 'TRA001', 'name' => 'Camión Volquete 15m3', 'category' => 'Pesado', 'unit' => 'hora', 'price' => 45.00, 'termino' => 'POR CONTRATO'],
            ['code' => 'TRA002', 'name' => 'Camión Mixer', 'category' => 'Hormigón', 'unit' => 'hora', 'price' => 35.00, 'termino' => 'CONTADO'],
            ['code' => 'TRA003', 'name' => 'Camión Cisterna', 'category' => 'Líquidos', 'unit' => 'hora', 'price' => 40.00, 'termino' => 'POR CONTRATO'],
            ['code' => 'TRA004', 'name' => 'Camión Plataforma', 'category' => 'Carga', 'unit' => 'hora', 'price' => 30.00, 'termino' => 'CONTADO'],
        ];

        foreach ($transports as $transport) {
            DB::table('transports')->insert($transport);
        }
        $this->command->info('✅ Transporte base creados: ' . count($transports));

        $this->command->info('🎉 Datos base creados exitosamente!');
    }
}