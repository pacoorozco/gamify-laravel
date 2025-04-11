<x-forms.form method="post" :action="route('admin.rewards.badge')">

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-award"></i>
            {{ __('admin/reward/messages.give_badge') }}
        </h3>
    </div>
    <div class="card-body">
        <!-- username -->
        <x-forms.select name='badge_username'
                        :label="__('admin/reward/messages.username')"
                        :options="$users"
                        class="username-input"
                        :required="true"/>
        <!-- ./ username -->

        <!-- badges -->
        <x-forms.select name='badge'
                        :label="__('admin/reward/messages.badge')"
                        :options="$badges"
                        class="badge-input"
                        :required="true"/>
        <!-- ./ badges -->
    </div>
    <div class="card-footer">
        <x-forms.submit type="primary" :value="__('admin/reward/messages.give_badge')"/>
    </div>
</div>

</x-forms.form>
