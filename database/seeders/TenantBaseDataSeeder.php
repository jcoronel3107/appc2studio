<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Tenant;

class TenantBaseDataSeeder extends Seeder
{
    public function run()
    {
        $tenants = Tenant::all();
        
        foreach ($tenants as $tenant) {
            echo "📦 Poblando datos para: {$tenant->subdomain}\n";
            
            $dbPath = database_path($tenant->database_path);
            
            config(['database.connections.tenant.database' => $dbPath]);
            DB::purge('tenant');
            DB::connection('tenant');
            
            $this->seedMaterials($tenant->id);
            $this->seedEquipments($tenant->id);
            $this->seedLabors($tenant->id);
            $this->seedTransports($tenant->id);
            
            echo "  ✅ Datos base cargados para {$tenant->subdomain}\n\n";
        }
    }
    
    private function seedMaterials($tenantId)
    {
        $materials = [
            ['code' => 'MAT001', 'name' => 'Cemento Portland Tipo I', 'category' => 'Aglomerantes', 'unit' => 'Bolsa', 'price' => 12.50, 'term' => '30 días', 'description' => 'Cemento Portland para uso general'],
            ['code' => 'MAT002', 'name' => 'Arena Fina', 'category' => 'Agregados', 'unit' => 'm3', 'price' => 45.00, 'term' => '15 días', 'description' => 'Arena fina para morteros'],
            ['code' => 'MAT003', 'name' => 'Grava Triturada', 'category' => 'Agregados', 'unit' => 'm3', 'price' => 55.00, 'term' => '15 días', 'description' => 'Grava de 1/2" para hormigón'],
            ['code' => 'MAT004', 'name' => 'Acero de Refuerzo', 'category' => 'Metales', 'unit' => 'Kg', 'price' => 2.80, 'term' => '45 días', 'description' => 'Acero corrugado grado 60'],
            ['code' => 'MAT005', 'name' => 'Tubería PVC', 'category' => 'Tuberías', 'unit' => 'm', 'price' => 3.20, 'term' => '15 días', 'description' => 'Tubería PVC para instalaciones'],
            ['code' => 'MAT006', 'name' => 'Ladrillo Hueco', 'category' => 'Mampostería', 'unit' => 'Unidad', 'price' => 0.45, 'term' => '10 días', 'description' => 'Ladrillo hueco de 8x12x24 cm'],
            ['code' => 'MAT007', 'name' => 'Pintura Látex', 'category' => 'Pinturas', 'unit' => 'Galón', 'price' => 18.90, 'term' => '20 días', 'description' => 'Pintura látex para interiores'],
            ['code' => 'MAT008', 'name' => 'Madera Pino', 'category' => 'Maderas', 'unit' => 'Tabla', 'price' => 8.50, 'term' => '15 días', 'description' => 'Madera de pino para encofrados'],
            ['code' => 'MAT009', 'name' => 'Clavos', 'category' => 'Ferretería', 'unit' => 'Kg', 'price' => 4.20, 'term' => '10 días', 'description' => 'Clavos de acero de 2"'],
            ['code' => 'MAT010', 'name' => 'Cable Eléctrico', 'category' => 'Eléctricos', 'unit' => 'm', 'price' => 1.50, 'term' => '15 días', 'description' => 'Cable eléctrico #12 AWG'],
        ];
        
        foreach ($materials as $material) {
            DB::connection('tenant')->table('materials')->updateOrInsert(
                ['code' => $material['code']],
                array_merge($material, ['tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()])
            );
        }
        
        echo "    ✅ Materiales: " . count($materials) . " registros\n";
    }
    
    private function seedEquipments($tenantId)
    {
        $equipments = [
            ['code' => 'EQU001', 'name' => 'Excavadora Caterpillar', 'category' => 'Maquinaria Pesada', 'unit' => 'Hora', 'price' => 120.00, 'term' => '30 días', 'description' => 'Excavadora de 320 HP'],
            ['code' => 'EQU002', 'name' => 'Retroexcavadora', 'category' => 'Maquinaria Pesada', 'unit' => 'Hora', 'price' => 85.00, 'term' => '30 días', 'description' => 'Retroexcavadora Case 580'],
            ['code' => 'EQU003', 'name' => 'Motoniveladora', 'category' => 'Maquinaria Pesada', 'unit' => 'Hora', 'price' => 95.00, 'term' => '30 días', 'description' => 'Motoniveladora CAT 140'],
            ['code' => 'EQU004', 'name' => 'Rodillo Vibratorio', 'category' => 'Maquinaria Pesada', 'unit' => 'Hora', 'price' => 75.00, 'term' => '30 días', 'description' => 'Rodillo vibratorio de 10 toneladas'],
            ['code' => 'EQU005', 'name' => 'Mezcladora de Concreto', 'category' => 'Maquinaria', 'unit' => 'Día', 'price' => 45.00, 'term' => '15 días', 'description' => 'Mezcladora de 1 bolsa'],
            ['code' => 'EQU006', 'name' => 'Vibrador de Concreto', 'category' => 'Herramientas', 'unit' => 'Día', 'price' => 25.00, 'term' => '10 días', 'description' => 'Vibrador eléctrico de alta frecuencia'],
            ['code' => 'EQU007', 'name' => 'Compresor de Aire', 'category' => 'Herramientas', 'unit' => 'Día', 'price' => 35.00, 'term' => '15 días', 'description' => 'Compresor de 185 CFM'],
            ['code' => 'EQU008', 'name' => 'Generador Eléctrico', 'category' => 'Equipos', 'unit' => 'Día', 'price' => 50.00, 'term' => '15 días', 'description' => 'Generador de 50 kW'],
        ];
        
        foreach ($equipments as $equipment) {
            DB::connection('tenant')->table('equipments')->updateOrInsert(
                ['code' => $equipment['code']],
                array_merge($equipment, ['tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()])
            );
        }
        
        echo "    ✅ Equipos: " . count($equipments) . " registros\n";
    }
    
    private function seedLabors($tenantId)
    {
        $labors = [
            ['code' => 'LAB001', 'name' => 'Albañil', 'category' => 'Oficial', 'unit' => 'Jornal', 'tarifa_hora' => 8.50, 'tarifa_dia' => 68.00, 'term' => '1 día', 'description' => 'Albañil especializado en construcción'],
            ['code' => 'LAB002', 'name' => 'Peón', 'category' => 'Ayudante', 'unit' => 'Jornal', 'tarifa_hora' => 5.50, 'tarifa_dia' => 44.00, 'term' => '1 día', 'description' => 'Peón de construcción'],
            ['code' => 'LAB003', 'name' => 'Yesero', 'category' => 'Oficial', 'unit' => 'Jornal', 'tarifa_hora' => 7.50, 'tarifa_dia' => 60.00, 'term' => '1 día', 'description' => 'Yesero especializado en acabados'],
            ['code' => 'LAB004', 'name' => 'Fierrero', 'category' => 'Oficial', 'unit' => 'Jornal', 'tarifa_hora' => 9.00, 'tarifa_dia' => 72.00, 'term' => '1 día', 'description' => 'Fierrero especializado en acero de refuerzo'],
            ['code' => 'LAB005', 'name' => 'Encofrador', 'category' => 'Oficial', 'unit' => 'Jornal', 'tarifa_hora' => 9.50, 'tarifa_dia' => 76.00, 'term' => '1 día', 'description' => 'Encofrador especializado en estructuras'],
            ['code' => 'LAB006', 'name' => 'Pintor', 'category' => 'Oficial', 'unit' => 'Jornal', 'tarifa_hora' => 7.00, 'tarifa_dia' => 56.00, 'term' => '1 día', 'description' => 'Pintor de construcción'],
            ['code' => 'LAB007', 'name' => 'Electricista', 'category' => 'Técnico', 'unit' => 'Jornal', 'tarifa_hora' => 10.00, 'tarifa_dia' => 80.00, 'term' => '1 día', 'description' => 'Electricista especializado'],
            ['code' => 'LAB008', 'name' => 'Plomero', 'category' => 'Técnico', 'unit' => 'Jornal', 'tarifa_hora' => 9.50, 'tarifa_dia' => 76.00, 'term' => '1 día', 'description' => 'Plomero especializado'],
        ];
        
        foreach ($labors as $labor) {
            DB::connection('tenant')->table('labors')->updateOrInsert(
                ['code' => $labor['code']],
                array_merge($labor, ['tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()])
            );
        }
        
        echo "    ✅ Mano de Obra: " . count($labors) . " registros\n";
    }
    
    private function seedTransports($tenantId)
    {
        $transports = [
            ['code' => 'TRA001', 'name' => 'Camión Volquete', 'category' => 'Pesado', 'unit' => 'Viaje', 'price' => 150.00, 'term' => '1 día', 'description' => 'Camión volquete de 10 m3'],
            ['code' => 'TRA002', 'name' => 'Camión Mixer', 'category' => 'Pesado', 'unit' => 'Viaje', 'price' => 180.00, 'term' => '1 día', 'description' => 'Camión mixer para concreto'],
            ['code' => 'TRA003', 'name' => 'Camión Cisterna', 'category' => 'Pesado', 'unit' => 'Viaje', 'price' => 120.00, 'term' => '1 día', 'description' => 'Camión cisterna para agua'],
            ['code' => 'TRA004', 'name' => 'Camión Plataforma', 'category' => 'Pesado', 'unit' => 'Viaje', 'price' => 200.00, 'term' => '2 días', 'description' => 'Camión plataforma para transporte de maquinaria'],
        ];
        
        foreach ($transports as $transport) {
            DB::connection('tenant')->table('transports')->updateOrInsert(
                ['code' => $transport['code']],
                array_merge($transport, ['tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()])
            );
        }
        
        echo "    ✅ Transportes: " . count($transports) . " registros\n";
    }
}