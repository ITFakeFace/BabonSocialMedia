<?php

namespace App\Http\Controllers;

use App\Models\Emotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmoteController extends Controller
{
    public static function getEmote($postId, $type){
        $emotions = Emotion::where('post_id', "=", $postId)
                            ->where('type', "=", $type)->count();
        return $emotions;
    }

    public function createEmote(Request $request){
        $user_id = Auth::user()->id;
        $emote_check = Emotion::where('post_id',$request->post_id)->where('user_id',$user_id)->first();
        if ($emote_check == NULL){
            $emote = new Emotion();
            $emote->user_id=$user_id;
            $emote->post_id=$request->post_id;
            $emote->type=$request->type;
            $emote->save();
        } else {
            if ($emote_check->type == $request->type){
                $emote_check->delete();
            } else {
                $emote_check->type = $request->type;
                $emote_check->save();
            }
        }
        return response()->json(array("like"=>EmoteController::getEmote($request->post_id,1), "dislike" => EmoteController::getEmote($request->post_id, 2))); 
    }
}
