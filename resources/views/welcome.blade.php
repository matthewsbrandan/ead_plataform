<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    
    <link rel="shortcut icon" href="{{ asset('assets/icons/homepage.svg') }}" type="image/svg">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/public_layout/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/public_layout/footer.css') }}">
</head>
<body>
    @include('public_layout.header')
    <main>
        <section class="section-absolute">
            <img src="https://static.wixstatic.com/media/84770f_1a6698b369e4495ea337d92f496f6fb4~mv2.jpg/v1/fill/w_846,h_738,al_t,q_85,usm_0.66_1.00_0.01/84770f_1a6698b369e4495ea337d92f496f6fb4~mv2.webphttps://static.wixstatic.com/media/84770f_1a6698b369e4495ea337d92f496f6fb4~mv2.jpg/v1/fill/w_846,h_738,al_t,q_85,usm_0.66_1.00_0.01/84770f_1a6698b369e4495ea337d92f496f6fb4~mv2.webp"/>
        </section>
        <section class="section-main">
            <div class="content">
                <h2>Private Lessons Online</h2>
                <p class="paragraph">Don't Miss out While You Are Away From School</p>
                <a href="{{ route('login') }}" class="btn-primary">Acessar a Plataforma</a>
            </div>
        </section>
        <section class="section-what-teach">
            <div class="question">
                <h2>What Do I Teach?</h2>
                <p class="paragraph">I'm a paragraph. Click here to add your own text and edit me. It’s easy. Just click “Edit Text” or double click me to add your own content and make changes to the font. </p>
                <a href="#" class="btn-primary">About</a>
            </div>
            <div class="content-matters">
                @foreach($categories as $category)
                    <div>
                        <strong>{{$category->title}}</strong>
                        <div class="matter">
                            <img
                                src="{{$category->wallpaper}}"
                                alt="{{$category->title}}" style="
                                    max-width: 12rem;
                                    max-height: 20rem;
                                    object-fit: cover;
                                "
                            />
                        </div>
                        <small class="paragraph">{{ $category->description }}</small>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="section-testimonial">
            <div class="container">
                <div class="content">
                    <p>“I'm a testimonial. Click to edit me and add text that says something nice about you and your services. Let your customers review you and tell their friends how great you are.”</p>
                    <strong>Lisa, Dina's mom</strong>
                </div>
            </div>
        </section>
    </main>
    @include('public_layout.footer')
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
</body>
</html>