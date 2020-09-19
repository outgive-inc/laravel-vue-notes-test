<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotesTest extends TestCase
{
    /** @var \App\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function can_add_note()
    {
        $this->actingAs($this->user)
             ->postJson('/api/notes/add', [
                'title' => 'My notes',
                'content' => 'Notes content',
                'created_at' => '2020-09-19 9:15:23',
             ])
             ->assertSuccessful()
             ->assertJsonStructure(['id', 'title', 'content']);
    }
}
