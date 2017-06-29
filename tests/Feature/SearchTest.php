<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Providers\Auth\GoogleOAuthAuthenticable;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Tests results of API api/search/
 */
class SearchTest extends TestCase {

    use WithoutMiddleware;

    /**
     * text for message in successful (HTTP 200) queries
     * @var type 
     */
    private $okMessage = 'Results';

    /**
     * Search artists with "0" in name or handle
     * /search
     *
     * @return void
     */
    public function testOneResult() {
        $this->prepUser();

        $response = $this->json('GET', 'api/search', ['type' => 'artist', 'name' => 'Ben',]);

        $response
                ->assertStatus(200)
                ->assertJson([
                    'message' => $this->okMessage,
            ]);
        $num_results = 1;
        $this->assertEquals($num_results, count($response->decodeResponseJson()['data']));
    }

    /**
     * Search artists with "0" in name or handle
     * /search
     *
     * @return void
     */
    public function testZero() {
        $this->prepUser();

        $response = $this->json('GET', 'api/search', ['type' => 'artist', 'name' => '0',]);

        $response
                ->assertStatus(200)
                ->assertJson([
                    'message' => $this->okMessage,
            ]);
        $num_results = 63;
        $this->assertEquals($num_results, count($response->decodeResponseJson()['data']));
    }

    public function testWrongType() {
        
        $message = 'Wrong value for parameter "type". Use "artist"';
        // wrong case for "artist"
        $response = $this->json('GET', 'api/search', ['type' => 'aRtist']);

        $response
                ->assertStatus(422)
                ->assertJson([
                    'message' => $message,
            ]);

        // wrong type
        $response = $this->json('GET', 'api/search', ['type' => 'band']);

        $response
                ->assertStatus(422)
                ->assertJson([
                    'message' => $message,
            ]);

    }

    public function testCaseInsensitiveField() {
        $this->prepUser();

        // field "type" is OK to be case-insensitive
        $response = $this->json('GET', 'api/search', ['tYpe' => 'artist']);

        $response
                ->assertStatus(200)
                ->assertJson([
                    'message' => $this->okMessage,
            ]);
    }
    
    /**
     * Provides mock GoogleOAuthAuthenticable object, returned by Auth::user(), identifying user.
     */
    private function prepUser() {
        Auth::shouldReceive('user')
                    ->andReturn(new GoogleOAuthAuthenticable(['name'=>'JoeRandomTester', 'sub'=>'id012345']));
    }

}
