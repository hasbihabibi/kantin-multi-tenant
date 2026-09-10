<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Canteen;
use App\Models\Tenant;
use App\Models\Menu;

class DemoCanteenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $canteen = Canteen::create([
            'code' => 'K-PARWIS',
            'name' => 'Kantin Pariwisata'
        ]);

        $tenant1 = Tenant::create([
            'canteen_id' => $canteen->id,
            'code' => 'T-01',
            'slug' => 'sfc',
            'display_name' => 'SFC',
            'status' => 'active',
        ]);

        Menu::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Ayam Geprek',
            'price_amount' => 10000,
            'is_available' => true,
        ]);

        $tenant2 = Tenant::create([
            'canteen_id' => $canteen->id,
            'code' => 'T-02',
            'slug' => 'secawan-rindu',
            'display_name' => 'Secawan Rindu',
            'status' => 'active',
        ]);

        Menu::create([
            'tenant_id' => $tenant2->id,
            'name' => 'Es Boba',
            'price_amount' => 7000,
            'is_available' => true,
        ]);
    }
}
