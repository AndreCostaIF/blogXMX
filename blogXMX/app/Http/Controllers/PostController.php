<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;


class PostController extends Controller
{
    // Página inicial com listagem de posts
    public function index()
    {
        $response = Http::get('https://dummyjson.com/posts');

        if ($response->successful()) {
            $data = $response->json()['posts'];

            // Converte recursivamente cada post para objeto (inclusive arrays aninhados)
            $objects = collect($data)->map(function ($item) {
                return json_decode(json_encode($item));
            });

            // Paginação manual
            $currentPage = request()->get('page', 1);
            $perPage = 10;
            $currentPageItems = $objects->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $posts = new LengthAwarePaginator(
                $currentPageItems,
                $objects->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return view('welcome', compact('posts'));
        }

        return view('welcome')->withErrors('Não foi possível obter os posts da API.');
    }


    public function details($id)
    {
        // Buscar o post
        $postResponse = Http::get("https://dummyjson.com/posts/{$id}");
        if (!$postResponse->successful()) {
            abort(404, 'Post não encontrado.');
        }
        $post = json_decode(json_encode($postResponse->json()));

        // Buscar comentários (filtar por postId)
        $commentsResponse = Http::get("https://dummyjson.com/comments");
        $comments = [];
        if ($commentsResponse->successful()) {
            $allComments = $commentsResponse->json()['comments'];

            // Filtra comentários deste post
            $filteredComments = collect($allComments)
                ->where('postId', $id)
                ->values();

            // Converte para objeto para a view
            $comments = $filteredComments->map(function ($comment) {
                return json_decode(json_encode($comment));
            });
        }

        // Anexa os comentários ao post
        $post->comments = $comments;


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
