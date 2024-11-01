<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\BestPractice;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  public function store(Request $request, BestPractice $bestPractice)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'content' => 'required|string',
    ]);

    $bestPractice->comments()->create([
      'name' => $request->name,
      'content' => $request->content,
    ]);

    return redirect()->route('best_practices.show', $bestPractice)->with('success', 'Comment added successfully.');
  }

  public function update(Request $request, BestPractice $bestPractice, Comment $comment)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'content' => 'required|string',
    ]);

    $comment->update([
      'name' => $request->name,
      'content' => $request->content,
    ]);

    return redirect()->route('best_practices.show', $bestPractice)->with('success', 'Comment updated successfully.');
  }

  public function destroy(BestPractice $bestPractice, Comment $comment)
  {
    $comment->delete();
    return redirect()->route('best_practices.show', $bestPractice)->with('success', 'Comment deleted successfully.');
  }



}
