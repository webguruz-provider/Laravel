@extends('layouts.admin')
@section('content')
<header class="admin-content__header u-bg-white">
  <div class="admin-content__header-mast u-flex-center">
    <h2 class="admin-content__header-title"> Dashboard </h2>
    <div class="admin-content__header-actions">
      <div class="admin-content__date-group"> </div>
      <a href="{{ route('partnerAdCreate') }}" class="btn btn-green">Create an Ad</a>
      <a href="{{ route('partnerQuestionCreate') }}" class="btn btn-green">Create a Question</a> </div>
  </div>
</header>
<main class="admin-content__body">
<section class="admin-content__section">
  <h3 class="admin-content__section-headline">Stat Totals</h3>
  <p class="admin-content__section-desc"> Total statistics for all live questions over the last 30 days</p>
  <div class="admin-content__chart u-background-white">
    <question-chart :impressions="[300, 403, 112, 400, 480, 442, 108]" :clicks="[120, 123, 87, 43, 50, 23, 10]" :engagement="[45, 88, 44, 67, 54, 66, 15]" :ads="[41, 29, 15, 34, 12, 5, 88]"></question-chart>
  </div>
</section>
<!-- /section-->

<section class="admin-content__section">
<div class="admin-content__section-header sche-header activity-on new" style="margin-top: 15px;">
  <div>
    <h3 class="admin-content__section-headline activity-head-title">Recently Published Questions</h3>
  </div>
  <div>
    <p class="admin-content__section-desc">
      <!-- <a href="#">View all</a> -->
    </p>
  </div>
</div>
<!--<div class="admin-content__section-header">
  <div>
    <h3 class="admin-content__section-headline">Recently Published Question</h3>
    <p class="admin-content__section-desc"> Explore data fo all live questions over the last 30 days </p>
  </div>
</div>-->
<!-- /admin-content__header-->
<section class="admin-content__section">
  <div class="admin-content__section-header">
  <div class="table-main-scroll"><table class="admin-content__table activity-table">
    <tbody>
    <?php /*echo "<pre>"; print_r($questions[0]->category->name); die();*/   ?>
    @foreach($questions as $latestquestions)
    <tr class="clickable-row">
      <td><span>{{$latestquestions->text}}</span>
        <p>Created by {{ Auth::user()->name }} on {{ \Carbon\Carbon::parse($latestquestions->created_at)->format('M d') }} in {{$latestquestions->category->name}}</p></td>
      <td><span>{{ $latestquestions->debates()->count() }}</span>
        <p>Debates</p></td>
      <td><span>{{ $latestquestions->clicks()->count() }}</span>
        <p>Clicks</p></td>
      <td><span>42</span>
        <p>Ad Clicks</p></td>
    </tr>
    @endforeach
      </tbody>
    
  </table>
</section>
</main>
@endsection