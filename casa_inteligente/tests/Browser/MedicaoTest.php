<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MedicaoTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

        public function test_deveria_listar_todos_as_medicoes()
        {
            $response = $this->get('/api/medicao/');
            $response->assertStatus(200);
        }

        public function test_deveria_listar_uma_medicao_específico()
        {
            $response = $this->get('/api/medicao/1');
            $response->assertStatus(200);
        }
        public function test_deveria_remover_uma_medicao_específico()
        {
            $response = $this->delete('/api/medicao/1');
            $response->assertSee("Medição removida com sucesso!");
        }
    
}
