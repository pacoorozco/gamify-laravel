<x-forms.form method="post" :action="route('admin.rewards.experience')">

    <div class="box box-solid">
        <div class="box-header">
            <i class="bi bi-arrow-up-circle-fill"></i>
            <h3 class="box-title">{{ __('admin/reward/messages.give_experience') }}</h3>
        </div>
        <div class="box-body">

            <!-- username -->
            <x-forms.select name='username'
                            :label="__('admin/reward/messages.username')"
                            :options="$users"
                            class="username-input"
                            :required="true"/>
            <!-- ./ username -->

            <!-- points -->
            <x-forms.select name='points'
                            :label="__('admin/reward/messages.points')"
                            :options="[
                '5' => __('admin/reward/messages.points_value', ['points' => '5']),
                '10' => __('admin/reward/messages.points_value', ['points' => '10']),
                '25' => __('admin/reward/messages.points_value', ['points' => '25']),
                ]"
                            value="5"
                            :required="true"/>
            <!-- ./ points -->

            <!-- message -->
            <x-forms.textarea name="message"
                              :label="__('admin/reward/messages.why_u_reward')"
                              :required="true"/>
            <!-- ./ message -->
        </div>
        <div class="box-footer">
            <x-forms.submit type="success" :value="__('admin/reward/messages.give_experience')"/>
        </div>
    </div>

</x-forms.form>



