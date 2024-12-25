@extends('layouts.index')
@section('content')
<section class="bg-success py-5">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-md-8 text-white">
                <h1>{{$about->title}}</h1>
                <p>
                    {{$about->content}}
                </p>
            </div>
        </div>
    </div>
</section>
<!-- Close Banner -->



@endsection
