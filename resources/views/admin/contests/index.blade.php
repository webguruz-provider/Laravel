@extends('layouts.admin')
@section('content')
    <header class="admin-content__header u-bg-white">
        <div class="admin-content__header-mast u-flex-center">
            <h2 class="admin-content__header-title">
                <?php echo $title;?> 
            </h2>
            <div class="admin-content__header-actions">
                <div class="admin-content__date-group sch-group">
                    @if($view=="live")
                        <!-- <a href="?filter_days=7">Last 7 Days</a>
                        <a href="?filter_days=30">Last 30 Days</a>
                        <a href="?filter_days=180">Last 180 Days</a> -->

                        <select id="filter_days" name="filter_days" class="dropdown-button">
                            <option value="" <?=(!isset($_GET['filter_days']))?"selected":""?>>All</option>
                          <option value="7" <?=(isset($_GET['filter_days']) && $_GET['filter_days']=='7')?"selected":""?>>Last 7 Days</option>
                          <option value="30" <?=(isset($_GET['filter_days']) && $_GET['filter_days']=='30')?"selected":""?>>Last 30 Days</option>
                          <option value="180" <?=(isset($_GET['filter_days']) && $_GET['filter_days']=='180')?"selected":""?>>Last 180 Days</option>
                      </select> 
                            

                    @endif               

                <a href="{{ route('partnerContestCreate') }}" class="btn btn-green">Add Contest</a>
                 </div>
            </div>
        </div>
        <div class="admin-content__header-nav">
            <a class="admin-nav__header-nav-link {{ Request::is('partners/contests') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerContestIndex') }}">
                Live
            </a>
            <a class="admin-nav__header-nav-link {{ Request::is('partners/contests/scheduled') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerScheduledContestIndex') }}">
                Scheduled
            </a>
            <a class="admin-nav__header-nav-link {{ Request::is('partners/contests/expired') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerExpiredContestIndex') }}">
                Expired
            </a>
            <a class="admin-nav__header-nav-link {{ Request::is('partners/contests/deactivated') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerDeactivatedContestIndex') }}">
                Deactivated
            </a>
        </div>
    </header>

    <main class="admin-content__body">
        @if($view=="live")
        <section class="admin-content__section">
            <h3 class="admin-content__section-headline">Stat Totals</h3>
            <p class="admin-content__section-desc">

                Total statistics for all live contests <?=(isset($_GET['filter_days']))?"over the last ".$_GET['filter_days']." days":""?>
                
            </p>
            <div class="admin-content__stats u-background-white">
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        Impressions
                    </h4>
                    <span class="admin-content__stat-number" id="contest_impressions">
                        
                    </span>
                </div><!-- /admin-content__stat-->
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        Contest Clicks
                    </h4>
                    <span class="admin-content__stat-number"  id="contest_clicks">
                        
                    </span>
                </div><!-- /admin-content__stat-->
            </div>
        </section><!-- /section-->

        <section class="admin-content__section">
            <h3 class="admin-content__section-headline">Data Breakdown</h3>
            <p class="admin-content__section-desc">
                 Explore data of all live contests <?=(isset($_GET['filter_days']))?"over the last ".$_GET['filter_days']." days":""?>
            </p>
            <div class="admin-content__chart u-background-white">
                <question-chart :impressions="[300, 403, 112, 400, 480, 442, 108]" :ads="[41, 29, 15, 34, 12, 5, 88]"></question-chart>
            </div>
        </section><!-- /section-->
        @endif



       <section class="admin-content__section">
        <div class="admin-content__section-header">
            
            <div class="ques-info">
                @if($view=="live")
                <h3 class="admin-content__section-headline">Recently Added Contests</h3>
                <p class="admin-content__section-desc">
                    Explore data of all live contests <?=(isset($_GET['filter_days']))?"over the last ".$_GET['filter_days']." days":""?>
                </p>

                @elseif($view=="scheduled")

                <h3 class="admin-content__section-headline">Explore data of all Scheduled Contests <?=(isset($_GET['filter_days']))?"over the last ".$_GET['filter_days']." days":""?></h3>
                <p class="admin-content__section-desc">
                    
                </p>


                @elseif($view=="expired")

                <h3 class="admin-content__section-headline">Explore data of all Expired Contests <?=(isset($_GET['filter_days']))?"over the last ".$_GET['filter_days']." days":""?></h3>
                <p class="admin-content__section-desc">
                    
                </p>
				
				@elseif($view=="deactivated")

                <h3 class="admin-content__section-headline">Explore data of all Deactivated Contests <?=(isset($_GET['filter_days']))?"over the last ".$_GET['filter_days']." days":""?></h3>
                <p class="admin-content__section-desc">
                    
                </p>

                @endif


            </div>          
            
        </div>
        <div class="table-main-scroll"><table class="admin-content__table ad-table3 ad-table2"><thead><tr>
            <th></th>
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
            </th></tr></thead>


             <tbody>
                @foreach($contests as $contest) 
                <tr class="clickable-row">
                    <td>
<form method="POST" action="/partners/contests/deactivate/{{$contest->id}}">
                        <input type="hidden" name="ad_id" value="{{$contest->id}}">
                        <button type="submit" name="status" value="deactive"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                    </form>
                       </td>
                    <td>
                        <img width="100px" src="{{ asset('img-dist/contests') }}/{{$contest->image_url}}" alt="{{$contest->name}}"> {{$contest->name}}
                    </td>
                    <td>
                        {{ Auth::user()->name }}
                    </td>
                    <td class="admin-table__large-cell contest-impressions">
                        {{ $contest->impressions()->count() }}
                        
                    </td>
                    <td class="admin-table__large-cell contest-clicks">
                        {{ $contest->clicks()->count() }}
                    </td>
                    <td>
                        <form method="POST" action="/partners/contests/show/{{$contest->id}}">
                            <input type="hidden" name="ad_id" value="{{$contest->id}}">
                            <button type="submit"><i class="fa fa-caret-right" aria-hidden="true"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($contests->count() == 0)
                <tr><td colspan="8">No record found.</td></tr>

                @endif
            </table></div></section>
    </main>
@endsection