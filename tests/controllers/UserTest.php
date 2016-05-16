<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * Test the index route
     *
     * @return void
     */
    public function test_ShouldReturnAllTheUsersInAValidJson()
    {

      $user = factory(App\User::class)->create();

      $this->get('/api/users')
        ->seeJsonStructure([
          '*' => [
            'id', 'username', 'email'
          ]
        ])
        ->assertResponseOk();
    }

    public function test_ShouldReturnInformationForAGivenUser()
    {
      $user = factory(App\User::class)->create();

      $this->get('api/users/' . $user->id)
        ->seeJson([
           'id' => $user->id,
           'username' => $user->username,
           'email' => $user->email,
        ])
        ->assertResponseOk();
    }

    public function test_ShouldCreateAUserAndAsignatedUserProfile()
    {
      $response = $this->call('POST', 'api/users', [
        'email' => 'test@test.com',
        'username' => 'test',
        'password' => 'test123',
        'password_confirmation' => 'test123'
      ]);

      $object = json_decode($response->getContent());

      // Confirm json structure
      $this->assertTrue(is_int($object->id));
      $this->assertContains($object->email, 'test@test.com');
      $this->assertContains($object->username, 'test');
      $this->assertNotNull($object->created_at);
      $this->assertNotNull($object->updated_at);

      // Confirm the user profile creation
      $this->seeInDatabase('user_profiles', ['user_id' => $object->id]);

      $this->assertEquals(200, $response->status());
    }

    public function test_ShouldBeAbleToDeleteItself()
    {
      // Setup a user
      $user = factory(App\User::class)->create();

      Auth::shouldReceive('id')->once()->andReturn($user->id);

      $response = $this->actingAs($user)
        ->call('DELETE', 'api/users/'. $user->id);

      $this->assertEquals(200, $response->status());

      // Check its actually soft deleted
      $this->seeInDatabase('users', ['id' => $user->id ]);

      // Asking for the user returns a 404
      $response = $this->call('GET', 'api/users/' . $user->id);

      var_dump($response->getContent());
    }
}
