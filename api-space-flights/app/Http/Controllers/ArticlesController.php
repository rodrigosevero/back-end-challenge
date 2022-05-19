<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function welcome()
    {
        return response()->json([
            'error' => false,
            'message' => 'Back-end Challenge 2021 🏅 - Space Flight News',
            'data' => null
        ], Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $articles = Article::all();

        if (is_null($articles)) {
            return response()->json([
                'error' => true,
                'message' => 'Não há artigos cadastrados',
                'data' => null
            ], Response::HTTP_NOT_FOUND);
        }

        foreach ($articles as $article) {

            $article->launches = $article->launches()->get(['id', 'provider'])->all();
            $article->events = $article->events()->get(['id', 'provider'])->all();
        }

        return response()->json([
            'error' => false,
            'message' => 'Artigos encontrados',
            'data' => $articles
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $fields = [
            "featured",
            "title",
            "newsSite",
            "summary",
            "published_at"
        ];

        $requestField = [];

        foreach ($request->all() as $key => $value) {
            if (!in_array($key, $fields)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Whooops!!! O parâmetro ' . $key . ' não é aceito no corpo da requisição.',
                    'data' => null
                ], Response::HTTP_NOT_ACCEPTABLE);
            }else{
                $requestField[] = $key;
            }
        }

        foreach ($fields as $key => $value){
            if(!in_array($value, $requestField)){
                return response()->json([
                    'error' => true,
                    'message' => 'Whooops!!! O parâmetro obrigatório ' . $value . ' não foi informado no corpo da requisição.',
                    'data' => null
                ], Response::HTTP_NOT_ACCEPTABLE);
            }
        }

        $article = new Article();
        $article->featured = $request->featured;
        $article->title = $request->title;
        $article->url = Str::slug($request->title);
        $article->imageUrl = Str::slug($request->title);
        $article->newsSite = $request->newsSite;
        $article->summary = $request->summary;
        $article->published_at = $request->published_at;

        if (!$article->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Whooops!!! Ocorreu um erro ao salvar o artigo.',
                'data' => null
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'error' => false,
            'message' => 'Artigo cacastrado com sucesso!',
            'data' => $article
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $article = Article::where('id', $id)->first();

        if (is_null($article)) {
            return response()->json([
                'error' => true,
                'message' => 'Nenhum artigo encontrado referente a esse ID',
                'data' => null
            ], Response::HTTP_NOT_FOUND);
        }

        $article->launches = $article->launches()->get(['id', 'provider'])->all();
        $article->events = $article->events()->get(['id', 'provider'])->all();

        return response()->json([
            'error' => false,
            'message' => 'Artigo encontrado',
            'data' => $article
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $fields = [
            "featured",
            "title",
            "newsSite",
            "summary",
            "published_at"
        ];

        $requestField = [];

        foreach ($request->all() as $key => $value) {
            if (!in_array($key, $fields)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Whooops!!! O parâmetro obrigatório ' . $key . ' não é aceito no corpo da requisição.',
                    'data' => null
                ], Response::HTTP_NOT_ACCEPTABLE);
            }else{
                $requestField[] = $key;
            }
        }

        foreach ($fields as $key => $value){
            if(!in_array($value, $requestField)){
                return response()->json([
                    'error' => true,
                    'message' => 'Whooops!!! O parâmetro ' . $value . ' não foi informado no corpo da requisição.',
                    'data' => null
                ], Response::HTTP_NOT_ACCEPTABLE);
            }
        }

        $article = Article::where('id', $id)->first();

        if (is_null($article)) {
            return response()->json([
                'error' => true,
                'message' => 'Nenhum artigo encontrado referente a esse ID',
                'data' => null
            ], Response::HTTP_NOT_FOUND);
        }

        $article->featured = $request->featured;
        $article->title = $request->title;
        $article->url = Str::slug($request->title);
        $article->imageUrl = Str::slug($request->title);
        $article->newsSite = $request->newsSite;
        $article->summary = $request->summary;
        $article->published_at = $request->published_at;

        if (!$article->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Whooops!!! Ocorreu um erro ao atualizar o artigo.',
                'data' => null
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'error' => false,
            'message' => 'Artigo atualizado com sucesso!',
            'data' => $article
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $article = Article::where('id', $id)->first();

        if (is_null($article)) {
            return response()->json([
                'error' => true,
                'message' => 'Nenhum artigo encontrado referente a esse ID',
                'data' => null
            ], Response::HTTP_NOT_FOUND);
        }

        $article->delete();

        return response()->json([
            'error' => false,
            'message' => 'Artigo deletado com sucesso!',
            'data' => null
        ], Response::HTTP_OK);
    }
}