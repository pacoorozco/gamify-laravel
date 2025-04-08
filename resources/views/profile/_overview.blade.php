@if($user->present()->bio)
    <blockquote class="blockquote mb-4">
        <p class="mb-0">
            {{ $user->present()->bio }}
        </p>
        <footer class="blockquote-footer">{{ $user->name }}</footer>
    </blockquote>
@endif


<!-- unlocked badges -->
<h3>{{ __('user/profile.unlocked_badges') }}</h3>
<p class="text-muted">{{ __('user/profile.badge_detail_help') }}</p>

<div class="row row-cols-2 row-cols-md-6 mb-4">
    @each('profile._badge_unlocked', $user->unlockedBadges(), 'badge', 'profile._badges_none')
</div>
<!-- ./unlocked badges -->

<!-- locked badges -->
<h3>{{ __('user/profile.locked_badges') }}</h3>

<div class="row row-cols-2 row-cols-md-6">
    @each('profile._badge_locked', $user->lockedBadges(), 'badge', 'profile._badges_none')
</div>
<!-- ./unlocked badges -->




