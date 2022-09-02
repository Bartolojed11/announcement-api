<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Announcement;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;


    protected function announcementToResource(Announcement $announcement)
    {
        $announcement = json_decode(json_encode($announcement->toArray()));

        return [
            'title' => $announcement->title,
            'announcement_content' => $announcement->announcement_content,
            'endDate' => $announcement->endDate,
            'id' => $announcement->id,
        ];
    }
}
