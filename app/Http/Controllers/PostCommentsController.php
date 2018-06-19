<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Http\Requests;
use App\Comments;
use App\Post;

class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comments = Comments::all();
        return view('admin.comments.index', compact('comments'));

        
    }
/**************************************************************************** */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
/*************************************************************************** */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        $data = [
            'post_id'=>$request->post_id,
            'author'=>$user->name,
            'email'=>$user->email,
            'photo'=>$user->photo ? $user->photo->file : '',
            'body'=>$request->body


        ];
        $comment = Comments::create($data);
        $request->session()->flash('comment_message', 'Your message has been submitted and is waiting moderation');
        return redirect()->back();
        

       
    }
/******************************************************************************** */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::findOrFail($id);

        $comments = $post->comments;

        return view('admin.comments.show', compact(comments));
       
    }
/************************************************************************************* */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
/**************************************************************************************** */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        Comment:findOrFail($id)->update($request->all());
        return redirect('/admin/comments');
    }
/**************************************************************************************** */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Comments::findOrFail($id)->delete();
        return redirect()->back();
    }
}
