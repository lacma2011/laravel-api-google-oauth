<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Test with Middleware enabled and situations with an invalid token. valid token tests are not
 * possible until test runner can get valid tokens through a server OAuth request.
 */
class AuthorizationTest extends TestCase {

    /**
     * Search artists API
     * /api/search
     *
     * @return void
     */
    public function testNoToken() {

        $response = $this->json('GET', 'api/search', ['type' => 'artist', 'name' => ""]);

        $response
                ->assertStatus(401);
    }

    /**
     * Error 401 with error "ID Token failed validation."
     */
    public function testInvalidToken() {
        $message = "ID Token failed validation.";
        $bad_token =<<<HEREDOC
eyJhbGciOiJSUzI1NiIsImtpZCI6ImJjOGI0ZjU3OGFlNGRhMzA5MDQzNGY0YTIyM2NlZDdkYzU1M2IwMjEifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiaWF0IjoxNDg4OTIzNDgxLCJleHAiOjE0ODg5MjcwODEsImF0X2hhc2giOiJ3MDRrdGFhTHpkNldkaGl5Z0s4eEtnIiwiYXVkIjoiMTA2ODE2MjcwMzEzMy1ydnVqOGVqMWk2bmF2bG91cTM1NnRkdW90MWY4OGpqdC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsInN1YiI6IjEwNzA5NzI5MTUwOTQ5MjU0NjcwNCIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJhenAiOiIxMDY4MTYyNzAzMTMzLXJ2dWo4ZWoxaTZuYXZsb3VxMzU2dGR1b3QxZjg4amp0LmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiZW1haWwiOiJidWJiYW0yMDA2QGdtYWlsLmNvbSIsIm5hbWUiOiJKZXJvbWUgQm9yZGFsbG8iLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDYuZ29vZ2xldXNlcmNvbnRlbnQuY29tLy1FOVRBV1hWdGJHNC9BQUFBQUFBQUFBSS9BQUFBQUFBQUFEOC9wM0FIUVpiNE9uYy9zOTYtYy9waG90by5qcGciLCJnaXZlbl9uYW1lIjoiSmVyb21lIiwiZmFtaWx5X25hbWUiOiJCb3JkYWxsbyIsImxvY2FsZSI6ImVuIn0.dTZaT-ELvstLnYAfVPQ9Ipm1rdbAHK0RQh6cBDZiXzHjXv0tgMQ6ugTMouc9UyZVA-iLb5ESQouY7skJoUkiJzNVAgxth4RADLS77VToiHZ4e7HMVdYmMSo1isy_ilTrQcGAFYsgGwSvomol2efmp0u-OxyNlgBXI7SGtP2o0F0Uc13LRIHsTCvbSk7LO2yhgkXO99F0dhFauWPtJn1Slwk7uc18bY6vZpXvrT5qVV0AaaKpeyoaOpL1bI5K37HeNJZPPZn5qHndG3JOqpk6pjbzkWtaqT9CtLsnJl5yup766z2GX7_1bLBVQm4_M2dhQpctZBj9PqR8K5vz7e3Chw
HEREDOC;
        $response = $this->json('GET', 'api/search', ['api_token' => $bad_token]);

        $response
                ->assertStatus(401)
                    ->assertJson([
                        'error' => $message,
                ]);
    }

