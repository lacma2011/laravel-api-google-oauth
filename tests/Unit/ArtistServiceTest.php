<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Artist;
use App\Models\Artist as ArtistModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Unit tests for App\Services\Artist, which retrieves artists 
 */
class ArtistServiceTest extends TestCase {

    /**
     * An App\Services\Artist object
     * 
     * @var Artist 
     */
    private $artistService;

    protected function setUp() {
        parent::setUp();
        $this->artistService = new Artist(new ArtistModel());
    }

    /**
     * Get all records from test DB.
     *
     * @return void
     */
    public function testGetAll() {
        $count = 300;

        $results = $this->artistService->get();
        $this->assertTrue(count($results) === $count);

        $results = $this->artistService->get(NULL);
        $this->assertTrue(count($results) === $count);

        $results = $this->artistService->get('');
        $this->assertTrue(count($results) === $count);
    }

    /**
     * Get records with a 0 in name/handle.
     *
     * @return void
     */
    public function testGetZero() {
        $count = 63;
        $results = $this->artistService->get('0');
        $this->assertTrue(count($results) === $count);
    }

    /**
     * Get records with a "rr" in name/handle. Case-insensitive.
     *
     * @return void
     */
    public function testGetRR() {
        $count = 3;
        $results = $this->artistService->get('Rr');
        $this->assertTrue(count($results) === $count);

        $results_saved = array(
            0 =>
            array(
                'name' => '.RR',
                'handle' => 'RR',
            ),
            1 =>
            array(
                'name' => '01 Waiting for the Hurricane',
                'handle' => '01_Waiting_for_the_Hurricane',
            ),
            2 =>
            array(
                'name' => 'A Minha Embala (Aline Frazão e César Herranz)',
                'handle' => 'A_Minha_Embala_Aline_Frazo_e_Csar_Herranz',
            ),
        );
        
        $this->assertEquals($results->toArray(), $results_saved);
    }

}
