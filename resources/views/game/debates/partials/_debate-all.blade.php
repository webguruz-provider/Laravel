<div class="debate-preview u-background-white">
    <div class="debate-preview__header">
        <h4 class="debate-preview__category">
            Submitted In <strong class="u-text-black">{{ $debate->question->category->name }}</strong>
        </h4>
		<h5 class="debate-preview__category">Submitted By <strong class="u-text-black"><a href="{{ route('publicPlayerShow', $debate->getDebatequestion->getquestionAuther->handle ) }}">{{ $debate->getDebatequestion->getquestionAuther->name }}</a></strong></h5>
        <p class="debate-preview__question-text">
            {{$debate->question->text }}
        </p>
        <small class="debate-preview__question-source <?=(empty($debate->question->source))?'source-hidden':''?>">
            {{$debate->question->medium }} from <strong class="u-text-black">{{$debate->question->source }}</strong>
        </small>
    </div>
    <div class="debate-preview__players u-flex">
        @foreach ($debate->users()->get() as $user)
            <div class="debate-preview__player u-flex-center">
                <div class="debate-preview__player-img">
                    <a href="{{ route('publicPlayerShow', $user->handle) }}">
                        <img class="debate-preview__player-avatar" src="{{ asset('images') }}/{{ $user->avatar_url }}" alt="{{ $user->name }}">
                    </a>
                </div>
                <div class="debate-preview__player-info">
                    <h4 class="debate-preview__player-name">
                        <a class="u-link-black" href="{{ route('publicPlayerShow', $user->handle) }}">
                            {{ $user->handle }}
                        </a>
                    </h4>
                    <small>
                        {{ $user->rank }}
                    </small>
                </div><!-- /player-info-->
            </div>
        @endforeach
    </div>
</div>
