@extends('Home.master')


@section('content')
    <!-- Blog Post Content Column -->
    <div class="col-lg-8">

        <!-- Blog Post -->

        <!-- Title -->
        <h1>{{$course->title}}</h1>

        <!-- Author -->
        <p class="lead small">
            توسط <a href="#">{{ auth()->user()->name}}</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p><span class="glyphicon glyphicon-time"></span> ارسال شده در {{jdate($course->created_at)}}</p>
        <hr>
        <!-- Post Content -->
            {!! $course->body !!}
        <!-- Blog Comments -->
        <hr>

        <!-- Comments -->
        @include('Home.layouts.comment', ['comments'=> $comments, 'subject'=> $course]);
        <!-- End Comments -->
    </div>

    <!-- Blog Sidebar Widgets Column -->
    <div class="col-md-4">
        <div class="well">
            برای استفاده از این دوره نیاز است این دوره را با مبلغ ۱۰۰۰۰ تومان خریداری کنید
            <a href="#">
                <button class="btn btn-success">خرید دوره</button>
            </a>
        </div>
        <!-- Blog Search Well -->
        <div class="well">
            <h4>جستجو در سایت</h4>
            <div class="input-group">
                <input type="text" class="form-control">
                <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
            </div>
            <!-- /.input-group -->
        </div>

        <!-- Side Widget Well -->
        <div class="well">
            <h4>دیوار</h4>
            <p>طراح گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد.</p>
        </div>

    </div>
@endsection
