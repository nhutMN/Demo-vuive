@extends('layouts.index')
@section('content')
<section class="bg-success py-5">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-md-8 mx-auto text-white">
                <h1 class="mb-4 text-uppercase text-center font-weight-bold">{{ $about->title }}</h1>
                <p class="text-justify mb-4">
                    {{ $about->content }}
                </p>
                <div class="text-center">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.7019647844127!2d106.62024037505363!3d10.773352889375193!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752d11edb450a9%3A0x1cedfab83bdd813d!2zMzA2IEjDsmEgQsOsbmgsIFBow7ogVGjhuqFuaCwgVMOibiBQaMO6LCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e1!3m2!1svi!2s!4v1735384565979!5m2!1svi!2s" 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
