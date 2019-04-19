<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetposts()
    {
        $post = factory('App\Post')->create();

        $response = $this->get('api/posts');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'title' => $post->title,
            'content' => $post->content,
            'image' => $post->image,
        ]);
    }

    public function testGetOnePost()
    {
        $post = factory('App\Post')->create();

        $response = $this->get('api/posts/'.$post->id);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'title' => $post->title,
            'content' => $post->content,
            'image' => $post->image,
        ]);
    }

    public function testCreatePostWithoutImage()
    {
        $response = $this->post('api/posts', [
            'title' => 'New post',
            'content' => 'Bla bla bla ...',
            'visibility' => 'private',
        ]);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('posts', [
            'title' => 'New post',
            'content' => 'Bla bla bla ...',
            'visibility' => 'private',
        ]);

        $response->assertJsonFragment([
            'title' => 'New post',
            'content' => 'Bla bla bla ...',
            'visibility' => 'private',
        ]);
    }

    public function testCreatePostWithImage()
    {
        $response = $this->post('api/posts', [
            'title' => 'New post',
            'content' => 'Bla bla bla ...',
            'visibility' => 'private',
            'image' => 'https://image.com/img.png'
        ]);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('posts', [
            'title' => 'New post',
            'content' => 'Bla bla bla ...',
            'visibility' => 'private',
            'image' => 'https://image.com/img.png'
        ]);

        $response->assertJsonFragment([
            'title' => 'New post',
            'content' => 'Bla bla bla ...',
            'visibility' => 'private',
            'image' => 'https://image.com/img.png'
        ]);
    }

    public function testUpdatepost()
    {
        $post = factory('App\Post')->create();

        $response = $this->put('api/posts/'.$post->id, [
            'title' => 'New post',
            'content' => 'Bla bla bla ...',
            'visibility' => 'private',
            'image' => 'https://image.com/img.png'
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('posts', [
            'title' => $post->title,
            'content' => $post->content,
            'visibility' => $post->visibility,
            'image' => $post->image,
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'New post',
            'content' => 'Bla bla bla ...',
            'visibility' => 'private',
            'image' => 'https://image.com/img.png'
        ]);

        $response->assertJsonFragment([
            'title' => 'New post',
            'content' => 'Bla bla bla ...',
            'visibility' => 'private',
            'image' => 'https://image.com/img.png'
        ]);
    }

    public function testDeletepost()
    {
        $post = factory('App\Post')->create();

        $response = $this->delete('api/posts/'.$post->id);

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('posts', [
            'title' => $post->title,
            'content' => $post->content,
            'image' => $post->image,
        ]);

        $response->assertJsonFragment([
            'message' => 'Success',
        ]);
    }
}
