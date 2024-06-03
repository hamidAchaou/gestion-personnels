<?php

namespace Tests\Feature\pkg_Conges;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\CongesRepository;
use App\Models\pkg_Conges\Conge;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CongeTest extends TestCase
{
    use DatabaseTransactions;

    protected $congeRepository;
    protected $user;
    protected $motif;

    protected function setUp(): void
    {
        parent::setUp();
        $this->congeRepository = new CongesRepository(new Conge());
        $this->user = User::factory()->create();
        $this->motif = Motif::factory()->create();
    }

    public function test_paginate_conges()
    {
        $congeData = [
            'date_debut' => '2024-05-14',
            'date_fin' => "2024-05-15",
            'motif_id' => $this->motif->id,
        ];

        $conge = Conge::create($congeData)->users()->attach($this->user->id);
        $conges = $this->congeRepository->paginate();
        $this->assertDatabaseHas('conges', $congeData);

        // $this->assertDatabaseHas('personnels_conges', [
        //     'conges_id' => $conge->id,
        //     'user_id' => $this->user->id,
        // ]);
    }


    public function test_create_conge()
    {
        $congeData = [
            'date_debut' => '2024-05-14',
            'date_fin' => "2024-05-15",
            'motif_id' => $this->motif->id,
        ];

        $conge = Conge::create($congeData)->users()->attach($this->user->id);
        $this->assertDatabaseHas('conges', $congeData);
    }

    public function test_prevent_create_conge_already_exists()
    {
        $congeData = [
            'date_debut' => '2024-05-14',
            'date_fin' => "2024-05-15",
            'motif_id' => $this->motif->id, // Corrected to use motif_id instead of the entire $this->motif object
        ];
    
        $existingConge = Conge::create($congeData)->users()->attach($this->user->id);
        $congeData = [
            'user_id' => $this->user->id,
            'date_debut' => $congeData['date_debut'],
            'date_fin' => $congeData['date_fin'], 
            'motif_id' => $this->motif->id, // Corrected to use motif_id instead of the entire $this->motif object
        ];
    
        try {
            $this->congeRepository->create($congeData); // Attempt to create a conge with duplicated date_debut and date_fin
            $this->fail('Expected Exceptions was not thrown');
        } catch (CongeAlreadyExistException $e) {
            $this->assertEquals(__('Autorisation/conges/message.createcongeException'), $e->getMessage());
            // $this->fail('Unexpected exception was thrown: ' . $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Unexpected exception was thrown: ' . $e->getMessage());
        }
    }
    

    public function test_update_conge()
    {
        $congeData = [
            'date_debut' => '2024-05-14',
            'date_fin' => "2024-05-15",
            'motif_id' => $this->motif->id,
        ];

        $conge = Conge::create($congeData)->users()->attach($this->user->id);
        $updateData = [
            'date_debut' => '2024-05-16',
            'date_fin' => '2024-05-17',
            'motif_id' => $this->motif->id,
        ];
        $this->congeRepository->update($conge->id, $updateData);
        $this->assertDatabaseHas('conges', $updateData);
    }

    public function test_delete_conge()
    {
        $conge = Conge::factory()->create();
        $this->congeRepository->destroy($conge->id);
        $this->assertDatabaseMissing('conges', ['id' => $conge->id]);
    }

    public function test_searchData_conge()
    {
        $congeData = [
            'date_debut' => '2024-05-14',
            'date_fin' => "2024-05-15",
            'motif_id' => $this->motif->id,
        ];

        $conge = Conge::create($congeData)->users()->attach($this->user->id);
        $searchValue = '2024-05-14';
        $searchResults = $this->congeRepository->searchData($searchValue);
        $this->assertTrue($searchResults->contains('date_debut', $searchValue));
    }
}
