<?php

namespace App\Http\Controllers;

use App\Models\RecyclingTip;
use Illuminate\Http\Request;

class RecyclingTipController extends Controller
{
    public function index()
    {
        $tips = RecyclingTip::where('approved', true)->get(); // Only show approved tips
        return view('recycling_tips.index', compact('tips'));
    }

    public function myTips()
    {
        // Fetch tips created by the authenticated user
        $tips = RecyclingTip::where('posted_by', auth()->id())->get();

        return view('recycling_tips.my_tips', compact('tips'));
    }


    public function create()
    {
        return view('recycling_tips.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        RecyclingTip::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'posted_by' => auth()->id(), // Current user
            'likes_count' => 0,
        ]);

        return redirect()->route('recycling-tips.index')->with('success', 'Tip submitted for approval');
    }

    public function edit($id)
    {
        $tip = RecyclingTip::findOrFail($id);

        // Ensure the user can only edit their own tips
        if ($tip->posted_by !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        return view('recycling_tips.edit', compact('tip'));
    }

    public function update(Request $request, $id)
    {
        $tip = RecyclingTip::findOrFail($id);

        if ($tip->posted_by !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $tip->update($request->all());
        return redirect()->route('recycling-tips.index')->with('success', 'Tip updated successfully');
    }

    public function destroy($id)
    {
        $tip = RecyclingTip::findOrFail($id);

        if ($tip->posted_by !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $tip->delete();
        return redirect()->route('recycling-tips.index')->with('success', 'Tip deleted successfully');
    }

    public function like($id)
    {
        $tip = RecyclingTip::findOrFail($id);
        $user = auth()->user(); // Get the authenticated user

        // Check if the user has already liked this tip
        if ($tip->likedByUsers()->where('user_id', $user->id)->exists()) {
            return redirect()->route('recycling-tips.index')->with('error', 'You have already liked this tip.');
        }

        // If not liked before, add a record to the pivot table
        $tip->likedByUsers()->attach($user->id);

        // Increment the likes count
        $tip->increment('likes_count');

        return redirect()->route('recycling-tips.index')->with('success', 'You liked the tip.');
    }


    public function approveTip($id)
    {
        $tip = RecyclingTip::findOrFail($id);
        $tip->update(['approved' => true]);

        return redirect()->route('admin.recycling-tips.pending')->with('success', 'Tip approved successfully');
    }
    public function pendingTips()
    {
        // Fetch all tips that have not yet been approved
        $tips = RecyclingTip::where('approved', false)->get();

        return view('recycling_tips.pending', compact('tips'));
    }
    public function rejectTip($id)
    {
        $tip = RecyclingTip::findOrFail($id);
        $tip->delete();

        return redirect()->route('admin.recycling-tips.pending')->with('success', 'Tip rejected and deleted successfully');
    }

}
