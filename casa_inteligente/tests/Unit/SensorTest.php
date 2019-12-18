<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SensorTest extends DuskTestCase
{

    public function test_não_deveria_achar_sensor()
    {
        $response = $this->get('/api/sensor/');

        $response->assertStatus(404);
    }

    public function test_deveria_criar_um_sensor()
    {
        $data = [
            'nome' => "teste",
            'tipo' => "temperatura",
        ];
        $this->post(route('api.store_sensors'), $data)
            ->assertStatus(201)
            ->assertSee("Sensor criado com sucesso!");
    }

    public function test_deveria_listar_todos_os_sensores()
    {
        $response = $this->get('/api/sensor/');
        $response->assertStatus(200);
    }

    public function test_deveria_listar_um_sensor_específico()
    {
        $response = $this->get('/api/sensor/1');
        $response->assertStatus(200);
    }
    public function test_deveria_remover_um_sensor_específico()
    {
        $response = $this->delete('/api/sensor/4');
        $response->assertSee("Sensor removido com sucesso!");
    }

}
