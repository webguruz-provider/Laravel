@extends('layouts.admin')
@section('content')
	<div class="admin-content__body u-background-white">
		<div class="admin-content__table-header">
			<h2 class="admin-content__table-title">
				{{ $title }}
			</h2>
			<div class="admin-content__table-nav">
				<a class="admin-nav__table-nav-link {{ Request::is('partners') ? 'admin-nav__table-nav--active' : '' }}" href="#">
                    Overview
                </a>
                <a class="admin-nav__table-nav-link {{ Request::is('partners') ? 'admin-nav__table-nav--active' : '' }}" href="#">
                    Published
                </a>
                <a class="admin-nav__table-nav-link {{ Request::is('partners') ? 'admin-nav__table-nav--active' : '' }}" href="#">
                    Scheduled
                </a>
                <a class="admin-nav__table-nav-link {{ Request::is('partners') ? 'admin-nav__table-nav--active' : '' }}" href="#">
                    Expired
                </a>
			</div>
		</div>
        <div class='admin-content__table-search u-flex'>
            <input type="text" class="form-control" placeholder="Search questions">
            <a href="#" class="btn btn-green">Create a Question</a>
        </div>
		<div class="prodebatesection">
		<debate-table :data="{{$debates}}"></debate-table>
		</div>
	</div>
@endsection