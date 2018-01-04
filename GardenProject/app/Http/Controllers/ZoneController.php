<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ZoneRequest;
use File;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = DB::select('select * from zone');
        return view('zone.list-zone', ['zones'=>$zones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('zone.add-zone');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ZoneRequest $request)
    {
        DB::insert('insert into Zone(area, size) values(?, ?)', [
            $request->input('area'),
            $request->input('size'),
        ]);
        $latestId = DB::table('zone')->orderBy('idZone', 'DESC')->first()->idZone;
        if ($request->hasFile('zone_images')) {
            foreach($request->file('zone_images') as $image) {
                $pathFile = str_random(10) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path() . '/images/', $pathFile);
                DB::insert('insert into ZoneImage(pathFile, idZone) value(?, ?)', [
                    $pathFile,
                    $latestId
                ]);
            }
        } 
        session()->flash('added', 'เพิ่มโซน เรียบร้อยแล้ว');
        return redirect('/zones');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $zone = DB::table('Zone')->where('idZone', $id)->first();
        $zone->images = DB::select('select * from ZoneImage where idZone = ?', [$id]);
        return view('zone.detail-zone', ['zone'=>$zone]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $zone = DB::table('Zone')->where('idZone', $id)->first();
        return view('zone.edit-zone', ['zone'=>$zone]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ZoneRequest $request, $id)
    {
        DB::update('update Zone set area = ?, size = ? where idZone = ?', [
            $request->input('area'),
            $request->input('size'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขโซน เรียบร้อยแล้ว');
        return redirect('/zones/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $images = DB::select('select * from ZoneImage where idZone = ?', [$id]);
        foreach($images as $image) {
            File::delete(public_path() . '/images/' . $image->pathFile);
            DB::delete('delete from ZoneImage where idZoneImage = ?', [$image->idZoneImage]);
        }
        DB::delete('delete from Zone where idZone = ?', [$id]);
        session()->flash('deleted', 'ลบโซน เรียบร้อยแล้ว');
        return redirect('/zones');
    }
}