    /**
     * Error 401 with error "ID Token expired."
     * 
     * Disabled this test. Not a reliable test... Saved token is expired but may not really be 
     * identifiable by Google anymore.
     * 
     */
    public function testExpiredToken() {
        // disabling
        if (1 == 0) {
            $message = 'ID Token expired.';
            $bad_token =<<<HEREDOC
eyJhbGciOiJSUzI1NiIsImtpZCI6ImJjOGI0ZjU3OGFlNGRhMzA5MDQzNGY0YTIyM2NlZDdkYzU1M2IwMjEifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiaWF0IjoxNDg4OTMzMzg1LCJleHAiOjE0ODg5MzY5ODUsImF0X2hhc2giOiJ4ZDZjdWJ2bzJkVGlDeFZTd3lOcW9nIiwiYXVkIjoiMTA2ODE2MjcwMzEzMy1ydnVqOGVqMWk2bmF2bG91cTM1NnRkdW90MWY4OGpqdC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsInN1YiI6IjEwNzA5NzI5MTUwOTQ5MjU0NjcwNCIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJhenAiOiIxMDY4MTYyNzAzMTMzLXJ2dWo4ZWoxaTZuYXZsb3VxMzU2dGR1b3QxZjg4amp0LmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiZW1haWwiOiJidWJiYW0yMDA2QGdtYWlsLmNvbSIsIm5hbWUiOiJKZXJvbWUgQm9yZGFsbG8iLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDYuZ29vZ2xldXNlcmNvbnRlbnQuY29tLy1FOVRBV1hWdGJHNC9BQUFBQUFBQUFBSS9BQUFBQUFBQUFEOC9wM0FIUVpiNE9uYy9zOTYtYy9waG90by5qcGciLCJnaXZlbl9uYW1lIjoiSmVyb21lIiwiZmFtaWx5X25hbWUiOiJCb3JkYWxsbyIsImxvY2FsZSI6ImVuIn0.QIpZ8rikcS_Vv7IcPzlvMcgHsxunpoDrk-BI-slBA7S3TwRSf6DsHyXEeAJpzpAFdytbuSY2-lGVy8BibmZ22vj3s-4SUSCvq3FMPhnQh_Lfx_V_9xb7nHO34GJWdsMgHovwYiBaO1R2E6RPd1x3sNOg2JyghZHJZMvwkeXQUsOAuzkBLRyg2wR7Wqfyx9Qr8Us9c5oCUJKQ3JiRBwK6iv38u4py3TQWhXZLuVubsWmsuN6ArNwUBL2IIqSdohGRkVe8FEn8DZSqLZUAxzQhSnqhR8O3PKEVOqfgnBpdCzf0bokWi0m3dt1ffbz6QE3E3WQQobvXWTTpDk2qIXsV1w
HEREDOC;
            $response = $this->json('GET', 'api/search', [
                'type' => 'artist',
                'name' => "",
                'api_token' => $bad_token]);

            $response
                    ->assertStatus(401)
                        ->assertJson([
                            'error' => $message,
                    ]);
        }
    }

    /**
     * If token is to a different App ID.
     * 
     * Disabled this test, since I will need test runner to get a token for the other App,
     * that hasn't expired.
     */
    public function testInvalidAppID() {
        // disabling
        if (1 == 0) {
            $invalid_App_token =<<<HEREDOC
eyJhbGciOiJSUzI1NiIsImtpZCI6ImJjOGI0ZjU3OGFlNGRhMzA5MDQzNGY0YTIyM2NlZDdkYzU1M2IwMjEifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiaWF0IjoxNDg4OTI2NzgzLCJleHAiOjE0ODg5MzAzODMsImF0X2hhc2giOiI1eDNHdDluTkhSUlZKbldJS1hqNHpBIiwiYXVkIjoiMTA2ODE2MjcwMzEzMy1ydnVqOGVqMWk2bmF2bG91cTM1NnRkdW90MWY4OGpqdC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsInN1YiI6IjEwNzA5NzI5MTUwOTQ5MjU0NjcwNCIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJhenAiOiIxMDY4MTYyNzAzMTMzLXJ2dWo4ZWoxaTZuYXZsb3VxMzU2dGR1b3QxZjg4amp0LmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiZW1haWwiOiJidWJiYW0yMDA2QGdtYWlsLmNvbSIsIm5hbWUiOiJKZXJvbWUgQm9yZGFsbG8iLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDYuZ29vZ2xldXNlcmNvbnRlbnQuY29tLy1FOVRBV1hWdGJHNC9BQUFBQUFBQUFBSS9BQUFBQUFBQUFEOC9wM0FIUVpiNE9uYy9zOTYtYy9waG90by5qcGciLCJnaXZlbl9uYW1lIjoiSmVyb21lIiwiZmFtaWx5X25hbWUiOiJCb3JkYWxsbyIsImxvY2FsZSI6ImVuIn0.nXDmCJgCNbInoxOCHYzZqz-8mjiHEeHq2h5jgmQZ5BVyJonj-jpUbdsADCnvX9IDjsVnj7DGfmfd9OVfx_UFi74WqjC5MxJUH7Dk1JRK6OcF0sh6Hc4QdEi7yv4rDae12vOZmyI_f-FDIjvBqhFsWwWgum7CXVfZUW1vLayp416R26StAjsMrhM7t_UJmWkeEk5Rb39U7Xb20DTrqNb4JmJYcy8uul8rpWZCNjUgApXq41lBy8goE1eX3RgYLSQncnXGaceloojd1sZJUNQvbV_-ZY8SdKAdSZHDH8yODHcM2w6N0YzCZm54SZDmwo4nXT-UkZPrDYVDRTaP3vwxKA
HEREDOC;
            $response = $this->json('GET', 'api/search', ['api_token' => $bad_token]);

            $response
                    ->assertStatus(401);
        }
    }

    /**
     * If token is actually fine.
     * Disabled this test, since I will need test runner to get a new token that has not expired.
     */
    public function testGoodToken() {
        // disabling
        if (1 == 0) {
            $valid_App_token = '';
            $response = $this->json('GET', 'api/search', ['api_token' => $valid_App_token]);

            $response
                    ->assertStatus(200);
        }
    }
    
    
}
