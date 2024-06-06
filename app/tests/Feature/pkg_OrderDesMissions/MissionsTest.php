<?php

namespace Tests\Feature\pkg_competences;

use Tests\TestCase;
use App\Models\pkg_OrderDesMissions\Mission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MissionsTest extends TestCase
{
    use DatabaseTransactions;

    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Mission;
    }

    public function test_paginate_technologies(): void
    {
        $technologies = $this->model->paginate(2);
        $this->assertNotNull($technologies);
        $this->assertNotEmpty($technologies);
    }

    public function test_create_technologies(): void
    {
        $data = [
            'nom' => 'html',
            'description' => 'est le langage de balisage standard',
            'categorie_technologies_id' => 1,
            'competence_id' => 1,
        ];

        $this->model->create($data);
        $this->assertDatabaseHas('technologies', ['nom' => $data['nom']]);
    }


    public function test_update_technologies(): void
    {
        $existingTechnologies = $this->model->create([
            'nom' => 'html',
            'description' => 'est le langage de balisage standard',
            'categorie_technologies_id' => 1,
            'competence_id' => 1,
        ]);

        $newName = 'css';
        $existingTechnologies->update(['nom' => $newName]);

        $this->assertEquals($newName, $existingTechnologies->nom);
        $this->assertDatabaseHas('technologies', ['nom' => $newName]);

    }

    public function test_delete_technologies(): void
    {
        $existingTechnologies = $this->model->create([
            'nom' => 'html',
            'description' => 'est le langage de balisage standard',
            'categorie_technologies_id' => 1,
            'competence_id' => 1,
        ]);

        $existingTechnologies->delete();

        $this->assertDatabaseMissing('technologies', ['id' => $existingTechnologies->id]);
    }
}
