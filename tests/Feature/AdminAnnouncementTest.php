<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use App\Models\Announcement;

use Tests\TestCase as BaseTestCase;

class AdminAnnouncementTest extends BaseTestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function testShouldStoreAnnouncement() {
        $this->withoutExceptionHandling();
        Passport::actingAs(
            User::factory()->create(),
            ['oathToken']
        );

        $data = [
            'title' => 'test title 1',
            'announcement_content' => 'test content',
            'startDate' => Carbon::now()->format('Y-m-d H:i:s'),
            'content' => null,
        ];

        $response = $this->postJson('/api/admin/announcements', $data);

        $response->assertStatus(201);

        $id = $response->json('data.id');

        $announcement = Announcement::find($id);

        $response->assertJson(['data' => $this->announcementToResource($announcement)]);
    }

    public function testShouldUpdateAnnouncement() {
        $this->withoutExceptionHandling();
        Passport::actingAs(
            User::factory()->create(),
            ['oathToken']
        );

        $data = [
            'title' => 'test title 1',
            'announcement_content' => 'test content',
            'startDate' => Carbon::now()->format('Y-m-d H:i:s'),
            'content' => null,
        ];

        $response = $this->postJson('/api/admin/announcements', $data);

        $response->assertStatus(201);

        $id = $response->json('data.id');

        $announcement = Announcement::find($id)->toArray();

        $data = $announcement;
        $data['title'] = 'new title';

        $response = $this->postJson('/api/admin/announcements/update/' . $id , $data);

        $response->assertStatus(200);

        $id = $response->json('data.id');

        $announcement = Announcement::find($id);

        $response->assertJson(['data' => $this->announcementToResource($announcement)]);
    }


    public function testShouldGetNotFoundError() {
        $response = $this->getJson('/api/admin/announcements/100000');
        $response->assertStatus(404);
    }

    public function testShouldDeleteAnnouncement() {
        $data = [
            'title' => 'test title 1',
            'announcement_content' => 'test content',
            'startDate' => Carbon::now()->format('Y-m-d H:i:s'),
            'content' => null,
        ];

        $response = $this->postJson('/api/admin/announcements', $data);

        $response->assertStatus(201);

        $id = $response->json('data.id');

        $announcement = Announcement::find($id);
        $announcement->delete();

        $response = $this->getJson('/api/admin/announcements/' . $id);

        $response->assertStatus(404);
    }

    public function validationDataProvider(): array
    {
        return [
            [['review' => null], 'review'],
            [['review' => ''], 'review'],
            [['review' => 0], 'review'],
            [['review' => 11], 'review'],
            [['review' => 3.5], 'review'],
            [['review' => []], 'review'],
            [['comment' => null], 'comment'],
            [['comment' => ''], 'comment'],
            [['comment' => []], 'comment'],
        ];
    }
}
