<div class="row">
    <div class="col-xs-12">
        <blockquote class="blockquote">
            <p class="mb-0">
            {{ $user->present()->bio }}
            </p>
            <footer class="blockquote-footer">{{ $user->name }}</footer>
        </blockquote>

    </div>
</div>

<!-- unlocked badges -->
<h3>@lang('user/profile.unlocked_badges')</h3>

<div class="row">
    @each('profile._badge_unlocked', $user->unlockedBadges(), 'badge', 'profile._badges_none')
</div>
<!-- ./unlocked badges -->

<!-- locked badges -->
<h3>@lang('user/profile.locked_badges')</h3>

<div class="row">
    @each('profile._badge_locked', $user->lockedBadges(), 'badge', 'profile._badges_none')
</div>
<!-- ./unlocked badges -->




