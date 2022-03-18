<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Assignment;
class AssignmentTest extends TestCase
{
	public function test_list_page_shows_all_assignments(){
     $this->post('/assignments', [
		'title' => 'My great assignment',
		]);
	$this->assertDatabaseHas('assignments', [
	 'title' => 'My great assignment',
	]);
	}
}