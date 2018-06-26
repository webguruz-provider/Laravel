@extends('layouts.admin')
@section('content')
    <header class="admin-content__header u-bg-white">
      <div class="admin-content__header-mast u-flex-center">
        <h2 class="admin-content__header-title"> Advertiser </h2>
        <div class="admin-content__header-actions">
          <div class="admin-content__date-group sch-group">
            <select id="filter_days" name="filter_days" class="dropdown-button">
              <option value="" selected="selected">All</option>
              <option value="7">Last 7 Days</option>
              <option value="30">Last 30 Days</option>
              <option value="180">Last 180 Days</option>
            </select>
            <a href="{{ route('partnerAdvertiserCreate') }}" class="btn btn-green">Add Advertiser</a>
            </div>
        </div>
      </div>
      <div class="admin-content__header-nav">
      <a href="{{ route('partnerAdvertiserIndex') }}" class="admin-nav__header-nav-link {{ Request::is('partners/advertiser') ? 'admin-nav__header-nav--active' : '' }}">Active</a> 
      
      <a href="{{ route('partnerAdvertiserInactive') }}" class="admin-nav__header-nav-link {{ Request::is('partners/advertiser/inactive') ? 'admin-nav__header-nav--active' : '' }}">Inactive</a>
	  </div>
    </header>
    <main class="admin-content__body">
      <section class="admin-content__section">
        <div class="admin-content__section-header">
          <div class="ques-info">
            <h3 class="admin-content__section-headline">Explore data of all Active Advertisers</h3>
            <!-- <p class="admin-content__section-desc"> Explore data of all Live Ads </p> -->
          </div>
        </div>
        <!-- <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"> -->
          <div class="table-main-scroll"><table class="admin-content__table ad-table3 ad-table2 dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
              <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=": activate to sort column ascending"></th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Company Name : activate to sort column ascending"> Company</th><th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Contact Name : activate to sort column ascending" aria-sort="descending"> Contact</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Contact Phone : activate to sort column ascending"> Phone </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Contact Email : activate to sort column ascending"> Email </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=": activate to sort column ascending"></th></tr>
            </thead>
            <tbody>
            @foreach($advertisers as $advertiser)
            <tr class="clickable-row odd" role="row">
                <td>
                  <form method="POST" action="{{ route('partnerAdvertiserDeactivate', $advertiser->id) }}">
                    <input type="hidden" name="advertiser_id" value="{{ $advertiser->id }}">
                    <button type="submit" name="status" value="deactive"><i aria-hidden="true" class="fa fa-times-circle"></i></button>
                  </form>
                </td>
                <td>{{ $advertiser->company_name }}</td>
                <td class="sorting_1">{{ $advertiser->contact_name }}</td>
                <td class="">{{ $advertiser->phone }}</td>
                <td class="">{{ $advertiser->email }}</td>
                <td>
                  <form method="POST" action="{{ route('partnerAdvertiserEdit', $advertiser->id) }}">
                    <input type="hidden" name="advertiser_id" value="{{ $advertiser->id }}">
                    <button type="submit"><i aria-hidden="true" class="fa fa-caret-right"></i></button>
                  </form>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </section>
    </main>
    @endsection