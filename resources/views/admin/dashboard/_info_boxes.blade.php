<!-- users count -->
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-orange">
        <div class="inner">
            <h3>{{ $players_count }}</h3>
            <p>Players</p>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a href="{{ route('admin.users.index') }}"
           class="small-box-footer">{{ __('admin/user/title.user_management') }} <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./users count -->

<!-- questions count -->
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green">
        <div class="inner">
            <h3>{{ $questions_count }}</h3>
            <p>Published Questions</p>
        </div>
        <div class="icon">
            <i class="fa fa-question"></i>
        </div>
        <a href="{{ route('admin.questions.index') }}"
           class="small-box-footer">{{ __('admin/question/title.question_management') }} <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./questions count -->

<!-- badges count -->
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-aqua">
        <div class="inner">
            <h3>{{ $badges_count }}</h3>
            <p>Active Badges</p>
        </div>
        <div class="icon">
            <i class="fa fa-trophy"></i>
        </div>
        <a href="{{ route('admin.badges.index') }}"
           class="small-box-footer">{{ __('admin/badge/title.badge_management') }} <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./badges count -->

<!-- levels count -->
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-purple">
        <div class="inner">
            <h3>{{ $levels_count }}</h3>
            <p>Active Levels</p>
        </div>
        <div class="icon">
            <i class="fa fa-level-up"></i>
        </div>
        <a href="{{ route('admin.levels.index') }}"
           class="small-box-footer">{{ __('admin/level/title.level_management') }} <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./levels count -->
