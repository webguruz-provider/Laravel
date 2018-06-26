@extends('layouts.admin')
@section('content')
    <main class="admin-content__body">
        <section class="admin-content__section">
            <h3 class="admin-content__section-headline">Stat Totals</h3>
            <p class="admin-content__section-desc">
                Highlevel numbers for this ad
            </p>
            <div class="admin-content__stats u-background-white">
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        Impressions
                    </h4>
                    <span class="admin-content__stat-number">
                        11,004
                    </span>
                </div><!-- /admin-content__stat-->
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        Clicks
                    </h4>
                    <span class="admin-content__stat-number">
                        450
                    </span>
                </div><!-- /admin-content__stat-->
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        User Engagement
                    </h4>
                    <span class="admin-content__stat-number">
                        6,003
                    </span>
                </div><!-- /admin-content__stat-->
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        Ad Clicks
                    </h4>
                    <span class="admin-content__stat-number">
                        22
                    </span>
                </div><!-- /admin-content__stat-->
            </div>
        </section><!-- /section-->

        <section class="admin-content__section">
            <h3 class="admin-content__section-headline">Data Breakdown</h3>
            <p class="admin-content__section-desc">
                Explore data for this ad
            </p>

			<debate-table :data="{{$question->debates()->with('question', 'question.category', 'question.author')->get()}}"></debate-table>
        </section>

        <section class="admin-content__section">
            <h3 class="admin-content__section-headline">Users</h3>
            <p class="admin-content__section-desc">
                See a list of all users who have engaged with your question
            </p>
			<user-table :data="{{ $question->debates()->first()->users()->get() }}"></user-table>
        </section>

@endsection