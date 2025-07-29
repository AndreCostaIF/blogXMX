<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Página inicial com listagem de posts
    public function index()
    {
        $posts = Post::with('tags')
            ->withCount(['likes', 'dislikes', 'comments'])
            ->paginate(30);

        // echo '<pre>';
        // foreach ($posts as $post){

        //     var_dump($posts);
        // }
        // die();
        return view('welcome', compact('posts'));
    }


    public function details($id)
    {
        $post = Post::withCount(['likes', 'dislikes', 'comments'])
            ->with(['comments.user']) // Aqui carrega os users de cada comment
            ->findOrFail($id);

        // echo '<pre>';
        // foreach ($post->comments as $comment) {

        //    echo $comment->body . ' - Autor: ' . $comment->user->firstName . "\n";
        // }
        // die();

        return view('postView', compact('post'));
    }




    // Função para curtir um post
    public function like($id)
    {
        $post = Post::findOrFail($id);

        // Aqui você pode salvar a like no banco (exemplo simples)
        $post->likes()->create([
            'user_id' => 1,
        ]);

        return redirect()->back();
    }


    // Função para curtir um post
    public function addComment(Request $request)
    {
        // echo '<pre>';
        // var_dump($request['content']);
        // die();
        Comment::create([
            'body' => $request['body'],
            'likes'   => 1,
            'post_id' => $request['post_id'],
            'user_id' => 3,
        ]);

        return back()->with('success', 'Comentário adicionado com sucesso!');
    }


    public function comment_like($id)
    {
        $comment = Comment::findOrFail($id);

        // Incrementa o campo 'likes' em +1
        $comment->increment('likes');

        return redirect()->back();
    }


    // Função para dar dislike em um post
    public function dislike($id)
    {
        $post = Post::findOrFail($id);

        $post->dislikes()->create([
            'user_id' => 1,
        ]);

        return redirect()->back();
    }
}
