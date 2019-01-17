<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tags;
use App\Http\Requests\TagCreateRequest;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    protected $fields = [
        'tag'=>'',
        'title'=>'',
        'subtitle'=>'',
        'meta_description'=>'',
        'page_image'=>'',
        'layout'=>'blog.layouts.index',
        'reverse_direction'=>0,
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tags::all();
        /*return view('admin.tag.index')->withTags($data);*/
        return view('admin.tag.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field,$default);
        }
        return view('admin.tag.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * 通知依赖注入来实现验证
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagCreateRequest $request)
    {

        //
        $tag = new tags();
        foreach (array_keys($this->fields) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();
        return redirect('/admin/tag')->with('success','标签['.$tag->tag.']创建成功');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Tags::findOrFail($id);
        $list = ['id'=>$id];
        foreach (array_keys($this->fields) as $field) {
            $list[$field] = $data->$field;
        }

        return view('admin.tag.edit',$list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, $id)
    {
        $tag = Tags::findOrFail($id);
        foreach (array_keys(array_except($this->fields, ['tag'])) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();
        $data = Tags::all();
        return view('/admin/tag/index',['data'=>$data])->with('success','修改成功');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tags::findOrFail($id);
        $tag->delete();
        $data = Tags::all();
        return view('/admin/tag/index',['data'=>$data])->with('success','删除成功');
    }
}
