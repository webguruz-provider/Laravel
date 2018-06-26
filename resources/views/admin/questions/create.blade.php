@extends('layouts.admin')
@section('content')
<header class="admin-content__header u-bg-white">
        <div class="admin-content__header-mast u-flex-center">
            <h2 class="admin-content__header-title">Create a Question</h2>
            <div class="admin-content__header-actions">
                <div class="admin-content__date-group">
                </div>               
            </div>
        </div>
        </header>
       
    <div class="admin-content__body u-background-light">        
        <div class="ques-info">
        <label for="text">Question Information</label>
        <!-- <p class="field-description">A short description of question writing best practices will go here <a href="#">Learn More on Question Authoring</a></p> -->
        </div>

        <div class="admin-content__form">
            <form method="POST" action="/partners/questions/store">
                <div class="field field-err">
                    <label for="text">QUESTION TEXT</label>
                    <input type="text" name="text" class="form-control" v-model="form.text" placeholder="Add the text of your question">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @if ($errors->has('text'))
                        <span style="color: red;" class="validation_err">{{ $errors->first('text') }}</span>
                    @endif
                </div>
                <div class="ranged">
                <div class="field field__left field-err">
                    <label for="text">Choose a Category</label>
                    <p class="field-description">Select all topics that apply.</p>
                    <select name="category_id" class="form-control" v-model="form.category_id">
                        <option value="">Pick one</option>
                    @foreach($debate_category as $categories)
                    <option value="{{$categories->id}}">{{$categories->name}}</option>
                    @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <span style="color: red;" class="validation_err">{{ $errors->first('category_id') }}</span>
                    @endif
                </div>
                <div class="field field__right">
                    <label for="text">CHOOSE A PROFILE</label>
                    <p class="field-description">Select the profile you’d like this question to post to</p>
                    <select class="form-control" disabled required="required">
                        <option value="">Pick one</option>
                    </select>
                </div>
                </div>
                <div class="ranged">
                    <div class="field field__left field-err">
                        <label for="text">Publish Date</label>
                        <p class="field-description">Select all topics that apply.</p>
                        <input type="text" name="publish_at" class="form-control" data-calendar-start placeholder="Choose a date to publish your question">
                        @if ($errors->has('publish_at'))
                            <span style="color: red;" class="validation_err">{{ $errors->first('publish_at') }}</span>
                        @endif
                    </div>
                    <div class="field field__right field-err">
                        <label for="text">Expiration Date</label>
                        <p class="field-description">Select all topics that apply.</p>
                        <input type="text" name="expire_at" class="form-control" data-calendar-end placeholder="Choose a date to expire your question">
                        @if ($errors->has('expire_at'))
                            <span style="color: red;" class="validation_err">{{ $errors->first('expire_at') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field field-err col-md-12">
                    <label for="text">Multiple Choice?</label>
                    <input type="checkbox" name="question_type" value="1">
                </div>
                <div class="field-group">
                    <button class="btn btn-green" type="submit" name="status" value="publish">Create a Question</button>
                </div>
                
                <div class="field-group">
                    <button class="btn btn-green" type="submit" name="status" value="draft">Save as Draft</button>
                </div>
            </form>
        </div>




        <section class="admin-content__section"><div class="admin-content__section-header"><div><h3 class="admin-content__section-headline">Recently Added Questions</h3> <p class="admin-content__section-desc">
                        Explore data of all live questions 
                    </p></div></div> 
                    <div class="tab-main">                   
<section id="first-tab-group" class="tabgroup">
                    <div class="table-main-scroll"><table class="admin-content__table ques-tab"><thead><tr>
                        <th class="hide-col">                    
            </th><th class="">
                    Question
            </th><th class="">
                    Author
            </th><th class="">
                    Category
            </th><th class="">
                    Impressions
            </th><th class="">
                    Engagement
            </th><th class="">
                    Expires
            </th><!-- <th class="">
                    Status
            </th> -->
        <th class="hide-col">
            </th></tr></thead> <tbody>



            @foreach($questions as $latest) 
            <tr class="clickable-row">
                <td>
                    <form method="POST" action="{{ route('partnerQuestionUpdate' , $latest->id) }}">
                        <input type="hidden" name="question_id" value="{{$latest->id}}">
                        <button type="submit" name="question_status" value="deactive"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                    </form>
                </td><td>
                    <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                {{$latest->text}}
            </a>
            </td> <td>
                <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                {{ Auth::user()->name }}
            </a>
            </td> <td>
                <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                 {{$latest->category->name}}
             </a>
            </td> <td class="admin-table__large-cell">
                <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                <?php echo $impressions[$latest->id]; ?>
            </a>
            </td> <td class="admin-table__large-cell">
                <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                {{ count(array_unique($user_enganged[$latest->id])) }}
            </a>
            </td> <td>
                <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                  <?php  $created = new \Carbon\Carbon($latest->expire_at);
$now = \Carbon\Carbon::now();
if($created->diff($now)->days < 1)
{
  echo 'today';
}
else
{
  echo 'in '.$created->diffInDays($now).' days';
}
?>
</a>
                
                </td>
            <!-- <td>
                {{$latest->status}}
                </td> -->
                <td>
                    <form method="POST" action="/partners/questions/view/{{$latest->id}}">
                        <input type="hidden" name="question_id" value="{{$latest->id}}">
                        <button type="submit"><i class="fa fa-caret-right" aria-hidden="true"></i></button>
                    </form>
                </td>
            </tr>
                @endforeach
            </table></div>
            </section>
            </div>
            </section>
    </div>


@endsection