<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller 
{
    /**
     * تحديد الـ middleware المطلوب لهذا الـ controller
     */
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('auth' ,only:['create']), 
           
    //     ];
    // }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()){
                 $categories = Category::get();
        return view('theme.blogs.create' , compact('categories'));
        } 
        abort(403);
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogStoreRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();

        //upload image 
        $image = $request->image;
        // chang naming 
        $newImageName = time().'-'.$image->getClientOriginalName();
        //Move image to my project 
        $image ->storeAS('blogs' , $newImageName, 'public');
        //save name in database
        $data['image']=$newImageName;
        $data ['user_id']=Auth::user()->id;
        Blog::create($data);
        return back()->with('BlogStatus','This CREAted SUccsefully');
  
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
            return view('theme.singleblog' ,compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if ($blog->id == Auth::user()->id){
        $categories = Category::get();
        return view('theme.blogs.edit' , compact('categories' , 'blog'));
    }
     abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
       if ($blog->id == Auth::user()->id){
        $data = $request->validated();
        if($request->hasFile('image')) {
            Storage::delete("public/blogs/$blog->image");
               //upload image 
        $image = $request->image;
        // chang naming 
        $newImageName = time().'-'.$image->getClientOriginalName();
        //Move image to my project 
        $image ->storeAS('blogs' , $newImageName, 'public');
        //save name in database
        $data['image']=$newImageName;
     

        } 
     
       $blog->update($data);
        return back()->with('UpdateBlogStatus','This UPdate SUccsefully');
    }
    abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        // dd($blog);
        if ($blog->id == Auth::user()->id)
        {Storage::delete("public/blogs/$blog->image");
        $blog->delete();
          return back()->with('DEleteBlogStatus','This DElete SUccsefully');
    }
}

       public function myblog()
    {
      
        if(Auth::check()){
    $blogs = Blog::where('user_id', Auth::user()->id)->paginate(5);
        return view('theme.blogs.my_blogs',compact('blogs'));
        }
        abort(403);
    }
}
