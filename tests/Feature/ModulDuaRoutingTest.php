<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModulDuaRoutingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_guest_diarahkan_ke_halaman_saat_buka_admin()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function test_guest_diarahkan_ke_login_saat_buka_tenant()
    {
        $response = $this->get('/tenant/demo/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function test_halaman_pelanggan_bisa_diakses_publik()
    {
        $response = $this->get('/kantin/pusat/home');
        $response->assertStatus(200);
    }
}
