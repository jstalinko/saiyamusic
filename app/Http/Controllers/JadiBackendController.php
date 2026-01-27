<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JadiBackendController extends Controller
{
    public function submitComment(Request $request)
    {
        $j_token = $request->header('X-Jadicms-Token');

        if (!j_validate_token($j_token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token'
            ], 401);
        }
        $comment = Validator::make($request->all(), [
            'post_id' => 'required',
            'content' => 'required',
        ]);
        if ($comment->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data'
            ], 400);
        }
        $data = $request->all();

        $commentModel = Comment::create([
            'author_name' => $data['name'],
            'author_email' => $data['email'],
            'post_id' => $data['post_id'],
            'content' => htmlspecialchars(strip_tags($data['content'])),
            'status' => 'approved',
        ]);
        if ($commentModel) {
            return response()->json([
                'success' => true,
                'data' => $commentModel,
                'message' => 'Comment submitted successfully'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Comment submission failed'
        ], 500);
    }
}
