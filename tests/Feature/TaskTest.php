<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;

class TaskTest extends TestCase
{
    use RefreshDatabase;


    public public function setUP()
    {
        # code...
        parent::setUp();
        $this->seed('FoldersTableSeeder');
    }

    public function due_date_should_be_date()
    {
        $response = $this->post('/folders/1/tasks/create',
        [
            'title' => 'Sample task',
            'due_date' => 123, // 不正なデータ（数値）
        ]);
        $response->assertSessionHasErrors([
            'due_date' => '期限日 には日付を入力してください。'
        ]);
    }

    public function due_date_should_not_be_past()
    {
        $response = $this->post('/folders/1/tasks/create',
        [
            'title' => 'Sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'),//不正なデータ（昨日の日付）
        ]);
        $response->assertSettionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
