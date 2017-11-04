<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin\Article;
use App\Http\Model\Admin\Category;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use resources\org\Tree;

class ArticleController extends AdminController
{
    //
    public function index()
    {
        //dd(Article::find(1)->published_at);   //获取发布字段
        //dd(Article::find(1)->created_at->diffForHumans());    //获取发布时间距当前时间差
        //dd(Article::find(2)->category()->get());  //获取关联表数据
        //dd(Article::with('category')->get()->toArray());  //同事获取当前和关联表数据，并转为数组

        $data = Article::with('category')->orderBy('id', 'desc')->paginate(3);
        return view('admin.article.index', compact('data'));
    }

    public function create(){
        $category = Category::orderBy('cate_order', 'asc')->get();

        $code = new Tree();
        $data = $code->createTree($category, 'id', 'cate_pid', 'cate_name');

        return view('admin.article.add', compact('data'));
    }

    public function store(Request $request){
        //return back()->withErrors(['cate_type'=>'分类不能为空']);
        //return back()->withErrors(['article_thumb'=>'图片错误']);

        $message = [
            'cate_id.required' => '请选择分类',
            'article_title.required' => '请输入标题',
            'article_content.required' => '内容不能为空',
        ];
        $rule = [
            'cate_id' => 'required',
            'article_title' => 'required',
            'article_content' => 'required',
        ];

        $res = Validator::make($request->input(), $rule, $message);
        if (!$res->passes()){
            return [
                'status' => 1,
                'result' => $res->errors()->first(),
            ];
        }

        //验证方式2
        /*$this->validate($request, [
            'cate_id' => 'required',
            'article_title' => 'required',
            'article_content' => 'required',
        ]);*/

        $result = Article::create(array_merge(['published_at'=>'2017-10-3'],$request->all()));
        if ($result){
            return [
                'status' => 0,
                'result' => '添加成功',
            ];
        }else{
            return [
                'status' => 1,
                'result' => '添加失败',
            ];
        }
    }

    public function edit($id){
        $result = Article::findOrFail($id);
        $category = Category::orderBy('cate_order', 'asc')->get();
        $code = new Tree();
        $data = $code->createTree($category, 'id', 'cate_pid', 'cate_name');
        return view('admin.article.edit', compact('result','data'));
    }

    public function update(Request $request, $id){
        $message = [
            'cate_id.required' => '请选择分类',
            'article_title.required' => '请输入标题',
            'article_content.required' => '内容不能为空',
        ];
        $rule = [
            'cate_id' => 'required',
            'article_title' => 'required',
            'article_content' => 'required',
        ];

        $res = Validator::make($request->all(), $rule, $message);
        if (!$res->passes()){
            return [
                'status' => 1,
                'result' => $res->errors()->first()
            ];
        }

        $article = Article::find($id);
        if (!empty($article->article_thumb) && $request->input('article_thumb') != $article->article_thumb){
            unlink($article->article_thumb);
        }
        $result = $article->update($request->all());
        if ($result){
            return [
                'status' => 0,
                'result' => '修改成功'
            ];
        }else{
            return [
                'status' => 1,
                'result' => '修改失败'
            ];
        }
    }

    public function destroy(Request $request, $id){
        $article = Article::find($id);
        if ($article->delete()){
            if (file_exists($article->article_thumb)){
                unlink($article->article_thumb);
            }
            $data = [
                'status' => 0,
                'result' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'result' => '删除失败'
            ];
        }
        return $data;
    }
}
