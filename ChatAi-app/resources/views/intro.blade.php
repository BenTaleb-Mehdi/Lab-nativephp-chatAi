@extends('layouts.app')

@section('content')

<canvas id="starfield" class="fixed inset-0 w-full h-full pointer-events-none" style="z-index:0;"></canvas>

<div id="intro" class="relative z-10 flex flex-col items-center justify-center h-screen gap-6">

    {{-- Logo --}}
    <div class="fade-up logo-pulse w-16 h-16 rounded-full flex items-center justify-center"
         style="background:#111; border:1px solid #2a2a2a">
        <svg width="30" height="30" fill="#aaa" viewBox="0 0 24 24">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
    </div>

    {{-- Title --}}
    <p class="fade-up-2 text-2xl font-semibold tracking-tight" style="color:#f0f0f0">
        Welcome to Mehdi By Ai chat
    </p>

    {{-- Loading bar --}}
    <div class="fade-up-3 relative overflow-hidden rounded-full" style="width:160px; height:2px; background:#1a1a1a">
        <div class="bar-fill absolute top-0 h-full rounded-full" style="background:linear-gradient(90deg,transparent,#555,transparent)"></div>
    </div>

</div>



@endsection