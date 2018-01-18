<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ZoneRequest;
use File;
use Image;

class ZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = DB::select('select * from zone');
        foreach($zones as $zone) {
            $hasAssignment = DB::table('Assignment')->where('idZone', $zone->idZone)->first();
            if( $hasAssignment ) {
                $zone->canDelete = false;
            }
            else {
                $zone->canDelete = true;
            }
        }
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
        session()->flash('added', 'เพิ่มโซน เรียบร้อยแล้ว');
        return redirect('/zones');
    }
    public function storeImage(Request $request, $idZone) {
        $validatedData = $request->validate([
            'zone_image' => 'required',
        ]);
        if ($request->hasFile('zone_image')) {
            if ($request->hasFile('zone_image')) {
                $filename = str_random(10) . '.' . $request->file('zone_image')->getClientOriginalExtension(); 
                $request->file('zone_image')->move(public_path() . '/images/', $filename);
                DB::insert('insert into ZoneImage(pathFile, idZone) values(?, ?)', [
                    $filename,
                    $idZone
                ]);
                session()->flash('added', 'เพิ่มรูปสวน เรียบร้อยแล้ว');
            } 
        } 
        return redirect('/zones/'.$idZone);
    }
    public function destroyImage($idImage, $idZone) {
        $image = DB::table('ZoneImage')->where('idZoneImage', $idImage)->first();
        File::delete(public_path() . '/images/' .  $image->pathFile );
        DB::delete('delete from ZoneImage where idZoneImage = ?', [$idImage]);
        session()->flash('deleted', 'ลบรูปสวน เรียบร้อยแล้ว');
        return redirect('/zones/'.$idZone);
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
