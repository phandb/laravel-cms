@extends('layouts.blog-home')

@section('content')
<div class="container-fluid w-100">
    <div class="row">
        
            <div class="col-12">

                

        
            </div>
       
    </div>
</div>

    <div class="container">

<div class="row">
   
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            

            <!-- First Blog Post -->
            

            @if($posts)

                @foreach($posts as $post)
                    <h2 ><a  href="/post/{{$post->slug}}">{{ucwords(strtolower($post->title))}}</a></h2>
                    <p class="text-muted"><em> {{ ucwords(strtolower($post->subtitle)) }}</em></p>
                    <p class="text-muted"><em> {{ $post->excerpt }}</em></p>
                    <p class="lead "><small> by {{ $post->author }}</small></p>
                    <p><span class="glyphicon glyphicon-time"></span> {{$post->created_at->diffForHumans()}}</p>
                    
                    
                    <hr>
                    <p class="lead">{!! str_limit($post->content, 500) !!}</p>
                    <a class="btn btn-primary" href="{{route('home.post', $post->slug)}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                   
                    <hr>
                @endforeach

            @endif

            <!-- Pagination -->
            <div class="row">
                <div class="col-sm-6 col-sm-offset-5">
                        {{$posts->render()}}

                </div>
            </div>
            

        </div>

        <!-- Blog Sidebar Widgets Column -->
        @include('includes.front_sidebar')

    </div>
    <!-- /.row -->

    <hr>
@endsection
