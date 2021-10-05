<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    
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
                <div>
                    <strong>English</strong>
                    <div class="matter">
                        <svg preserveAspectRatio="xMidYMid meet" id="comp-k8ykrxersvgcontent" data-bbox="48.7 61.6 102.6 90.9" viewBox="48.7 61.6 102.6 90.9" height="120" width="120" xmlns="http://www.w3.org/2000/svg" data-type="color" role="img" aria-labelledby="comp-k8ykrxer-svgtitle"><title id="comp-k8ykrxer-svgtitle"></title><g><path fill="#ff7648" d="M75.2 61.6V69l-14.3-7.4v5.9l38.2 13.1-23.9-19z" data-color="1"></path><path fill="#ff7648" d="M139.1 61.6L125 68.9v-7.3l-24.1 19 38.2-13.1v-5.9z" data-color="1"></path><path fill="#192a88" d="M139.1 67.5l-38.2 13.1-.9.3-.9-.3-38.2-13.1-12.2-4.2v71.6l51.3 17.6 51.3-17.6V63.3l-12.2 4.2z" data-color="2"></path></g></svg>
                    </div>
                    <small class="paragraph">I'm a paragraph. Click here to add your own text and edit me. Let your users get to know you.</small>
                </div>
                <div>
                    <strong>Science</strong>
                    <div class="matter">
                        <svg preserveAspectRatio="xMidYMid meet" id="comp-k8x4pibosvgcontent" data-bbox="56.372 51.1 87.854 98.4" viewBox="56.372 51.1 87.854 98.4" height="120" width="120" xmlns="http://www.w3.org/2000/svg" data-type="color" role="img" aria-labelledby="comp-k8x4pibo-svgtitle"><title id="comp-k8x4pibo-svgtitle"></title><g><path d="M142.3 132l-30.4-45.1c-2.1-3.2-3.3-6.9-3.3-10.8V53.4H92v22.7c0 3.8-1.1 7.6-3.3 10.8L58.3 132c-5 7.5.3 17.5 9.3 17.5h65.3c9.1 0 14.4-10 9.4-17.5z" fill="#192a88" data-color="1"></path><path d="M106.8 107.9h-13l-13.1 19.4c-1.8 2.7.1 6.2 3.3 6.2h32.4c3.2 0 5.1-3.6 3.3-6.2l-12.9-19.4z" fill="#fec178" data-color="2"></path><path d="M112.1 51.1H88.6c-4.5 0-8.2 3.7-8.2 8.2 0 4.5 3.7 8.2 8.2 8.2h23.5c4.5 0 8.2-3.7 8.2-8.2 0-4.5-3.7-8.2-8.2-8.2z" fill="#192a88" data-color="1"></path></g></svg>
                    </div>
                    <small class="paragraph">I'm a paragraph. Click here to add your own text and edit me. Let your users get to know you.</small>
                </div>
                <div>
                    <strong>History</strong>
                    <div class="matter">
                        <svg preserveAspectRatio="xMidYMid meet" id="comp-k8x4ntqzsvgcontent" data-bbox="47.1 74 105.701 62.3" viewBox="47.1 74 105.701 62.3" height="120" width="120" xmlns="http://www.w3.org/2000/svg" data-type="color" role="img" aria-labelledby="comp-k8x4ntqz-svgtitle"><title id="comp-k8x4ntqz-svgtitle"></title><g><path d="M119.1 92.2H80.9c-.5 6.4-4.5 11.8-10.1 14.3v29.8h7.9V112c0-2.4 1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3v24.2h8.4V112c0-2.4 1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3v24.2h8.7V112c0-2.4 1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3v24.2h7.9v-29.8c-5.9-2.3-9.9-7.8-10.4-14.2z" fill="#ff7648" data-color="1"></path><path d="M137.2 74.1l-8-.1H64c-9.3 0-16.9 7.6-16.9 16.9 0 9.3 7.6 16.9 16.9 16.9 2.4 0 4.7-.5 6.7-1.4 5.6-2.4 9.7-7.9 10.1-14.3h38.3c.5 6.4 4.5 11.8 10.1 14.3 2.1.9 4.3 1.4 6.7 1.4 9.3 0 16.9-7.6 16.9-16.9.1-8.9-6.8-16.2-15.6-16.8zM64 97c-3.3 0-6-2.7-6-6s2.7-6 6-6 6 2.7 6 6-2.7 6-6 6zm72 0c-3.3 0-6-2.7-6-6s2.7-6 6-6 6 2.7 6 6-2.7 6-6 6z" fill="#fec178" data-color="2"></path><path fill="#ff7648" d="M70 91a6 6 0 11-12 0 6 6 0 0112 0z" data-color="1"></path><path fill="#ff7648" d="M142 91a6 6 0 11-12 0 6 6 0 0112 0z" data-color="1"></path><path d="M82.9 107.8c-2.4 0-4.3 1.9-4.3 4.3v24.2h8.6V112c0-2.3-1.9-4.2-4.3-4.2z" fill="#fec178" data-color="2"></path><path d="M117.1 107.8c-2.4 0-4.3 1.9-4.3 4.3v24.2h8.6V112c0-2.3-1.9-4.2-4.3-4.2z" fill="#fec178" data-color="2"></path><path d="M99.8 107.8c-2.4 0-4.3 1.9-4.3 4.3v24.2h8.6V112c0-2.3-1.9-4.2-4.3-4.2z" fill="#fec178" data-color="2"></path></g></svg>
                    </div>
                    <small class="paragraph">I'm a paragraph. Click here to add your own text and edit me. Let your users get to know you.</small>
                </div>
                <div>
                    <strong>Math</strong>
                    <div class="matter">
                        <svg preserveAspectRatio="xMidYMid meet" id="comp-k8ykrznqsvgcontent" data-bbox="68.2 69.1 63.6 63.7" viewBox="68.2 69.1 63.6 63.7" height="120" width="120" xmlns="http://www.w3.org/2000/svg" data-type="color" role="img" aria-labelledby="comp-k8ykrznq-svgtitle"><title id="comp-k8ykrznq-svgtitle"></title><g><path d="M131.8 100.9c0-17.6-14.2-31.8-31.8-31.8-8.8 0-16.7 3.6-22.5 9.3l45 45c5.7-5.7 9.3-13.7 9.3-22.5z" fill="#8f98ff" data-color="1"></path><path d="M77.5 78.5l-9.3-9.3v63.6h63.6l-9.3-9.3-45-45zm1.7 43.3v-26l26 26h-26z" fill="#192a88" data-color="2"></path><path fill="#8f98ff" d="M79.2 95.8v26h26l-26-26z" data-color="1"></path></g></svg>
                    </div>
                    <small class="paragraph">I'm a paragraph. Click here to add your own text and edit me. Let your users get to know you.</small>
                </div>
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
</body>
</html>