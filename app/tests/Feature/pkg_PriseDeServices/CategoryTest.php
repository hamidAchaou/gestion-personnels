<?php

namespace Tests\Feature\pkg_PriseDeServices;

use App\Models\pkg_Parametres\Avancement;
use App\Models\pkg_PriseDeServices\Personnel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\pkg_PriseDeServices\CategoryRepository;
use Tests\TestCase;
use App\Exceptions\pkg_PriseDeServices\CategoryAlreadyExistException;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;
    protected $categoryRepository;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryRepository = new CategoryRepository(new Avancement);
        $this->user = Personnel::factory()->create();
    }

    public function test_get_paginated_categories()
    {
        $this->actingAs($this->user);
        $category = Avancement::factory()->create();
        $categories = $this->categoryRepository->paginate();
        $this->assertNotNull($categories);
    }


    public function test_create_category()
    {
        $this->actingAs($this->user);
        $categoryData = [
            'echell' => 100,
            'date_debut' => '2023-01-01',
            'date_fin' => '2023-01-01',
            'personnel_id' => 1,
            
        ];


        $category = $this->categoryRepository->create($categoryData);
        $this->assertEquals($categoryData['echell'], $category->echell);
    }

    public function test_create_category_already_exist()
    {
        $this->actingAs($this->user);

        $category = Avancement::factory()->create();
        $categoryData = [
            'echell' => 1,
            'date_debut' => 2023-02-21,
            'date_fin' => 2024-02-21,
            'personnel_id' => 1,
        ];

        try {
            $category = $this->categoryRepository->create($categoryData);
            $this->fail('Expected personnelException was not thrown');
        } catch (CategoryAlreadyExistException $e) {
            $this->assertEquals(__('La categorie existe déjà'), $e->getMessage());
        } catch (\Exception $e) {
            $this->fail('Unexpected exception was thrown: ' . $e->getMessage());
        }
    }


    public function test_update_data()
    {
        $this->actingAs($this->user);
        $category = Avancement::factory()->create();
        $categoryData = [
            'echell' => 1,
            'date_debut' => '2024-02-23',
            'date_fin' => '2024-02-21',
            'personnel_id' => 1,
        ];
        $this->categoryRepository->update($category->id, $categoryData);
        $this->assertDatabaseHas('avancements', $categoryData);
    }


    public function test_delete_category()
    {
        $this->actingAs($this->user);
        $category = Avancement::factory()->create();
        $this->categoryRepository->destroy($category->id);
        $this->assertDatabaseMissing('users', ['id' => $category->id]);
    }


    public function test_category_search()
    {
        $this->actingAs($this->user);
        $categoryData = [
            'echell' => 52,
            'date_debut' => '2022-02-21',
            'date_fin' => '2025-02-21',
            'personnel_id' => 1,
        ];
        $this->categoryRepository->create($categoryData);
        $searchValue = 52;
        $searchResults = $this->categoryRepository->searchData($searchValue);
        $this->assertTrue($searchResults->contains('echell', $searchValue));
    }

}