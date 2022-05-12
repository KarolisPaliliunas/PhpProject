@extends('layouts.layout')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Comments forum</title>



    </head>
    <body>
        <div>
            @if (Route::has('login'))
                <div align="right">
                    @auth
                        <a type="button" class="btn btn-outline-secondary" href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a type="button" class="btn btn-outline-secondary" href="{{ route('login') }}">Log in</a>

                        @if (Route::has('register'))
                            <a type="button" class="btn btn-outline-secondary" href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <h1 class="text-center" class="display-1" style="text-align: center">Comments forum V1</h1>
            <br>
            <div class="text-center">
                <img src="{{ asset('images/mainimage.png') }}" class="img-fluid" alt="no image" width="50%">   
            </div>        
    </body>
</html>
