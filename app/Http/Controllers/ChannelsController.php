<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use Session;
use App\Discussion;

class ChannelsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('channels.index')->with('channels', Channel::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('channels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        Channel::create([
            'title' => $request->title,
            'slug' => str_slug($request->title)
        ]);

        Session::flash('smsg', 'Channel created successfully.');

        return redirect()->back();

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
        return view('channels.edit')->with('channel', Channel::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        $channel = Channel::find($id);
        $channel->title = $request->title;
        $channel->slug = str_slug($request->title);
        $channel->save();

        Session::flash('smsg', 'Channel updated successfully');

        return redirect()->route('channels.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Channel::destroy($id);

        Session::flash('smsg', 'Channel deleted successfully.');
        return redirect()->route('channels.index');
    }

    public function discussions($slug){
        $channel_id = Channel::where('slug', $slug);
        dd($channel_id);
        $discussions = Discussion::where('channel_id');
    }
}
