@extends('layouts.app')
@section('title', 'รูปภาพโซน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รูปภาพโซน</h3>
        </div>
        <div class="card-body">
            @foreach ($zone->images as $image)
                <div class="text-center"> 
                    <a href="{{ asset('images/'.$image->pathFile) }}" data-lity>
                        <img src="{{ asset('images/'.$image->pathFile) }}" style="width:500px;height:500px" class="img-thumbnail">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection