<?php
//https://www.tutorialspoint.com/laravel/laravel_controllers.htm
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware( 'auth', [ 'except' =>['index', 'show'] ] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //GET
    public function index()
    {   
        //$posts =DB::select('select * from posts');

        //$posts =  Post::orderBy('title', 'asc')->get();
        //$posts= Post::all;
        //$posts =  Post::orderBy('title', 'asc')->take(3)->get();

        $posts =  Post::orderBy('created_at', 'asc')->paginate(2);
        return view('posts.index')->with('posts',$posts);
        //return view('posts.index', ['posts'=>$posts]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //GET
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //POST
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);       
        
       // Handle File Upload
       if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {  
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id; 
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //GET
    public function show($id)
    {
        $post= Post::find($id);
        return view('posts.show')->with('post',$post);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //GET
    public function edit($id)
    {
        $post = Post::find($id);

        // Check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //PUT
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
    
        // Create Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
 
        $post->save();
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //DELETE
    public function destroy($id)
    {
        $post = Post::find($id);

       // Check for correct user
       if(auth()->user()->id !==$post->user_id){
        return redirect('/posts')->with('error', 'Unauthorized Page');
        }        
        
        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');    }
}