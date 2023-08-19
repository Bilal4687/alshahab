<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function Blog()
    {
        return view('Admin.Blog');
    }

    public function BlogFetch(Request $req)
    {
        $data = DB::table('blogs')->get();
        return response()->json($data);
    }

    public function BlogStore(Request $req)
    {
        $id = $req->input('blog_id');
        $data = $req->input();
        $folder = 'public/Files/Blog/';
        unset($data['_token']);

        $validator = Validator::make($req->all(), [
            'blog_title' => 'required',
            'blog_description' => 'required',
            'blog_short_description' => 'required',
            'image' => $id ? 'mimes:jpeg,png,jpg' : 'required|image|mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        try {
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $data['image'] = Str::random(20) . '.' . $image->getClientOriginalExtension();
                file_put_contents(base_path($folder . $data['image']), file_get_contents($image));
                if ($id) {
                    $findImage = DB::table('blogs')->where('blog_id', $id)->first();
                    if (file_exists($folder . $findImage->image) and !empty($findImage->image)) {
                        unlink($folder . $findImage->image);
                    }
                }
            } else {
                $old = DB::table('blogs')->where('blog_id', $id)->get();
                $data['image'] = $old[0]->image;
            }
            $blog = DB::table('blogs')->updateOrInsert(['blog_id' => $id], $data);
            return response()->json(["success" => true, "message" => !$id ? "blog Create Successfully!" : "Blog Updated Successfully!"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Oops something error occured", "err" => $th->getMessage()]);
        }
    }

    public function BlogEdit(Request $req)
    {
        return response()->json(['data' => DB::table('blogs')->where('blog_id', $req->input('blog_id'))->get()]);
    }
    public function BlogDelete(Request $req)
    {
        $findImage = DB::table('blogs')->where('blog_id', $req->input('blog_id'))->first();
        $folder = 'public/Files/Blog/';
        if (file_exists($folder . $findImage->image) and !empty($findImage->image)) {
            unlink($folder . $findImage->image);
        }

        if (DB::table('blogs')->where('blog_id', $req->input('blog_id'))->delete()) {
            return response()->json(["succes" => true, "message" => "Blog Remove Successfully"]);
        }
        return response()->json(["succes" => false, "message" => "Oops Something Went wronge!"]);
    }
}
