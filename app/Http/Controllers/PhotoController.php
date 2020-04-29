<?php

namespace App\Http\Controllers;

use foo\bar;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index()
    {


        $instagram_url = "https://www.instagram.com/golrang_system/";

        $source = file_get_contents($instagram_url);

        preg_match('/<script type="text\/javascript">window\._sharedData =([^;]+);<\/script>/', $source, $matches);

        $data = json_decode($matches[1]);
        $postData = $data->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media;

        $posts = array();
        foreach ($postData->edges as $key => $post){
            $posts['url'] = 'https://www.instagram.com/p/'.$post->node->shortcode;
            $posts['image'] = $post->node->thumbnail_src;
            $imageName = $post->node->shortcode.'.jpg';
            if( $posts['image']){
                file_put_contents($imageName, file_get_contents( $posts['image']));
            }
        }
     //   dd($posts);
//dd($data->entry_data->ProfilePage[0]->graphql->user->edge_owner_to_timeline_media->edges[0]->node->shortcode);

        return view('posts' , compact('posts'));
    }
}
