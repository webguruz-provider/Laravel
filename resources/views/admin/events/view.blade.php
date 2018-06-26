@extends('layouts.admin')
@section('content')
<div class="admin-content__body u-background-light">
  <!-- <div class="admin-content__table-header">
    <h2 class="admin-content__table-title"> Stats for May 1, 2017 - May 7, 2017 </h2>
  </div> -->
  <div class="header-title">
  <div class="ques-info">
    <label for="text">Event Creative</label>
    <p class="field-description">This is what users see when scrolling through the main feed</p>
  </div>
</div>
<div class="admin-content__form ad-main">
      <div class="field ad-field">
        <div class="field-inner">
        <div class="admin-content__section-header sche-header quest-view1">
        <div><h3 style="font-weight:500;">{{$editad->name}}</h3></div>
        <div><p class="admin-content__section-desc">
<form method="POST" action="/partners/events/edit/{{$editad->id}}">
                        <input type="hidden" name="ad_id" value="{{$editad->id}}">
                        <button type="submit" class="white-button">Modify event</button>
                    </form>
          </p></div>
          <!----></div>
          </div>
      </div>
      <div class="ranged">
        <div class="field field__left">
          <div class="ad-img"><img src="{{ asset('img-dist/events/'.$editad->image_url) }}" /></div>          
        </div>
        <div class="field field__right">
                <p class="field-description first-line"><strong>About events</strong></p>
                <p class="field-description">Many stations and podcasts run events. Use this section to integrate you current events into your pro profile to help listeners find and participate in these rewards. </p>

                </div>
      </div> 
      <div class="ad-bottom-deact-sec">
      <span>Author: {{ Auth::user()->name }}</span> <span>Published: {{ \Carbon\Carbon::parse($editad->publish_at)->format('M d, Y')}} </span><span>
        <form method="POST" action="/partners/events/deactivate/{{$editad->id}}">
                        <input type="hidden" name="ad_id" value="{{$editad->id}}">
                        <button type="submit" name="status" value="deactive" class="white-button"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                    </form></span>
      </div>
  </div>
<section class="admin-content__section"><h3 class="admin-content__section-headline">Stat Totals</h3> <p class="admin-content__section-desc">
                Highlevel numbers for this event
            </p> <div class="admin-content__stats u-background-white"><div class="admin-content__stat"><h4 class="admin-content__stat-label">
                        Impressions
                    </h4> <span class="admin-content__stat-number">
                        
                        {{ $editad->impressions()->count() }}
                    </span></div>  <div class="admin-content__stat"><h4 class="admin-content__stat-label">
                        event Clicks
                    </h4> <span class="admin-content__stat-number">
                        {{ $editad->clicks()->count() }}
                    </span></div>
                 </div></section> <section class="admin-content__section"><h3 class="admin-content__section-headline">Data Breakdown</h3> <p class="admin-content__section-desc">
                Explore data for this event
            </p> <div class="admin-content__chart u-background-white">
                <question-chart :impressions="[300, 403, 112, 400, 480, 442, 108]"  :ads="[41, 29, 15, 34, 12, 5, 88]"></question-chart>
            </div></section>
            <section class="admin-content__section"><div class="admin-content__section-header">
            <div class="header-title">
            <div class="ques-info">
            <h3 class="admin-content__section-headline">Recently Added events</h3> <p class="admin-content__section-desc">
                        Explore data of all live events
                    </p>
                    </div>
                  </div>
                  </div> <div class="table-main-scroll"><table class="admin-content__table ad-promo-table"><thead><tr>
                        <th class="">
                    CREATIVE
            </th><th class="">
                    AUTHOR
            </th><th class="">
                    IMPRESSIONS
            </th><th class="">
                    CLICKS
            </th>
        <th class="">
            </th></tr></thead> <tbody>

            @foreach($events as $event) 
            <tr class="clickable-row">
               <td>
                <img width="100px" src="{{ asset('img-dist/events') }}/{{$event->image_url}}" alt="{{$event->name}}"> {{$event->name}}
            </td> <td>
                {{ Auth::user()->name }}
            </td>  <td class="admin-table__large-cell">
                
                {{ $event->impressions()->count() }}
            </td>
            <td class="admin-table__large-cell">
                {{ $event->clicks()->count() }}
            </td>
                <td>
                    <form method="POST" action="/partners/events/show/{{$event->id}}">
                        <input type="hidden" name="ad_id" value="{{$event->id}}">
                        <button type="submit"><i class="fa fa-caret-right" aria-hidden="true"></i></button>
                    </form>
                </td>
            </tr>
                @endforeach

               
            </table></div></section>
          </div>
@endsection