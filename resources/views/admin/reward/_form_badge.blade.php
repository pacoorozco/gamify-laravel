<x-forms.form method="post" :action="route('admin.rewards.badge')">

<div class="box box-solid">
    <div class="box-header">
        <i class="bi bi-award"></i>
        <h3 class="box-title">{{ __('admin/reward/messages.give_badge') }}</h3>
    </div>
    <div class="box-body">
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
    <div class="box-footer">
        <x-forms.submit type="success" :value="__('admin/reward/messages.give_badge')"/>
    </div>
</div>

</x-forms.form>
